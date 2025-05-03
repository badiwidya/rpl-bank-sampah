# Autentikasi

## Registrasi

### Route
Middleware: **guest** (otw)
- `GET /register` return view ke auth.register
- `POST /register` submit form

### Nama Field dan Validasi
- `nama` - tidak boleh kosong, minimal 3 karakter, maksimal 255 karakter
- `email` - tidak boleh kosong, format email, unik
- `no_telepon` - tidak boleh kosong, regex: 08sekian 8-11 digit, unik
- `password` - tidak boleh kosong, minimal 8 karakter, harus ada setidaknya 1 huruf dan 1 angka
- `password_confirmation` - untuk konfirmasi password