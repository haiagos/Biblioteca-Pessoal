# Personal Library CRUD Application

This is a PHP CRUD application for managing a personal library. The application allows users to register, log in, and manage their collection of books.

## Features

- User registration and authentication
- Create, read, update, and delete (CRUD) operations for books
- Responsive design with a user-friendly interface
- Data stored in JSON format for simplicity

## Project Structure

```
bibliotecapessoal
├── public
│   ├── index.php               # Entry point of the application
│   ├── .htaccess               # URL rewriting and server configuration
│   └── assets
│       ├── css
│       │   └── styles.css      # CSS styles for the application
│       └── js
│           └── app.js          # JavaScript code for the application
├── src
│   ├── Controllers
│   │   ├── AuthController.php   # Handles user authentication
│   │   ├── BookController.php    # Manages book-related operations
│   │   └── UserController.php    # Manages user-related operations
│   ├── Models
│   │   ├── Book.php              # Represents the book data structure
│   │   └── User.php              # Represents the user data structure
│   ├── Views
│   │   ├── layouts
│   │   │   ├── header.php        # Header layout for the application
│   │   │   └── footer.php        # Footer layout for the application
│   │   ├── auth
│   │   │   ├── login.php         # Login view
│   │   │   ├── register.php      # Registration view
│   │   │   └── post-registration.php # Post-registration view
│   │   └── books
│   │       ├── index.php         # View for displaying the list of books
│   │       ├── create.php        # View for creating a new book
│   │       ├── edit.php          # View for editing an existing book
│   │       └── show.php          # View for displaying a single book's details
│   ├── Middleware
│   │   └── AuthMiddleware.php     # Handles authentication checks
│   ├── Router.php                # Responsible for routing requests
│   ├── Database.php              # Handles database connections
│   └── Helpers.php               # Contains helper functions
├── routes
│   └── web.php                  # Defines application routes
├── config
│   ├── app.php                  # Application configuration settings
│   └── database.php             # Database configuration settings
├── database
│   ├── schema.sql               # SQL schema for database tables
│   └── seed.sql                 # SQL commands for seeding the database
├── data
│   └── users.json               # Stores user data in JSON format
├── composer.json                 # Composer configuration file
├── .env.example                  # Template for environment variables
├── README.md                     # Documentation for the project
└── LICENSE                       # Licensing information
```

## Installation

1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Install the required dependencies using Composer.
4. Set up your database configuration in the `config/database.php` file.
5. Run the application using a local server (e.g., XAMPP, MAMP).

## Usage

- Visit the registration page to create a new account.
- After successful registration, you will be redirected to the post-registration page.
- Log in to manage your books and view your collection.

## Contributing

Contributions are welcome! Please open an issue or submit a pull request for any enhancements or bug fixes.

## License

This project is licensed under the MIT License. See the LICENSE file for more details.