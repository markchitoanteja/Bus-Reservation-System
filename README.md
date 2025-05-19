
# Bus Reservation System – Capstone Project

This is a **Bus Reservation System** built using the [CodeIgniter 4](https://codeigniter.com/) PHP framework. It is developed as a capstone project for **Eastern Samar State University - Can-Avid Campus** in collaboration with our client, **Eastern Goldtrans Tours**. The system is based on a ready-to-use CodeIgniter 4 template with essential pre-configured features like database setup, user authentication, and a clean project structure — ideal for rapid web development.

## Project Features

- Secure user authentication (with bcrypt hashing)
- Admin panel for managing trips, bookings, and users
- Route and schedule management
- Real-time seat reservation
- Trip history and reporting
- UUID-based primary keys for improved data handling
- Mobile-friendly UI with responsive components

## Requirements

- PHP >= 7.4
- Composer
- MySQL or MariaDB
- CodeIgniter 4.x

## Installation Instructions

Follow the steps below to set up and run the project locally:

### Step 1: Clone the Repository

```bash
git clone https://github.com/markchitoanteja/Bus-Reservation-System
cd Codeigniter-4-Template
```

> *(Optional: You may rename the folder to `bus-reservation-system`)*

### Step 2: Install Dependencies

```bash
composer install
```

### Step 3: Set Up the Database

1. Create a new database in MySQL/MariaDB (e.g., `bus_reservation`).
2. Open `app/Config/Database.php` and configure your connection:

```php
public $default = [
    'DSN'      => '',
    'hostname' => 'localhost',
    'username' => 'your-db-username',
    'password' => 'your-db-password',
    'database' => 'bus_reservation',
    'DBDriver' => 'MySQLi',
    ...
];
```

### Step 4: Set the Timezone (Optional)

Open `app/Config/App.php` and set your local timezone:

```php
public $appTimezone = 'Asia/Manila';
```

### Step 5: Run the Application

Start your local server (e.g., Apache/Nginx) and navigate to:

```
http://localhost/Codeigniter-4-Template
```

If the database is configured correctly, required tables will be created automatically, along with an initial admin account.

### Step 6: Default Admin Account

To access the admin panel, use the default credentials:

- **Username**: `admin`
- **Password**: `admin123`

> **Important**: Change the default password after first login for security.

---

## Project Structure Highlights

- `app/Models` – Database interaction logic
- `app/Controllers` – Application control flow
- `app/Views` – UI templates (using CodeIgniter 4’s View rendering)
- `app/Filters/Auth.php` – Route access control via middleware

---

## License

This project uses the **MIT License** – see the [LICENSE](LICENSE) file for more information.

## Contributions

This project welcomes contributions! Whether it's feature suggestions, bug reports, or pull requests, feel free to fork and collaborate.

## Acknowledgements

- **Eastern Samar State University – Can-Avid** for guiding this capstone project  
- **Eastern Goldtrans Tours** as our project client  
- [CodeIgniter 4](https://codeigniter.com/) for the development framework  
- [Ramsey UUID](https://ramsey.github.io/uuid/) for UUID-based IDs
