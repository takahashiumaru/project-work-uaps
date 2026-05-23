#!/usr/bin/env bash
set -euo pipefail

# ============================================================
# APS One Daily Backup Script
# Backup database + assets + source code, then upload to Google Drive via rclone.
#
# Requirements:
# - mysqldump
# - gzip / tar
# - rclone configured with remote name: gdrive
#
# Manual run:
#   /home/ubuntu/project-work-uaps/backup/backup_apsone.sh
#
# Cron example, daily 00:00:
#   0 0 * * * /home/ubuntu/project-work-uaps/backup/backup_apsone.sh >/dev/null 2>&1
# ============================================================

APP_NAME="apsone"
APP_DIR="/home/ubuntu/project-work-uaps"
ENV_FILE="${APP_DIR}/.env"

# Local backup output folder. Keep outside public folder.
BACKUP_DIR="${APP_DIR}/backup/files"
LOG_DIR="${APP_DIR}/backup/logs"
LOG_FILE="${LOG_DIR}/backup.log"

# Google Drive rclone destination.
# Change these if your rclone remote/folder is different.
GDRIVE_REMOTE="${GDRIVE_REMOTE:-gdrive}"
GDRIVE_DIR="${GDRIVE_DIR:-Backups/apsone}"

# Retention policy.
LOCAL_RETENTION_DAYS="${LOCAL_RETENTION_DAYS:-7}"
GDRIVE_RETENTION_DAYS="${GDRIVE_RETENTION_DAYS:-30}"

DATE="$(date +'%Y-%m-%d_%H-%M-%S')"
BACKUP_DATE="$(date +'%Y-%m-%d')"
DB_BACKUP="${BACKUP_DIR}/${APP_NAME}_database_${DATE}.sql.gz"
ASSETS_BACKUP="${BACKUP_DIR}/${APP_NAME}_assets_${DATE}.tar.gz"
CODE_BACKUP="${BACKUP_DIR}/${APP_NAME}_code_${DATE}.tar.gz"
GDRIVE_DAILY_DIR="${GDRIVE_DIR}/${BACKUP_DATE}"

log() {
  echo "[$(date +'%Y-%m-%d %H:%M:%S')] $*" | tee -a "${LOG_FILE}"
}

fail() {
  log "ERROR: $*"
  exit 1
}

read_env_value() {
  local key="$1"
  grep -E "^${key}=" "${ENV_FILE}" | tail -n 1 | cut -d '=' -f2- | sed 's/^"//; s/"$//; s/^'\''//; s/'\''$//'
}

prepare() {
  mkdir -p "${BACKUP_DIR}" "${LOG_DIR}"
  touch "${LOG_FILE}"
  chmod 700 "${APP_DIR}/backup" || true
  chmod 700 "${BACKUP_DIR}" "${LOG_DIR}" || true
  chmod 600 "${LOG_FILE}" || true

  [ -d "${APP_DIR}" ] || fail "APP_DIR not found: ${APP_DIR}"
  [ -f "${ENV_FILE}" ] || fail ".env not found: ${ENV_FILE}"
  command -v mysqldump >/dev/null 2>&1 || fail "mysqldump not installed"
  command -v gzip >/dev/null 2>&1 || fail "gzip not installed"
  command -v tar >/dev/null 2>&1 || fail "tar not installed"
  command -v rclone >/dev/null 2>&1 || fail "rclone not installed/configured"
}

backup_database() {
  local db_host db_port db_name db_user db_pass

  db_host="$(read_env_value DB_HOST)"
  db_port="$(read_env_value DB_PORT)"
  db_name="$(read_env_value DB_DATABASE)"
  db_user="$(read_env_value DB_USERNAME)"
  db_pass="$(read_env_value DB_PASSWORD)"

  db_host="${db_host:-127.0.0.1}"
  db_port="${db_port:-3306}"

  [ -n "${db_name}" ] || fail "DB_DATABASE is empty in .env"
  [ -n "${db_user}" ] || fail "DB_USERNAME is empty in .env"

  log "[1/6] Backup database started: ${db_name}@${db_host}:${db_port}"

  MYSQL_PWD="${db_pass}" mysqldump \
    -h "${db_host}" \
    -P "${db_port}" \
    -u "${db_user}" \
    --single-transaction \
    --quick \
    --lock-tables=false \
    --no-tablespaces \
    --routines \
    --triggers \
    "${db_name}" | gzip > "${DB_BACKUP}"

  test -s "${DB_BACKUP}" || fail "Database backup file is empty"
  gzip -t "${DB_BACKUP}" || fail "Database backup gzip verification failed"

  log "Database backup OK: ${DB_BACKUP}"
}

backup_assets() {
  log "[2/6] Backup public + storage assets started"

  tar -czf "${ASSETS_BACKUP}" \
    -C "${APP_DIR}" \
    --exclude='storage/app/private' \
    --exclude='storage/app/*.sqlite' \
    --exclude='storage/app/**/*.sqlite' \
    --exclude='storage/app/**/*.sql' \
    --exclude='storage/app/**/*.log' \
    --exclude='storage/app/public/framework/*' \
    --exclude='storage/app/public/cache/*' \
    public \
    storage/app

  test -s "${ASSETS_BACKUP}" || fail "Assets backup file is empty"
  tar -tzf "${ASSETS_BACKUP}" >/dev/null || fail "Assets backup tar verification failed"

  log "Assets backup OK: ${ASSETS_BACKUP}"
}

backup_code() {
  log "[3/6] Backup source code started"

  tar -czf "${CODE_BACKUP}" \
    -C "$(dirname "${APP_DIR}")" \
    --exclude="project-work-uaps/vendor" \
    --exclude="project-work-uaps/node_modules" \
    --exclude="project-work-uaps/.git" \
    --exclude="project-work-uaps/.env" \
    --exclude="project-work-uaps/backup/files" \
    --exclude="project-work-uaps/backup/logs" \
    --exclude="project-work-uaps/backup/gdrive-service-account.json" \
    --exclude="project-work-uaps/storage/logs/*.log" \
    --exclude="project-work-uaps/storage/framework/cache/*" \
    --exclude="project-work-uaps/storage/framework/views/*" \
    --exclude="project-work-uaps/storage/framework/sessions/*" \
    "project-work-uaps"

  test -s "${CODE_BACKUP}" || fail "Code backup file is empty"
  tar -tzf "${CODE_BACKUP}" >/dev/null || fail "Code backup tar verification failed"

  log "Code backup OK: ${CODE_BACKUP}"
}

upload_to_gdrive() {
  log "[4/6] Upload to Google Drive started"

  rclone mkdir "${GDRIVE_REMOTE}:${GDRIVE_DAILY_DIR}" --log-file "${LOG_FILE}" --log-level INFO

  rclone copy "${DB_BACKUP}" "${GDRIVE_REMOTE}:${GDRIVE_DAILY_DIR}" \
    --transfers 2 \
    --checkers 4 \
    --log-file "${LOG_FILE}" \
    --log-level INFO

  rclone copy "${ASSETS_BACKUP}" "${GDRIVE_REMOTE}:${GDRIVE_DAILY_DIR}" \
    --transfers 2 \
    --checkers 4 \
    --log-file "${LOG_FILE}" \
    --log-level INFO

  rclone copy "${CODE_BACKUP}" "${GDRIVE_REMOTE}:${GDRIVE_DAILY_DIR}" \
    --transfers 2 \
    --checkers 4 \
    --log-file "${LOG_FILE}" \
    --log-level INFO

  log "Upload to Google Drive OK: ${GDRIVE_REMOTE}:${GDRIVE_DIR}"
}

cleanup_old_backups() {
  log "[5/6] Cleanup old local backups"

  find "${BACKUP_DIR}" -type f -name "${APP_NAME}_database_*.sql.gz" -mtime +"${LOCAL_RETENTION_DAYS}" -delete
  find "${BACKUP_DIR}" -type f -name "${APP_NAME}_assets_*.tar.gz" -mtime +"${LOCAL_RETENTION_DAYS}" -delete
  find "${BACKUP_DIR}" -type f -name "${APP_NAME}_code_*.tar.gz" -mtime +"${LOCAL_RETENTION_DAYS}" -delete

  log "[6/6] Cleanup old Google Drive backups"

  rclone delete "${GDRIVE_REMOTE}:${GDRIVE_DIR}" \
    --min-age "${GDRIVE_RETENTION_DAYS}d" \
    --log-file "${LOG_FILE}" \
    --log-level INFO || true

  log "Cleanup OK"
}

main() {
  prepare
  log "========================================"
  log "Backup started"
  backup_database
  backup_assets
  backup_code
  upload_to_gdrive
  cleanup_old_backups
  log "Backup finished successfully"
  log "Database file: ${DB_BACKUP}"
  log "Assets file: ${ASSETS_BACKUP}"
  log "Code file: ${CODE_BACKUP}"
  log "Google Drive folder: ${GDRIVE_REMOTE}:${GDRIVE_DAILY_DIR}"
}

main "$@"
