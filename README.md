# Warehouse Management System

## Overview
The Warehouse Management System is a web application designed to help manage inventory and user accounts efficiently. It features two distinct views: one for users and another for administrators, allowing for streamlined operations and management.

## Project Structure
The project is organized into the following directories and files:

```
warehouse-management-system
├── public
│   ├── css
│   │   └── tailwind.css
│   ├── index.html
│   └── js
│       └── app.js
├── src
│   ├── admin
│   │   ├── dashboard.php
│   │   ├── inventory.php
│   │   └── users.php
│   ├── user
│   │   ├── dashboard.php
│   │   └── inventory.php
│   ├── config
│   │   └── database.php
│   ├── controllers
│   │   ├── adminController.php
│   │   └── userController.php
│   ├── models
│   │   ├── inventoryModel.php
│   │   └── userModel.php
│   └── views
│       ├── admin
│       │   ├── dashboard.php
│       │   └── inventory.php
│       └── user
│           ├── dashboard.php
│           └── inventory.php
├── .env
├── composer.json
├── README.md
└── tailwind.config.js
```

## Technologies Used
- **HTML**: For structuring the web pages.
- **PHP**: For server-side scripting and handling business logic.
- **MySQL**: For database management and storage of inventory and user data.
- **Tailwind CSS**: For styling the application with a utility-first CSS framework.

## Setup Instructions
1. **Clone the Repository**: 
   ```
   git clone <repository-url>
   cd warehouse-management-system
   ```

2. **Install Dependencies**: 
   Ensure you have Composer installed, then run:
   ```
   composer install
   ```

3. **Configure Environment Variables**: 
   Rename the `.env.example` file to `.env` and update the database credentials.

4. **Set Up Database**: 
   Create a MySQL database and run the necessary SQL scripts to set up the required tables.

5. **Run the Application**: 
   Use a local server (like XAMPP) to serve the `public` directory and access the application via your web browser.

## Usage
- **Admin View**: Access the admin dashboard to manage inventory and user accounts.
- **User View**: Users can view available inventory and manage their profiles.

## Contributing
Contributions are welcome! Please submit a pull request or open an issue for any enhancements or bug fixes.

## License
This project is licensed under the MIT License. See the LICENSE file for details.



