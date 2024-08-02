# community

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

# requirment
php >= 8.2.0.
laravel 11+

Clone the Repository

#  setup

Run following command.

composer install.
php artisan migrate.
npm install.
npm run dev.

Copy the .env.example file to .env and configure your environment variables.

# env file

Add this 2 constant to env file

EXCHANGE_API_KEY=your_access_key.
EXCHANGE_API_URL=https://api.exchangeratesapi.io/v1/

# Run laravel app 

php artisan serve

# Also run queue

php artisan queue:listen


# Features
User Authentication:
    Explain the login and registration process, including two-factor authentication.
Admin Dashboard:
    Provide details about the admin functionalities, such as managing users, accounts, and transactions.
Account Management:
    Detail how users can manage their accounts, view balance,fund transfer and transaction history.
Currency Exchange:
    Explain the currency conversion feature, including how to set exchange rates and perform currency transfers.