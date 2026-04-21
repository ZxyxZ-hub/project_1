# Authentication System Setup Guide

## Overview
Your authentication system has been completely rebuilt with the following features:

### 1. **Authentication System**
- Users must login to access any page
- Sessions are used to track logged-in users
- Auth filter protects all routes except auth pages

### 2. **User Roles**
- **Admin**: Can manage users, approve/deny sign-ups, reset passwords, change user roles
- **User**: Can create and manage forms after login

### 3. **Features**

#### For Everyone:
- ✅ Login page (keeps your existing design)
- ✅ Signup page for new users
- ✅ Password protection using bcrypt

#### For Users:
- ✅ Access form creation page after login
- ✅ Create, view, and manage forms

#### For Admins:
- ✅ Admin dashboard to manage users
- ✅ Approve pending user signups
- ✅ Deny/reject user signups
- ✅ Change user roles (user ↔ admin)
- ✅ Reset user passwords
- ✅ View user account details
- ✅ Delete users

## Setup Instructions

### Step 1: Configure Database
Edit `app/Config/Database.php` and verify these settings:
```php
'hostname'     => 'localhost',
'username'     => 'root',
'password'     => '',
'database'     => 'project1',
```

### Step 2: Initialize Database
Visit this URL in your browser:
```
http://localhost/project_1/public/setup
```

This will:
- Create `users` table
- Create `forms` table
- Create admin account (email: `admin`, password: `admin123`)

### Step 3: Login with Admin Account
1. Go to `http://localhost/project_1/public/auth/login`
2. Use credentials:
   - Email: `admin`
   - Password: `admin123`

### Step 4: Create Test Users
1. Go to `http://localhost/project_1/public/auth/signup`
2. Create a new user account
3. Login as admin and approve the signup
4. Assign the user role ("user" or "admin")

## User Flow

### Admin Login
```
Login → Admin Dashboard
       ├─ View pending signups
       ├─ Approve/Deny users
       ├─ View user details
       ├─ Change user roles
       ├─ Reset user passwords
       └─ Delete users
```

### User Login
```
Login → Form Page
      ├─ Create forms
      ├─ View forms
      ├─ Edit forms
      └─ Delete forms
```

### New User (No Account)
```
Signup Page → Create Account → Wait for Admin Approval → Can Login
```

## File Structure Changes

### Controllers
- `Auth.php` - Handles login, signup, logout
- `Admin.php` - Admin dashboard and user management
- `Form.php` - Form creation and management
- `Setup.php` - Database initialization

### Models
- `UserModel.php` - User database operations
- `FormModel.php` - Form database operations

### Filters
- `AuthFilter.php` - Protects routes, checks login & roles

### Views
- `auth/login.php` - Login page (your existing design kept)
- `auth/signup.php` - Signup page
- `admin/dashboard.php` - Admin dashboard with modals
- `form_page.php` - User form page
- `setup.php` - Setup initialization page

### Routes
All routes are protected with auth filter:
- `/` - Redirects to login
- `/auth/login` - Login page
- `/auth/signup` - Signup page
- `/admin` - Admin dashboard (requires admin role)
- `/form` - User form page (requires login)

## Security Features

✅ Password hashing using bcrypt
✅ Session-based authentication
✅ Route protection with auth filter
✅ CSRF token on all forms
✅ Role-based access control
✅ SQL injection prevention

## Default Admin Account

After running setup, you can login with:
- **Email**: admin
- **Password**: admin123

⚠️ **IMPORTANT**: Change this password immediately in production!

## Support

If you encounter any issues:
1. Make sure MySQL is running
2. Verify database credentials in `app/Config/Database.php`
3. Check that the database name is `project1`
4. Make sure `baseURL` in `app/Config/App.php` is set to `http://localhost/project_1/public/`
