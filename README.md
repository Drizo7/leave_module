# Employee Leave Management System 🏢

![Laravel](https://img.shields.io/badge/Laravel-v10.0-FF2D20)
![Vue.js](https://img.shields.io/badge/Vue.js-v3.0-4FC08D)
![Inertia](https://img.shields.io/badge/Inertia.js-v1.0-8F00FF)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-v3.0-38B2AC)
![License](https://img.shields.io/badge/License-MIT-yellow.svg)

## Overview 📋

The Leave Management System is a comprehensive web application built with Laravel and Vue.js that streamlines the employee leave request and approval process. Using Inertia.js for seamless client-server communication and Spatie for robust role-based permissions, the system provides an efficient way to manage organizational leave requests.

## Features ✨

### User Roles
- **Super Admin**
  - Full system control and configuration
  - Manage user roles and permissions
  - Access to all system features and reports
  - Override any leave decisions

- **Admin**
  - Review and manage leave requests
  - Approve or reject leave applications
  - Generate leave reports

- **Employee**
  - Submit leave requests
  - Track application status
  - View leave history

### Leave Management
- Multiple leave types support
- Real-time leave balance tracking
- Leave history tracking

### Dashboard
- Overview of pending requests
- Leave statistics and analytics
- Quick actions menu

## Technologies Used 🛠️

- **Frontend**
  - Vue.js 3
  - Tailwind CSS
  - Inertia.js

- **Backend**
  - Laravel 10
  - MySQL
  - Spatie Permissions

- **Authentication**
  - Laravel Breeze

## Installation 💻

1. Clone the repository
```bash
git clone https://github.com/Drizo7/leave-management.git
```

2. Install PHP dependencies
```bash
composer install
```

3. Install NPM dependencies
```bash
npm install
```

4. Create environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure database in .env file
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

7. Run migrations and seeders
```bash
php artisan migrate --seed
```

8. Start the development server
```bash
php artisan serve
npm run dev
```

## Usage 📱

1. Access the application through your web browser
   
2. Register and Login with credentials

3. Navigate through the dashboard to:
   - Submit leave requests (Employee)
   - Approve/Reject requests (Admin)
   - Manage system settings (Super Admin)

## Contributing 🤝
Feel free to contribute to the project!

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/NewFeature`)
3. Commit your changes (`git commit -m 'Add this Feature'`)
4. Push to the branch (`git push origin feature/NewFeature`)
5. Open a Pull Request

## License 📄

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---
Made with ❤️ by [Driz7]
