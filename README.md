****Healthcare appointment booking Web APP

1. About

2. Requirements

3. Installation

4. Environment Configuration

5. Running the Application

6. Testing

7. Route Structure

8. Authentication

9. Contributing

10. License

1. About

This is a Laravel application designed for managing appointments. It includes basic authentication using Sanctum, appointment scheduling, and healthcare professional management.

2. Requirements

PHP: >= 8.4.0

Composer

Laravel: >= 12.x

MySQL (or supported database)


3. Installation

Follow these steps to get the application up and running:

3.1. Clone the Repository
git clone https://github.com/mayurimeghani/healthcare_appoint
cd your-project-directory (e.g., D:\wamp64\www)

3.2. Install Dependencies

Run the following commands to install PHP and JavaScript dependencies.

Install PHP dependencies via Composer
composer install

4. Environment Configuration

Duplicate the .env.example file to .env:

cp .env.example .env


Set up your environment variables for the database and other configurations in the .env file. The following settings should be configured:

APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:YourAppKeyHere
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Sanctum settings for API token authentication
Note blow variable default included localhost, only define if you need ot add more domains.
SANCTUM_STATEFUL_DOMAINS=127.0.0.1,localhost,


* Generate the Application Key

Run the following command to generate the application key:

php artisan key:generate

5. Running the Application

To serve the application locally, run the following command:

php artisan serve


This will start the application at http://127.0.0.1:8000.6. 

6. Testing

To run the tests for the application, use the following command:

php artisan test


This will run all the unit and feature tests defined in the tests directory.

7. Route Structure

Here is a brief overview of the routes defined in routes/api.php for API calls:

Register a User: POST /api/register

Login a User: POST /api/login

Get Appointments: GET /api/appointments

Get Appointment: GET /api/appointments/{id}

Create an Appointment: POST /api/appointments

Cancel an Appointment: POST /api/appointments/{id}/cancel

Get Healthcare Professionals: GET /api/professionals

Note: Make sure to pass the Authorization header with a Bearer token for routes requiring authentication (for all routes except login and register).

# For more API information, check the collection file available in the documents branch. Import it in Postman.

8. Authentication

The application uses Sanctum for authentication.

Login: Send a POST request to /api/login with email and password.

Register: Send a POST request to /api/register with name, email, password, and password_confirmation.

Accessing Protected Routes: After login, you’ll receive a token. You can pass the token in the Authorization header:

Authorization: Bearer YOUR_TOKEN_HERE


Use this token to authenticate protected routes like getting appointments, creating appointments, etc.

9. Contributing

Contributions are welcome! If you'd like to improve the project, please fork the repository, make changes, and submit a pull request.

Before contributing, make sure to:

Fork the repository.

Clone your fork locally.

Create a feature branch.

Write tests (if applicable).

Submit a pull request.
