- `views/admin/index.blade.php` | `admin.index` -> Dashboard admin
- `views/admin/profile.blade.php` | `admin.profile` -> Profile settings admin
- `views/nasabah/index.blade.php` | `nasabah.index` -> Dashboard nasabah
- `views/nasabah/profile.blade.php` | `nasabah.profile` -> Profile settings nasabah
- `views/auth/admin-login.blade.php` | `auth.admin-login` -> Form login buat admin
- `views/auth/nasabah-login.blade.php` | `auth.nasabah-login` -> Form login buat nasabah
- `views/auth/login.blade.php` | `auth.login` -> Pilihan login ke admin/nasabah
- `views/auth/register.blade.php` | `auth.register` -> Form register
- `views/auth/forgot-password.blade.php` | `auth.forgot-password` -> Ini isinya input email buat kirim email lupa password (udah ada contohnya di dalem)
- `views/auth/reset-password.blade.php` | `auth.reset-password` -> Form buat reset password (password baru sama konfirmasi password baru) (udah ada contohnya di dalem)
- `views/auth/email-notify.blade.php` | `auth.email-notify` -> Ini isinya cuma pemberitahuan biar user cek email mereka, sama tombol resend verifikasi email
- `views/auth/change-password.blade.php` | `auth.change-password` -> Form buat ganti password (udah ada contohnya di dalem)

Nah untuk landing page, bisa ditaro di `views/welcome.blade.php` atau bikin file baru aja kalo mau. Jangan lupa ganti di `web/routes.php` di bagian 

```php
Route::get('/', function () {
    return view('welcome');
});
```

`welcome` nya bisa diganti jadi nama view baru. Misal view baru disimpen di `views/landing-page.blade.php` ganti `welcome` jadi `landing-page`.