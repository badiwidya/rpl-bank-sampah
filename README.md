# Proyek RPL - Bank Sampah

Aplikasi web Bank Sampah adalah sistem manajemen pengelolaan sampah berbasis Laravel yang memungkinkan nasabah untuk menukar sampah dengan saldo digital. Platform ini menyediakan fitur lengkap mulai dari registrasi nasabah, pencatatan transaksi setoran sampah, penarikan saldo, hingga pengelolaan konten edukasi tentang lingkungan. Sistem ini dirancang untuk mendukung program keberlanjutan lingkungan dengan memberikan insentif ekonomi kepada masyarakat yang aktif dalam pengelolaan sampah.

## 📋 Daftar Isi

- [🤓 Anggota Kelompok](#-anggota-kelompok)
- [🚀 Instalasi](#-instalasi)
    - [Prasyarat](#prasyarat)
    - [Setup Proyek](#setup-proyek)
- [🗃 Skema Database](#-skema-database)
    - [Tabel Utama](#tabel-utama)
    - [Relasi](#relasi)
- [🚘 Routes](#-routes)
    - [Authentication Routes](#authentication-routes)
    - [Public Routes](#public-routes)
    - [Nasabah Routes](#nasabah-routes)
    - [Admin Routes](#admin-routes)

## 🤓 Anggota Kelompok:
- Najma Hamidha (G6401231004)
- Nisa Amelia (G6401231022)
- Berton Adiwidya Wibowo (G6401231043)
- Ibnu Burhanudin Habibi (G6401231100)
- Muhammad Fauzan Zubaedi (G6401231129)

## 🚀 Instalasi

### Prasyarat
* PHP versi 8 atau lebih tinggi
* Nodejs & NPM
* Composer
* MySQL
* Git

### Setup Proyek

1. Clone Repository
    ```bash
    git clone https://github.com/badiwidya/rpl-bank-sampah.git
    cd rpl-bank-sampah
    ```

2. Instal Dependensi PHP
    ```bash
    composer install
    ```

3. Instal Dependensi Node
    ```bash
    npm install
    ```

4. Konfigurasi Environment
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5. Konfigurasi Database
    Edit file `.env` dengan kredensial database
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=bank_sampah
    DB_USERNAME=db_username
    DB_PASSWORD=db_password
    ```

6. Migrasi Database
    ```bash
    php artisan migrate
    ```

7. Link Direktori Storage
    ```bash
    php artisan storage:link
    ```

8. Jalankan Proyek
    ```bash
    composer run dev

    # atau
    npm run dev
    php artisan serve
    php artisan queue:work
    ```

Aplikasi akan berjalan di `http://localhost:8000`

## 🗃 Skema Database

### Tabel Utama

#### Users
```sql
- id (primary key)
- nama_depan (string)
- nama_belakang (string)
- email (string, unique)
- no_telepon (string, unique)
- email_verified_at (timestamp)
- password (string)
- avatar_url (string)
- role (enum: 'nasabah', 'admin')
- created_at, updated_at (timestamp)
```

#### Profil Nasabah
```sql
- id (primary key)
- user_id (foreign key to users)
- nama_belakang (string)
- alamat (string)
- saldo (decimal)
- metode_pembayaran_utama (string)
- created_at, updated_at (timestamp)
```

#### Posts
```sql
- id (primary key)
- author_id (foreign key to users)
- judul (string)
- category_id (foreign key to categories)
- slug (string)
- konten (text)
- created_at, updated_at (timestamp)
```

#### Post Images
```sql
- id (primary key)
- post_id (foreign key to posts)
- image_url (string)
- created_at, updated_atu (timestamp)
```

#### Categories
```sql
- id (primary key)
- nama (string)
- slug (string)
- created_at, updated_atu (timestamp)
```

#### Transaksi Penarikan
```sql
- id (primary key)
- user_id (foreign key to users)
- jumlah (decimal)
- metode_pembayaran (string)
- no_telepon (string)
- status (enum: 'pending', 'accepted', 'rejected')
- created_at, updated_atu (timestamp)
```

#### Transaksi Penukaran
```sql
- id (primary key)
- user_id (foreign key to users)
- total_berat (decimal)
- total_harga (decimal)
- created_at, updated_atu (timestamp)
```

#### Sampah
```sql
- id (primary key)
- nama (string)
- image_url (string)
- harga_per_kg (decimal)
- created_at, updated_atu (timestamp)
```

#### Transaksi Penukaran Sampah
```sql
- id (primary key)
- transaksi_penukaran_id (foreign key to transaksi_penukaran)
- sampah_id (foreign key to sampah)
- berat (decimal)
- harga_subtotal (decimal)
- created_at, updated_atu (timestamp)
```

#### Log Harga Sampah
```sql
- id (primary key)
- sampah_id (foreign key to sampah)
- harga_lama (decimal)
- harga_baru (decimal)
- user_id (foreign key to users)
- created_at, updated_atu (timestamp)
```

### Relasi
- `User` hasOne `Profile`
- `User` hasMany `Posts`
- `Posts` hasMany `PostImages`
- `User` hasMany `TransaksiPenarikan`
- `User` hasMany `TransaksiPenukaran`
- `User` hasMany `LogHargaSampah`
- `Categories` hasMany `Posts`
- `TransaksiPenukaran` manyToMany `Sampah`

## 🚘 Routes

### Authentication Routes
```php
GET|HEAD   register
POST       register
GET|HEAD   login
GET|HEAD   admin/login
POST       admin/login
GET|HEAD   nasabah/login
POST       nasabah/login
POST       logout
GET|HEAD   email/verify
POST       email/verify
GET|HEAD   email/verify/{value}/{id}
GET|HEAD   forgot-password
POST       forgot-password
POST       reset-password
GET|HEAD   reset-password/{token}
```

### Public Routes
```php
GET|HEAD   /
GET|HEAD   posts
GET|HEAD   posts/{post}
```

### Nasabah Routes
```php
GET|HEAD   dashboard
GET|HEAD   dashboard/penarikan
GET|HEAD   dashboard/profile
GET|HEAD   dashboard/profile/change-password
GET|HEAD   dashboard/sampah
GET|HEAD   dashboard/setoran
```

### Admin Routes
```php
GET|HEAD   admin/dashboard
GET|HEAD   admin/dashboard/penarikan
GET|HEAD   admin/dashboard/posts
GET|HEAD   admin/dashboard/posts/create
GET|HEAD   admin/dashboard/posts/{post}/edit
GET|HEAD   admin/dashboard/profile
GET|HEAD   admin/dashboard/profile/change-password
GET|HEAD   admin/dashboard/sampah
GET|HEAD   admin/dashboard/sampah/log
GET|HEAD   admin/dashboard/setoran
GET|HEAD   admin/dashboard/setoran/create
```