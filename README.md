# 📘 Manual Book Sambungin

Project ini adalah website manual book yang menampilkan langkah-langkah fitur berdasarkan data dari database.

---

## ⚙️ Setup Database

### 3. Buat Database

Jalankan di MySQL / phpMyAdmin:

```sql
CREATE DATABASE manual_book;
```

---

### 4. Import Database

Menggunakan terminal:

```bash
mysql -u root -p manual_book < database/manual_book_sambungin.sql
```

Atau via phpMyAdmin:
- pilih database `manual_book`
- klik **Import**
- upload file `database/manual_book_sambungin.sql`

---

### 5. Konfigurasi Database

Edit file:

```
website/config.php
```

Sesuaikan:

```php
DB_HOST = "localhost";
DB_NAME = "manual_book";
DB_USER = "root";
DB_PASS = "";
```