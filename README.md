# Mercadona Project

The Mercadona Project is an e-commerce web application developed with Symfony 6.2.1.

## Description
This project aims to create an online shopping platform for a store called Mercadona. The application allows users to browse and purchase a variety of products in different categories.

## Features
- User registration and login
- Display products by category
- Product search
- Add products to the shopping cart
- Payment process
- Order management and purchase history
- Inventory management

## Technologies Used
- Symfony 6.2.1
- PHP 8.0
- HTML5, CSS3, JavaScript
- Twig (template engine)
- Doctrine (ORM)
- PostgreSQL database
- Bootstrap (CSS framework)

## Installation
1. Clone the GitHub repository: `git clone https://github.com/your-repo.git`
2. Install dependencies: `composer install`
3. Configure the database connection in the `.env` file
4. Create the database: `php bin/console doctrine:database:create`
5. Apply migrations: `php bin/console doctrine:migrations:migrate`
6. Start the development server: `symfony serve`

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

Feel free to customize this README.md file by adding more details about your project, specific features, and installation instructions.
