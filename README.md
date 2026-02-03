# FinOrganizer

This program is a web-based system for personal finance control. It allows adding incomes and expenses and also see the graphic relationship between both. The main page is on `index.html`, but the program also allows using `index.php` to login. 

## How to use

Firstly you have to activate the _localhost_ conection by installing PHP and creating the MySQL database using the script on `finorganizer.sql`. After that use your credentials of the database to access the system, filling the `conectar_banco.php` file. That's enough for using the program. Remember: you have to have PHP and MySQL installed on your computer. XAMPP is not required exclusively.

Download PHP [here](https://www.php.net/downloads.php). 

Download MySQL [here](https://dev.mysql.com/downloads/).

If you're using Visual Studio Code to access this project, use the command `php -S localhost:xxx` (xxx is the port) on the specific folder and type `localhost` on your browser search bar.

## Technologies used 

PHP, MySQL, HTML, CSS and JavaScript.

## Features

* Modules: balance, incomes and expenses
* Incomes entry
* Expenses entry
* Incomes listing
* Expenses listing
* Balance view
* Edit incomes entries
* Edit expenses entries
* Delete incomes entries
* Delete expenses entries

These information are available also in PT-BR on the `escopo_bd.txt` file.

## Screenshots

![Login page](./assets/login.png "Login page")
![Main screen](./assets/main-screen.png "Main screen")