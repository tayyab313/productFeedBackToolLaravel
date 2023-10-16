First, ensure that you have created a database in your XAMPP's phpMyAdmin with the name: product_feedback_tool_db.

After cloning the project from the GitHub repository, perform the basic steps necessary for a Laravel project on your local machine:

2.1. Run either composer install or composer update.
2.2. Update the .env file as needed.
2.3. Run the following commands to migrate tables in the database and seed the data:
- `php artisan migrate`
- `php artisan db:seed`
Make sure to run these commands in the given sequence. After running both commands, verify that the data and tables have been successfully imported into your XAMPP phpMyAdmin.

3 - To run the project, execute the command: php artisan serve.

4 - You will also need to install npm.

5 - Run the following command locally: npm run dev.

Please note the following requirements:

Ensure your PHP version is greater than 8.0.
Make sure you have an updated version of Composer, preferably greater than 2.
Admin Login Credentials:

Email: admin@gmail.com
Password: 11223344
I hope this helps you get the project up and running on your local machine.
