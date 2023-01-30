Ecommerce Laravel Backend
This is the backend for an ecommerce android app built with the Laravel PHP framework. The backend handles all of the server-side logic and database operations for the app.

Features
 .User authentication and authorization: Users can register, log in, and access protected routes and data.
 .CRUD (Create, Read, Update, Delete) operations for products: Administrators can create, view, update, and delete products.
 .Order management: Users can view their order history and administrators can view and manage all orders.
 .Mpesa integration for payment processing.
 .API endpoints: The backend exposes a set of API endpoints that the android app can interact with to retrieve and update data.

Requirements
 .PHP 7.4+
.MySQL 5.7+
.Composer
.Daraja account for payment processing.

Installation
Clone the repository on your local machine
.git clone https://github.com/yourusername/ecommerce-laravel-backend.git

Navigate to the project directory
.cd ecommerce-laravel-backend

Install the dependencies
.composer install

Create a new MySQL database and add the details to the .env file

.DB_CONNECTION=mysql
.DB_HOST=127.0.0.1
.DB_PORT=3306
.DB_DATABASE=your_db_name
.DB_USERNAME=your_db_username
.DB_PASSWORD=your_db_password

Add your Mpesa API keys and secret to the .env file
.Consumer_Key=#your mpesa app consumer key 
.Consumer_Secret=#your mpesa consumer secret

Run the migrations to create the necessary tables in the database
.php artisan migrate

Start the development server
.php artisan serve
.Your backend should now be up and running on http://localhost:8000. 

You can now connect your android app to this backend to start building your ecommerce app.

Please note that this is a brief description. For more details, such as how to test the backend, how to deploy,and   handle errors and troubleshoot,  view  the API documentation <a href="#">here</a>.
