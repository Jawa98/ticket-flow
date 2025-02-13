# Ticket Flow System

## Project Description
The Ticket Flow System is a Laravel-based application designed to manage events and handle ticket purchases efficiently. It provides a basic CRUD API for managing events along with a ticket purchase function that enforces constraints such as purchase limits and available ticket counts. This project emphasizes clean code, scalability, and robust error handling.

## Running the Project

### 1. Clone the Repository
- Clone the repository to your local machine:
    ```bash
    git clone https://github.com/Jawa98/ticket-flow.git
### 2. Environment Setup

- Make sure you have [PHP](https://www.php.net/), [Composer](https://getcomposer.org/), and [Laravel](https://laravel.com/docs/8.x) installed on your machine.
- Create a database in MySQL or any supported database by Laravel.
- In the project directory, install dependencies with:
  ```bash
  composer install
- Copy the .env.example file to .env:
  ```bash
  cp .env.example .env
- Configure the database settings in .env:
    ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_database
    DB_USERNAME=your_username
    DB_PASSWORD=your_password
- Generate the application key:
  ```bash
  php artisan key:generate

### 3. Run Migrations and Start the Server
- Run migrations to create the necessary tables:
  ```bash
  php artisan migrate
- Start the local server:
  ```bash
  php artisan serve
- Open your browser at http://localhost:8000.

### Task Details
#### 1. Code Structure (40%)

- Implement a basic CRUD API for managing "Events" and the ticket purchase logic in a single system.
- Create a migration for the `events` table with the following columns:
  - `id` (integer, primary key)
  - `name` (string)
  - `description` (text)
  - `start_date` (datetime)
  - `end_date` (datetime)
  - `ticket_count` (integer)
- Create an Eloquent model for the `Event` entity.
- Create a controller with these endpoints:
  - `GET /events` – List all events.
  - `GET /events/{id}` – Retrieve a single event by its ID.
  - `POST /events` – Create a new event.
  - `PUT /events/{id}` – Update an existing event.
  - `DELETE /events/{id}` – Delete an event.
- Write unit tests using Laravel's testing suite to ensure all CRUD operations work correctly.
- Validate input data to ensure correct date formats and that the ticket count is a positive number.

#### 2. Logical Problem Solving & Algorithm (40%)
- Develop a function to handle ticket purchases.
- Implement the following constraints:
  - A user can purchase a maximum of 5 tickets per transaction.
  - Each event has a total of 100 tickets available.
  - Each successful purchase should decrease the available ticket count accordingly.
- Validate input to ensure that the requested number of tickets does not exceed the allowed limit or the available tickets.
- Provide error handling with clear messages for scenarios like insufficient tickets.
- *Extra Challenge:* Ensure the system handles concurrent purchase requests without overselling tickets.

#### 3. Code Health & Best Practices (20%)
- Refactor the following code snippet to improve readability, scalability, and performance, focusing on code readability, error handling, and efficiency.

**Original Code:**
```php
public function calculateDiscount($cart) {
    $total = 0;
    $discount = 0;
    foreach($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    if ($total > 100) {
        $discount = $total * 0.1;
    } else {
        $discount = $total * 0.05;
    }
    return $total - $discount;
}
