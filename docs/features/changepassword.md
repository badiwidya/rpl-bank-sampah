# Change Password

Controller : `App\Http\Controller\Auth\ChangePasswordController`

### Route
- `GET /admin/dashboard/profile/change-password` - nampilin view ke auth.change-password (nama route: `admin.dashboard.password`)
- `POST /admin/dashboard/profile/change-password` - submit form (nama route: `admin.dashboard.password.submit`)
- `GET /dashboard/profile/change-password` - nampilin view ke auth.change-password (nama route: `nasabah.dashboard.password`)
- `POST /dashboard/profile/change-password` - submit form (nama route: `nasabah.dashboard.password.submit`)

### Nama Field dan Validasi
- `old_password` - password lama user
- `password` - password baru user
- `password_confirmation` - konfirmasi password baru user

### Controller Behavior
Email notifikasi bakal dikirim kalo user ganti password

### Error/Session Yang Dikirim
- Error validasi kalo ga bener (sesuai nama field)
- Session `success`: ngirim message `Informasi profil Anda telah diperbarui.` kalo profil sukses diubah
- Session `rate_limit`: kalo ngirim request dengan old_password salah lebih dari 5 kali dalam semenit

### Response Controller
redirect ke view profile setting ngebawa session `success` yang isinya pesan password berhasil diubah.
