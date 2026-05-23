# Production Optimization Notes

Optimasi ini dipakai untuk deployment Laravel APS di VPS kecil tanpa Redis/Docker.

## Yang Diaktifkan

1. PHP OPcache production tuning
   - `opcache.memory_consumption=128`
   - `opcache.interned_strings_buffer=16`
   - `opcache.max_accelerated_files=10000`
   - `opcache.validate_timestamps=0`
   - Wajib restart PHP-FPM setelah deploy.

2. Nginx static asset cache
   - Asset CSS/JS/image/font dicache browser selama 30 hari.
   - Header: `Cache-Control: public, max-age=2592000, immutable`.
   - Laravel route tetap `no-cache` agar halaman dinamis aman.

3. Gzip text assets
   - Aktif untuk HTML/text/CSS/JS/JSON/XML/SVG.

4. Laravel optimization
   - `php artisan config:cache`
   - `php artisan route:cache`
   - `php artisan optimize`

## Kenapa Tidak Pakai Redis Dulu

Server RAM 2GB sudah menjalankan beberapa service. Redis bisa ditambahkan nanti kalau traffic naik, tapi untuk sekarang optimasi tanpa service baru lebih aman.

## Verifikasi

```bash
php -i | grep -E "opcache.validate_timestamps|opcache.memory_consumption"
curl -I https://apsone.web.id/storage/aps_mini.png | grep Cache-Control
curl -I https://apsone.web.id
sudo systemctl status php8.3-fpm nginx
```
