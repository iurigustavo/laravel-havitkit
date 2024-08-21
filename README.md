# Havit App

Havit App is a skeleton application for the Laravel framework, incorporating a variety of packages and tools to offer a comprehensive development experience.

## Description

- **Framework:** Laravel 11
- **UI:** Tailwind CSS, DaisyUI, Livewire
- **Keywords:** Laravel, Livewire, TALL stack, UI, PHP, etc.

## Requirements

- PHP 8.2 or higher
- Composer
- Laravel 11.9 or higher
- MariaDB
- Redis
- Node.js & npm (optional for frontend tooling)

## Installation

1. **Clone the repository:**
    ```bash
    git clone https://github.com/iurigustavo/laravel-havitkit
    ```

2. **Navigate into the project directory:**
    ```bash
    cd laravel-havitkit
    ```

3. **Install dependencies:**
    ```bash
    composer install
    ```

4. **Copy the example environment file and configure the environment:**
    ```bash
    cp .env.example .env
    ```

5. **Generate an application key:**
    ```bash
    php artisan key:generate
    ```

6. **Configure your database:**
   Update your `.env` file with your database connection details:
    ```env
    DB_CONNECTION=mariadb
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
    ```

7. **Run the database migrations:**
    ```bash
    php artisan migrate
    ```

8. **Start the local development server:**
    ```bash
    php artisan serve
    ```

## Configuration

### Queue Connection

The application uses Redis for job queues. Ensure that your Redis server is running and configured properly in your `.env` file:

```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### Mail Configuration

You can set up the Mail configuration in your `.env` file:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Main Packages Used

### Required Packages

- **blade-ui-kit/blade-heroicons**: ^2.3
- **lab404/laravel-impersonate**: ^1.7
- **laravel/framework**: ^11.9
- **laravel/tinker**: ^2.9
- **league/flysystem-aws-s3-v3**: ^3.28
- **livewire/livewire**: ^3.5
- **lorisleiva/laravel-actions**: ^2.8
- **openspout/openspout**: ^4.24
- **power-components/livewire-powergrid**: ^5.8
- **robsontenorio/mary**: ^1.35
- **spatie/laravel-activitylog**: ^4.8
- **spatie/laravel-backup**: ^9.0
- **spatie/laravel-medialibrary**: ^11.5
- **spatie/laravel-permission**: ^6.7

## Commands

- **Install Command with Mock:**
    ```shell
    php artisan app:install
    ```

- **Generate Models Permissions:**
    ```shell
    php artisan generate:permissions
    ```


## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## Contributing

Please read [CONTRIBUTING](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests.

## Acknowledgements

- [Laravel](https://laravel.com/)
- [maryUI](https://mary-ui.com/)
- [daisyUI](https://daisyui.com/)
- [Livewire](https://livewire.laravel.com/)
- [Alpine.js](https://alpinejs.dev/)
- [ServerSideUp/PHP](https://serversideup.net/open-source/docker-php/)
