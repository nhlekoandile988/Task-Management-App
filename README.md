<<<<<<< HEAD
# Smart Drive - Laravel Task Management App

Smart Drive is a Laravel task management application for a car dealership sales team. It helps staff track customer leads, test drives, finance applications, delivery paperwork, and after-sales follow-ups.

## Project Type

This project uses the assessment option: **Task Management App**.

## Technologies

- Backend: Laravel, PHP, Eloquent ORM
- Frontend: Blade templates with Bootstrap 5
- Authentication: Laravel session authentication with login and registration screens
- Database: SQLite by default for local setup
- Authorization: Laravel policies, gates, and custom role middleware
- Brand palette: Navy `#1E3A5F`, Coral `#FF6B6B`, Silver `#D3D3D3`

Note: this project was found with Laravel 9 dependencies installed. The assessment requires Laravel 12 or newer, so the framework dependencies should be upgraded before final submission if Composer updates are available.

## Features

- User registration, login, and logout
- Roles: Admin, Team Member, Guest
- Car-sales task CRUD with assignee, category, priority, status, and deadline
- Task categories such as Sales Leads, Test Drives, Finance Applications, Vehicle Delivery, and After-Sales Follow Up
- Task filtering by status and priority
- Email deadline reminders for assigned tasks due within two days
- Category management for Admin and Team Member users
- Role middleware and policy-based access control
- Custom request logging middleware
- Custom deadline validation rule
- Eloquent relationships, scopes, accessor, mutator, observer, and seeded data

## Setup

1. Ensure `.env` exists.
2. Set `APP_URL=http://task-management-app.test`.
3. Ensure the SQLite database file exists at `database/database.sqlite`.
4. Configure email delivery in `.env` before sending reminders.

   - For local SMTP testing with MailHog/Mailpit/smtp4dev:
     ```env
     MAIL_MAILER=smtp
     MAIL_HOST=127.0.0.1
     MAIL_PORT=1025
     MAIL_USERNAME=null
     MAIL_PASSWORD=null
     MAIL_ENCRYPTION=null
     MAIL_FROM_ADDRESS=hello@example.com
     MAIL_FROM_NAME="Smart Drive"
     ```
   - To avoid sending email in local development and log messages instead:
     ```env
     MAIL_MAILER=log
     ```

5. Use Herd PHP to run:

```bash
php artisan config:clear
php artisan migrate --seed
php artisan smartdrive:send-deadline-reminders
```

When using Laravel Herd, open:

```text
http://task-management-app.test
```

## Seeded Accounts

All seeded users use the password `password`.

- Smart Drive Manager: `admin@smartdrive.test`
- Smart Drive Consultant: `consultant@smartdrive.test`
- Smart Drive Guest: `guest@smartdrive.test`

## Database Schema

`users`: name, email, password, role, timestamps.

`categories`: name, color, timestamps.

`tasks`: category, assignee, creator, title, description, priority, status, deadline, reminder timestamp, timestamps.

Relationships:

- A user has many assigned tasks and created tasks.
- A category has many tasks.
- A task belongs to a category, assignee, and creator.

## Template Source

The interface is a custom Blade conversion inspired by Bootstrap's official dashboard and card/table patterns.

Template/provider source: Bootstrap 5 documentation and examples, https://getbootstrap.com/docs/5.3/examples/

Vehicle image source: Unsplash car photography embedded through remote image URLs.

## Demo Guide

1. Login as the Sales Manager.
2. View dashboard metrics and recent car sales tasks.
3. Create a category such as Trade-In Evaluations.
4. Create a task for a customer lead, test drive, finance application, or vehicle delivery.
5. Assign the task to the Sales Consultant.
6. Update the task status from Pending to In Progress to Completed.
7. Send deadline reminder emails from the dashboard or by running `php artisan smartdrive:send-deadline-reminders`.
8. Login as Guest Viewer and confirm restricted controls.
=======
# Task-Management-App
>>>>>>> 17e21cf15ef972876851df5611edfee31edb89b2
