# Middleware

1. `auth` - ini middleware autentikasi bawaan laravel
2. `guest` - gua override biar kalo user terautentikasi ngakses ini langsung dialihkan ke masing-masing dashboard
3. `verified` - kalo user emailnya belum tervefirikasi, langsung arahin ke rute email notice
4. `unverified` - kalo user emailnya udah terverifikasi, arahin ke dashboard masing-masing
5. `role` - proteksi rute berdasarkan role, kalo ga sesuai throw http status 403 (forbidden)