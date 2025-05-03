# Database Schema

> Semua ID (primary key) dari tabel ga disebut karena BigInt autoincrement dari Laravel langsung

> Sama `timestamps` (`created_at` & `updated_at`)

### users
- `nama`
- `email`: unik
- `no_telepon`: unik
- `email_verified_at`
- `password`

### profil_nasabah
- `user_id`: foreign key ke tabel [users](#users)
- `alamat`
- `saldo`: default 0
- `metode_pembayaran_utama`

### posts
- `judul`
- `author_id`: foreign key ke tabel [users](#users)
- `slug`: unik, path identifier buat postingan
- `cover_url`
- `konten`

### post_images
- `post_id`: foreign key ke tabel posts
- `image_url`

### transaksi_penarikan
- `user_id`
- `metode_pembayaran`: default `metode_pembayaran_utama` user (logika di aplikasi)
- `no_telepon`: default `no_telepon` user (logika di aplikasi)
- `status`: enum -> `pending`, `completed`, `rejected`

### transaksi_penukaran
- `user_id`
- `total_berat`: otomatis keisi dari tabel `transaksi_penukaran_sampah` (logika di aplikasi)
- `total_harga`: otomatis keisi dari tabel `transaksi_penukaran_sampah` (logika di aplikasi)

### sampah
- `nama`
- `image_url`
- `harga_per_kg`

### transaksi_penukaran_sampah (tabel pivot/asosiatif)
- `transaksi_penukaran_id`: foreign key ke [transaksi_penukaran](#transaksi_penukaran)
- `sampah_id`: foreign key ke [sampah](#sampah)
- `berat`
- `harga_subtotal`: `harga_per_kg` * `berat`
