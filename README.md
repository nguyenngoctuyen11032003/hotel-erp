# Hotel ERP

A PHP and MySQL web application for running a small hotel: a public booking site, plus back-office panels for administrators and staff.

## Overview

The project has three parts:

- **Public website** (`index.php`, `rooms.php`, `about.php`). Guests can browse rooms and submit a reservation. The home and about pages show content taken from the `system_settings` table.
- **Admin panel** (`admin/`). Full management of rooms, reservations, payments, staff, payroll, attendance, assets, restaurant sales, reports and site settings.
- **Staff panel** (`staff/`). A smaller version of the admin panel for day-to-day work.

The user interface text is in Vietnamese.

## Key features

### Guest (public site)
- Room listing with a reservation form: check-in/check-out dates and customer name, ID, phone, email and address.
- Submitting a reservation creates a record in `reservations` and changes the room's status.
- Home and about page content (name, tagline, welcome text, contacts, social links) comes from the database.

### Admin
- Login, logout, profile update, password change, and password reset by email lookup (a new password is set and then confirmed on a follow-up page).
- Dashboard with Chart.js charts (rooms per type, revenue per room type, reservations per room type) and lists of the latest reservations and payments.
- **Rooms**: create, update and delete rooms (number, type, price, status, details). Rooms can also be bulk-imported from an `.xlsx` file using PhpSpreadsheet. A template is in `public/templates/Rooms.xlsx`.
- **Reservations**: create, update and delete reservations, and check a guest out (vacate the room).
- **Customers**: list customers and delete them.
- **Reservation payments**: record a payment against a reservation (amount, payment method), list payments and delete them.
- **Room service**: assign staff members to rooms.
- **Restaurant sales**: add, update and delete sales records.
- **Staff**: create, update and delete staff accounts. Staff can also be bulk-imported from `.xlsx` (template: `public/templates/Staff.xlsx`).
- **Payroll**: add, update and delete monthly payroll entries per staff member.
- **Attendance**: add, update and delete attendance records.
- **Inventory / assets**: add, update and delete hotel assets.
- **Reports**: rooms, reservations, revenues, payrolls and staff, shown as DataTables with the export/print buttons from the DataTables Buttons extension.
- **Settings**: edit the system name and tagline, home page welcome content, about text, contact details and social links.

### Staff
- Login, logout, profile and password management, password reset.
- Dashboard.
- Rooms: add and update, including `.xlsx` import.
- Reservations: add, update and check out (no delete).
- Reservation payments, room service, restaurant sales and inventory: add and update (no delete).
- Attendance: own check-in and check-out.
- Read-only views of customers, payroll, and reports on rooms, reservations and revenues.

## Tech stack

- PHP. The SQL dump was exported from PHP 8.3; `DataSource.php` requires PHP 7.1 or later.
- MySQL / MariaDB, accessed through `mysqli`. PDO is used only in `partials/ajax.php`.
- Composer packages:
  - `phpoffice/phpspreadsheet` ^1.15 (Excel import)
  - `coderatio/simple-backup` ^1.0 (declared, but no application code currently calls it)
- Front end: AdminLTE-style back office (Bootstrap 4, jQuery, DataTables, Chart.js, Select2, SweetAlert2, Toastr and others under `public/plugins`). The public site uses Bootstrap 4, Owl Carousel, GSAP and ScrollMagic.

## Project structure

```
ERP_HOTEL_NNT/
├── index.php, rooms.php, about.php   Public website (home, rooms/booking, about)
├── admin/                            Admin panel pages
├── staff/                            Staff panel pages
├── config/                           DB connections, login check, code generators
├── database/                         SQL dump (khachsan_erp.sql)
├── partials/                         Shared headers, footers, sidebars, charts, AJAX endpoint
├── public/                           CSS/JS/plugins, Excel templates, uploads
├── composer.json / composer.lock     PHP dependencies
└── vendor/                           Composer packages (not committed; created by composer install)
```

## Setup

### Requirements
- PHP with the `mysqli`, `pdo_mysql`, `zip`, `xml`, `gd` and `mbstring` extensions. PhpSpreadsheet needs the last four.
- MySQL or MariaDB.
- Composer.

### Steps

1. Clone the repository:
   ```bash
   git clone https://github.com/nguyenngoctuyen11032003/hotel-erp.git
   cd hotel-erp
   ```
2. Install dependencies. `vendor/` is not in the repository, so you must run this step. Room and staff Excel import will not work without it.
   ```bash
   composer install
   ```
3. Create a database named `khachsan_erp` and import `database/khachsan_erp.sql`. The dump does not create the database itself. You can use phpMyAdmin, or run:
   ```bash
   mysql -u root -e "CREATE DATABASE khachsan_erp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
   mysql -u root khachsan_erp < database/khachsan_erp.sql
   ```
4. Check the database settings. `config/config.php` (most pages), `config/DataSource.php` (Excel import) and `config/pdoconfig.php` (`partials/ajax.php`) all read them from `config/env.php`. It uses these environment variables, and falls back to the defaults when a variable is not set:

   | Variable | Railway alternative | Default |
   |----------|---------------------|---------|
   | `DB_HOST` | `MYSQLHOST` | `localhost` |
   | `DB_PORT` | `MYSQLPORT` | `3306` |
   | `DB_USER` | `MYSQLUSER` | `root` |
   | `DB_PASSWORD` | `MYSQLPASSWORD` | *(empty)* |
   | `DB_NAME` | `MYSQLDATABASE` | `khachsan_erp` |

   With XAMPP's defaults you don't need to set anything.

5. The SQL dump includes a default admin account. Change its credentials after import.

## Run

**XAMPP / WAMP / Laragon:** put the project in the web root (for example `htdocs/hotel-erp`), start Apache and MySQL, and open:

- Public site: `http://localhost/hotel-erp/`
- Admin panel: `http://localhost/hotel-erp/admin/`
- Staff panel: `http://localhost/hotel-erp/staff/`

**PHP built-in server:**
```bash
php -S localhost:8000
```
Then open `http://localhost:8000/`, `/admin/` or `/staff/`.

## Deploy (Railway)

Vercel cannot host this project. It has no PHP runtime and no MySQL, and its filesystem does not keep uploaded files. Use a host that runs Docker, such as Railway. The `Dockerfile` in the repository also works on Render, Fly.io or a VPS.

1. In Railway, create a project from this GitHub repository. Railway finds the `Dockerfile` and builds it.
2. Add a **MySQL** database to the same project.
3. In the web service's **Variables**, add references to the database: `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD` and `MYSQLDATABASE` (use `${{MySQL.MYSQLHOST}}` and so on).
4. Add a **Volume** to the web service, mounted at `/var/www/html/public/uploads`. Without it, uploaded room images and logos disappear on every redeploy.
5. Under **Settings → Networking**, choose **Generate Domain**.

On first start the container imports `database/khachsan_erp.sql`, but only if the database has no tables yet (`docker/init-db.php`). It also copies the bundled images into the empty uploads volume. Later restarts leave the data alone.

To try the image locally:
```bash
docker build -t hotel-erp .
docker run -p 8080:8080 -e PORT=8080 -e DB_HOST=<mysql host> -e DB_USER=root -e DB_PASSWORD=<password> -e DB_NAME=khachsan_erp hotel-erp
```

## Notes and limitations

- Passwords are hashed with `sha1(md5(...))`, which is not secure. Switch to `password_hash()` before any real deployment.
- Some queries build SQL from request input by string concatenation (for example the email check in password reset). Prepared statements are used in other places, but not everywhere.
- Password reset does not send any email. It sets a random password and sends the user straight to a confirmation page.
- Database settings come from environment variables only. A `.env` file is not read.
- Room types and reservation statuses are Vietnamese strings stored in the database (for example `Phòng đơn`, `Đã thanh toán`), and the dashboard analytics depend on those exact values.
- `coderatio/simple-backup` is installed, but no backup feature is built into the application.
- There are no automated tests.

## Author

Nguyễn Ngọc Tuyền. GitHub: [nguyenngoctuyen11032003](https://github.com/nguyenngoctuyen11032003)
