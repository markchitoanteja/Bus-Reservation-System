# CodeIgniter 4 Template

A simple, ready-to-use template to get started with CodeIgniter 4 for rapid web development. This template comes with pre-configured essential features such as database setup, user authentication, and basic file structure.

## Requirements

- PHP >= 7.4
- Composer
- MySQL or MariaDB
- CodeIgniter 4.x

## Installation Instructions

Follow these steps to get the template running on your local machine:

### Step 1: Clone the Repository

Clone the repository to your local machine using Git:

```bash
git clone https://github.com/markchitoanteja/Codeigniter-4-Template.git
```

### Step 2: Set Up the Project

Navigate to the project directory and install the dependencies using Composer:

```bash
cd Codeigniter-4-Template
composer install
```

### Step 3: Set Up the Database

1. Create a new database in MySQL or MariaDB. You can name the database whatever you prefer.

2. Configure the database connection by editing the `app/Config/Database.php` file. Update the following settings:

```php
public $default = [
    'DSN'      => '',
    'hostname' => 'localhost',   // Database hostname
    'username' => 'your-db-username', // Database username
    'password' => 'your-db-password', // Database password
    'database' => 'your-db-name', // Database name
    'DBDriver' => 'MySQLi', // Database driver
    ...
];
```

### Step 4: Set Timezone (Optional)

You can set the timezone for your application by editing the `app/Config/App.php` file. Update the `$appTimezone` property:

```php
public $appTimezone = 'Asia/Manila'; // Set to your desired timezone
```

### Step 5: Run the Application

Make sure your server (e.g., Apache or Nginx) is running, and visit the following URL in your browser:

```
http://localhost/Codeigniter-4-Template
```

The application should load, and if you've configured the database correctly, it will automatically create the required tables (if they do not already exist) and insert initial data.

### Step 6: Initial Data

If the `users` table is empty, the application will automatically add a default "Administrator" user with the following credentials:

- **Username**: `admin`
- **Password**: `admin123` (bcrypt encrypted)

This user can be used for logging into the system.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

Feel free to fork this repository, create an issue, or submit a pull request. Any contributions are welcome!

## Acknowledgements

- [CodeIgniter 4](https://codeigniter.com/) for the powerful PHP framework
- [Ramsey UUID](https://ramsey.github.io/uuid/) for UUID generation
