# Installation & Deployment Guide - KongStore

KongStore is a full-stack Play Store-like website built using clean PHP 8+ MVC architecture, Bootstrap 5, and MySQL.

---

## Environment Prerequisites
- **Web Server**: Apache (with `mod_rewrite` enabled)
- **PHP**: Version 8.0 or higher (with `PDO`, `pdo_mysql`, and `finfo` extensions enabled)
- **Database**: MySQL 5.7+ or MariaDB 10.3+
- **Local Dev Stack**: Recommend using **XAMPP**, **WampServer**, or **Laragon** on Windows.

---

## Step 1: Clone or Extract Code
Place the project directory (`pkongstore1`) directly inside your local server webroot:
- For XAMPP: `C:\xampp\htdocs\pkongstore1\`
- For Laragon: `C:\laragon\www\pkongstore1\`

---

## Step 2: Database Initialization

1. Start Apache and MySQL services in your control panel.
2. Open your browser and navigate to **phpMyAdmin** (`http://localhost/phpmyadmin/`).
3. Create a new database named `pkongstore` with collation `utf8mb4_unicode_ci`.
4. Open the SQL tab and import the following files in order:
   - First: [database/schema.sql](file:///c:/xampp/htdocs/pkongstore1/database/schema.sql) (Creates all 18 tables)
   - Second: [database/seed.sql](file:///c:/xampp/htdocs/pkongstore1/database/seed.sql) (Seeds default categories, settings, banners, users, and apps)

Alternatively, import via Command Line:
```bash
mysql -u root -p -e "CREATE DATABASE pkongstore CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p pkongstore < c:\xampp\htdocs\pkongstore1\database\schema.sql
mysql -u root -p pkongstore < c:\xampp\htdocs\pkongstore1\database\seed.sql
```

---

## Step 3: Configure Settings
Open [app/config/config.php](file:///c:/xampp/htdocs/pkongstore1/app/config/config.php) in your editor and verify database connection details:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Set your local MySQL password
define('DB_NAME', 'pkongstore');
```

Base URL detection runs automatically. If your folder structure matches, the Base URL will resolve to `http://localhost/pkongstore1`.

---

## Step 4: Verify Folder Permissions
Ensure the following directories inside `public/uploads/` are writable by the server process (e.g. `chmod -R 775` on production, writable by default on Windows):
- `public/uploads/icons/`
- `public/uploads/screenshots/`
- `public/uploads/apks/`
- `public/uploads/banners/`

---

## Access Credentials
The database seeds include these pre-configured user credentials for immediate evaluation. **Password for all accounts is:** `password`

1. **Super Administrator Panel**:
   - URL: `http://localhost/pkongstore1/admin`
   - Email: `admin@pkongstore.com`
   - Role: Super Admin (manages apps vetting, user status toggles, categories CRUD, ads setups)
   
2. **Approved Developer Profile**:
   - URL: `http://localhost/pkongstore1/developer`
   - Email: `dev@pkongstore.com`
   - Role: Developer (manages console app uploads, version updates)
   
3. **Standard Customer Account**:
   - URL: `http://localhost/pkongstore1/dashboard`
   - Email: `jane@pkongstore.com`
   - Role: Standard User (submits reviews, likes, bookmarks wishlist)

---

## Testing Key Features Locally

### Email and OTP Simulation
Since local dev environments lack an SMTP relay server, KongStore simulates email and OTP delivery:
- When a user registers or requests a password reset, a simulated email delivery log is appended to: `logs/email_simulation.log`
- Open this log file to find your **OTP Verification Code** or **Password Reset link** to test end-to-end authentication flows.

### APK Download Stream
- When clicking the download button on app detail pages, the system attempts to serve the binary from `public/uploads/apks/`.
- If the binary file does not exist on disk, the system automatically falls back to streaming a **simulated demonstrator APK file** so downloads never break in testing.
