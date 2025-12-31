# Foundify - Backend API

Backend REST API dan GraphQL untuk aplikasi Lost and Found dengan sistem Reward Points.

## Deskripsi Proyek

Foundify adalah platform terpusat untuk pelaporan barang hilang dan ditemukan. Sistem ini memberikan insentif berupa poin kepada penemu barang yang dapat ditukarkan dengan hadiah di reward store. Backend menyediakan dua jalur komunikasi: REST API untuk operasi CRUD standar dan GraphQL untuk pengambilan data relasional yang lebih efisien.

### Fitur Utama
- Autentikasi User dan Admin dengan JWT Token
- Pelaporan barang hilang dan barang ditemukan
- Sistem klaim kepemilikan barang dengan verifikasi admin
- Pengelolaan poin dan riwayat transaksi
- Katalog reward dan penukaran poin
- GraphQL untuk query data relasional

## Teknologi yang Digunakan

| Kategori | Teknologi | Versi | Deskripsi |
|----------|-----------|-------|-----------|
| Backend Framework | Laravel | 10.x | Framework PHP untuk REST API dan GraphQL |
| Database | MySQL | 8.x | Sistem manajemen database relasional |
| Authentication | JWT (tymon/jwt-auth) | 2.x | Library JWT untuk autentikasi stateless |
| GraphQL Server | Lighthouse PHP | 6.x | Library GraphQL untuk Laravel |
| PHP | PHP | 8.1+ | Bahasa pemrograman backend |
| Local Development | Laragon / XAMPP | 6.x / 8.x | Environment development untuk Windows |
| REST API Testing | Postman | - | Tools untuk menguji endpoint REST API |
| GraphQL Testing | Altair GraphQL Client | - | Tools untuk menguji endpoint GraphQL |

## Persyaratan Sistem

- PHP >= 8.1
- Composer >= 2.0
- MySQL >= 8.0
- Node.js >= 16.x

## Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/AdityaWahyuH/Foundify-Backend.git
cd Foundify-Backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
```

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=foundify_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 6. Jalankan Migration dan Seeder

```bash
php artisan migrate
php artisan db:seed
```

### 7. Buat Storage Link

```bash
php artisan storage:link
```

### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi berjalan di `http://localhost:8000`

---

## Struktur Database

Database terdiri dari 9 tabel yang saling berelasi:

| Tabel | Primary Key | Foreign Key |
|-------|-------------|-------------|
| user | user_id | - |
| admin | admin_id | - |
| barang_hilang | barang_hilang_id | user_id |
| barang_ditemukan | barang_ditemukan_id | user_id |
| klaim | klaim_id | user_id, barang_ditemukan_id |
| poin | poin_id | user_id |
| riwayat_poin | riwayat_id | poin_id |
| katalog_reward | katalog_id | - |
| tukar_poin | tukar_id | user_id, katalog_id |

### Relasi Database
- Satu user dapat memiliki banyak barang_hilang, barang_ditemukan, klaim, dan tukar_poin (one-to-many)
- Satu poin berelasi dengan banyak riwayat_poin untuk mencatat histori aktivitas
- Satu barang_ditemukan dapat memiliki banyak klaim dari user berbeda
- Satu katalog_reward dapat memiliki banyak tukar_poin

---

## API Endpoints

### Base URL

```
http://localhost:8000/api
```

### Authentication

Semua endpoint yang membutuhkan autentikasi harus menyertakan JWT token di header:

```
Authorization: Bearer {token}
```

---

### Auth Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/api/auth/register` | Register user baru |
| POST | `/api/auth/login` | Login user |
| POST | `/api/auth/admin/login` | Login admin |
| GET | `/api/auth/me` | Get current user |
| POST | `/api/auth/refresh` | Refresh token |
| POST | `/api/auth/logout` | Logout |

### Barang Hilang Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/barang-hilang` | Get semua barang hilang |
| GET | `/api/barang-hilang/{id}` | Get barang hilang by ID |
| POST | `/api/barang-hilang` | Create barang hilang |
| PUT | `/api/barang-hilang/{id}` | Update barang hilang |
| DELETE | `/api/barang-hilang/{id}` | Delete barang hilang |
| GET | `/api/my-barang-hilang` | Get barang hilang milik user |

### Barang Ditemukan Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/barang-ditemukan` | Get semua barang ditemukan |
| GET | `/api/barang-ditemukan/{id}` | Get barang ditemukan by ID |
| POST | `/api/barang-ditemukan` | Create barang ditemukan |
| PUT | `/api/barang-ditemukan/{id}` | Update barang ditemukan |
| DELETE | `/api/barang-ditemukan/{id}` | Delete barang ditemukan |

### Klaim Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/klaim` | Get semua klaim |
| GET | `/api/klaim/{id}` | Get klaim by ID |
| POST | `/api/klaim` | Create klaim |
| PUT | `/api/klaim/{id}/verify` | Verify klaim (Admin) |
| GET | `/api/my-klaim` | Get klaim milik user |

### Poin Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/poin` | Get total poin user |
| GET | `/api/poin/riwayat` | Get riwayat poin |

### Katalog Reward Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| GET | `/api/katalog-reward` | Get semua katalog |
| GET | `/api/katalog-reward/{id}` | Get katalog by ID |
| POST | `/api/katalog-reward` | Create katalog (Admin) |
| PUT | `/api/katalog-reward/{id}` | Update katalog (Admin) |
| DELETE | `/api/katalog-reward/{id}` | Delete katalog (Admin) |

### Tukar Poin Endpoints

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/api/tukar-poin` | Tukar poin dengan reward |
| GET | `/api/tukar-poin/riwayat` | Get riwayat tukar poin |
| PUT | `/api/tukar-poin/{id}/verify` | Verify tukar poin (Admin) |

---

## GraphQL

| Item | URL |
|------|-----|
| Endpoint | POST `/graphql` |
| Playground | GET `/graphiql` |

---

## Testing

Testing dilakukan menggunakan Postman untuk REST API dan Altair GraphQL Client untuk GraphQL. Import collection dari dokumentasi untuk melakukan testing.

## Tim Pengembang

- Aditya Wahyu Hidayatullah
- Mohamad Fikri Isfahani
- Joe Petra
- Abel Chrisnaldi

## API Documentation

| Tipe | Link |
|------|------|
| REST API (Postman) | https://documenter.getpostman.com/view/48988195/2sBXVbFsXK |
| GraphQL Playground | http://localhost:8000/graphiql |
| GraphQL Collection | `/docs/foundify_graphql.agc` |
