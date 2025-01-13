## Getting Started

Follow these instructions to set up the project.

### Installation

1. **Clone the repository:**

    ```shell
    git clone "git@github.com:Fabdoc27/Barta.git"
    ```

2. **Navigate to the project directory:**

    ```shell
    cd "Barta"
    ```

3. **Install PHP dependencies:**

    ```shell
    composer install
    ```

4. **Install Node.js dependencies:**

    ```shell
    npm install
    ```

5. **Create the environment file:**

    ```shell
    cp .env.example .env
    ```

6. **Generate the application key:**

    ```shell
    php artisan key:generate
    ```

7. **Run database migrations:**

    ```shell
    php artisan migrate
    ```

8. **Start the local development server:**

    ```shell
    php artisan serve
    ```

9. **Compile front-end assets:**

    ```shell
    npm run dev
    ```

## Testing

Follow these steps to set up and run the tests.

### Setting Up the Testing Environment

1.  **Create a `.env.testing` file:**

    ```bash
    cp .env.example .env.testing
    ```

2.  **Generate the application key for the testing environment:**

    ```bash
    php artisan key:generate --env=testing
    ```

3.  **Create the `test.sqlite` file:**

    ```bash
    touch database/test.sqlite
    ```

4.  **Run database migrations with seeding for the testing environment:**

    ```bash
    php artisan migrate --seed --env=testing
    ```

5.  **Configure the `phpunit.xml` file to use SQLite for testing:**

    Add the following lines in the `<php>` section of the `phpunit.xml` file:

    ```xml
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value="database/test.sqlite"/>
    ```

6.  **Ensure the testing database configuration is set in `config/database.php`:**

    This is already pre-configured:

    ```php
    'testing' => [
        'driver' => 'sqlite',
        'url' => env('DB_URL'),
        'database' => env('DB_DATABASE', database_path('test.sqlite')),
        'prefix' => '',
        'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        'busy_timeout' => null,
        'journal_mode' => null,
        'synchronous' => null,
    ],
    ```

7.  **Update the `.env.testing` file with the following variables:**

    ```env
    DB_CONNECTION=testing
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```

8.  **Run the tests:**

    ```bash
    php artisan test
    ```
