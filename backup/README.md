# APS One Backup

Folder ini berisi script backup harian untuk project Laravel APS One.

## File

- `backup_apsone.sh` — backup database + file foto/assets + source code, lalu upload ke Google Drive via rclone.
- `files/` — hasil backup lokal, otomatis dibuat saat script jalan.
- `logs/` — log backup, otomatis dibuat saat script jalan.

## Yang Dibackup

1. Database MySQL dari konfigurasi `.env`:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`

2. File foto/assets dari:
   - `public/`
   - `storage/app/`

3. Source code project Laravel, tanpa file berat/sensitif:
   - exclude `vendor/`
   - exclude `node_modules/`
   - exclude `.git/`
   - exclude `.env`
   - exclude hasil backup/log

## Yang Tidak Ikut Dibackup

- `vendor/`
- `node_modules/`
- `.git/`
- `.env`
- `backup/files/`
- `backup/logs/`
- cache/session/log Laravel

## Requirement

Install rclone:

```bash
sudo apt update
sudo apt install -y rclone
```

Setup Google Drive:

```bash
rclone config
```

Gunakan remote name:

```text
gdrive
```

Test:

```bash
rclone lsd gdrive:
```

## Manual Run

```bash
chmod +x /home/ubuntu/project-work-uaps/backup/backup_apsone.sh
/home/ubuntu/project-work-uaps/backup/backup_apsone.sh
```

## Cron Jam 12 Malam Setiap Hari

Edit cron:

```bash
crontab -e
```

Tambahkan:

```cron
0 0 * * * /home/ubuntu/project-work-uaps/backup/backup_apsone.sh >/dev/null 2>&1
```

Cek cron:

```bash
crontab -l
```

## Cek Log

```bash
tail -100 /home/ubuntu/project-work-uaps/backup/logs/backup.log
```

## Folder Google Drive

Default upload ke:

```text
gdrive:Backups/apsone/YYYY-MM-DD/
```

Contoh isi folder harian:

```text
Backups/apsone/2026-05-23/apsone_database_2026-05-23_21-53-09.sql.gz
Backups/apsone/2026-05-23/apsone_assets_2026-05-23_21-53-09.tar.gz
Backups/apsone/2026-05-23/apsone_code_2026-05-23_21-53-09.tar.gz
```

## Retention

Default:

- Backup lokal: 7 hari
- Backup Google Drive: 30 hari

Bisa override saat run:

```bash
LOCAL_RETENTION_DAYS=14 GDRIVE_RETENTION_DAYS=60 /home/ubuntu/project-work-uaps/backup/backup_apsone.sh
```
