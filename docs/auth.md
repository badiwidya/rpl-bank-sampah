# Autentikasi

## Registrasi
Controller : `App\Http\Controller\Auth\RegisterController`

### Route
Middleware: **guest**
- `GET /register` - nampilin view ke auth.register (nama route: `nasabah.register.show`)
- `POST /register` - submit form (nama route: `nasabah.register.submit`)

### Nama Field dan Validasi
- `nama` - tidak boleh kosong, minimal 3 karakter, maksimal 255 karakter
- `email` - tidak boleh kosong, format email, unik
- `no_telepon` - tidak boleh kosong, regex: 08sekian 8-11 digit, unik
- `password` - tidak boleh kosong, minimal 8 karakter, harus ada setidaknya 1 huruf dan 1 angka
- `password_confirmation` - untuk konfirmasi password

### Error/Session Yang Dikirim
Ga ada. cuma error validasi doang sesuai nama field

## Verifikasi Email
Controller: `App\Http\Controller\Auth\UserEmailVerificationController`

Notification: `App\Notifications\UserVerification`

### Route
Middleware: **auth**, **unverified**
- `GET /email/verify` - nampilin view notifikasi cek email (auth.email-notify), jadi isinya cuma "Link verifikasi telah dikirimkan, silakan cek inbox email Anda." sama button buat Resend (nama route: `mail.verification.notice`)
- `GET /email/verify/{hash}/{id}` - ini format link yang bakal didapet user di emailnya, dan buat verifikasi juga (nama route: `mail.verification.verify`) 
- `POST /email/verify` - buat resend email (nama route: `mail.verification.resend`)

### Error/Session Yang Dikirim
- Page `419`: `Expired or invalid link`
- Page `403`: `Forbidden`
- Session `error` ke view `auth.email-notify`: Rate limit
- Session `success` ke view `auth.email-notify`: Resend berhasil

## Login & Logout
Controller: `App\Http\Controller\Auth\SessionController`

### Route
Middleware: **guest**
- `GET /login` - nampilin halaman pilihan untuk login nasabah/admin (nama route: `auth.login.choice`)
- `GET /nasabah/login` - nampilin halaman login nasabah (nama route: `nasabah.login.show`)
- `POST /nasabah/login` - submit login nasabah (nama route: `nasabah.login.submit`)
- `GET /admin/login` - nampilin halaman login admin (nama route: `admin.login.show`)
- `POST /admin/login` - submit login admin (nama route: `admin.login.submit`)
- `POST /logout` - logout user (nama route: `auth.logout`)

### Field dan Validasi
- `login` - Ini bisa email/nomor telepon
- `password`

### Error/Session Yang Dikirim
- Session `login`: ada dua error yang dikirim sebagai session `login` -> kredensial invalid sama rate limit ke semua view login
- Session `wrong_route`: nampilin `Silakan login sebagai {role}` kalo salah tempat login
- Sisanya error validasi sesuai nama field 

## Forgot Password
Controller: `App\Http\Controller\Auth\ForgotPasswordController`

### Route
Middleware: **guest**

- `GET /forgot-password` - nampilin view untuk ngisi email (nama route: `auth.password.request`)
- `POST /forgot-password` - handle form untuk ngirim email isi link reset password (nama route: `auth.password.email`)
- `GET /reset-password/{token}` - nampilin form reset password (password baru) (nama route: `auth.password.reset`)
- `POST /reset-password` - handle update password user (nama route: `auth.password.update`)

### Error/Session Yang Dikirim
- `status`
- `email`