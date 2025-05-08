# Profile Settings

## Admin Profile Setting
Controller : `App\Http\Controller\Auth\Admin\AdminProfileController`

### Route
Middleware: **auth**, **role:admin**, **verified**
- `GET /admin/dashboard/profile` - nampilin view ke admin.profile (nama route: `admin.dashboard.profile`)
- `POST /admin/dashboard/profile` - submit form (nama route: `admin.dashboard.profile.submit`)

### Nama Field dan Validasi
- `nama_depan` - tidak boleh kosong, minimal 3 karakter, maksimal 255 karakter
- `nama_belakang` - tidak boleh kosong, minimal 3 karakter, maksimal 255 karakter
- `email` - tidak boleh kosong, format email, unik
- `no_telepon` - tidak boleh kosong, regex: 08sekian 8-11 digit, unik
- `avatar` - image, tipe: jpg, jpeg, png. Kalo bisa rasio 1:1 (pake library biar pengguna bisa crop foto)

### Controller Behavior
Kalo email diubah, bakal ngirim email verifikasi ke email baru. Email pengguna ga bakal diubah sampai pengguna mencet link verifikasi email baru.

### Error/Session Yang Dikirim
- Error validasi kalo ga bener (sesuai nama field)
- Session `success`: ngirim message `Informasi profil Anda telah diperbarui.` kalo profil sukses diubah
- Session `email`: Kalo ngubah email, bakal ada email verifikasi lagi ke email baru 

## Nasabah Profile Setting
Controller : `App\Http\Controller\Auth\Admin\NasabahProfileController`

### Route
Middleware: **auth**, **role:admin**, **verified**
- `GET /adashboard/profile` - nampilin view ke admin.profile (nama route: `nasabah.dashboard.profile`)
- `POST /adashboard/profile` - submit form (nama route: `nasabah.dashboard.profile.submit`)

### Nama Field dan Validasi
- `nama_depan` - tidak boleh kosong, minimal 3 karakter, maksimal 255 karakter
- `nama_belakang` - tidak boleh kosong, minimal 3 karakter, maksimal 255 karakter
- `email` - tidak boleh kosong, format email, unik
- `alamat` - string
- `metode_pembayaran_utama` - dibikin dropdown aja. Isinya ewallet semua
- `no_telepon` - tidak boleh kosong, regex: 08sekian 8-11 digit, unik
- `avatar` - image, tipe: jpg, jpeg, png. Kalo bisa rasio 1:1 (pake library biar pengguna bisa crop foto)

### Controller Behavior
Kalo email diubah, bakal ngirim email verifikasi ke email baru. Email pengguna ga bakal diubah sampai pengguna mencet link verifikasi email baru.

### Error/Session Yang Dikirim
- Error validasi kalo ga bener (sesuai nama field)
- Session `success`: ngirim message `Informasi profil Anda telah diperbarui.` kalo profil sukses diubah
- Session `email`: Kalo ngubah email, bakal ada email verifikasi lagi ke email baru 
