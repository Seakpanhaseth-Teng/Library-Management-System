# Library Management System

A web-based library management system built with **Laravel 12** and **Blade Templates**, designed to help librarians manage book collections, track availability, and organize inventory efficiently.

---

## Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| ORM | Eloquent |
| Database | SQLite (default), MySQL, or PostgreSQL |
| Frontend | Blade Templates, Bootstrap 5.3 |
| Build Tool | Vite 6 |
| Testing | PHPUnit 11 |

---

## Features

- **Email/Password Authentication** — Register, login, and logout
- **Email Verification** — One-time email verification on registration
- **Password Reset** — Forgot password flow with email reset link
- **Rate Limiting** — Login throttled (5 attempts), registration throttled (3 attempts)
- **View All Books** — Browse the complete library inventory in a table layout
- **Filter by Genre** — Quickly find Fiction or Non-Fiction titles
- **Availability Tracking** — See which books are ready to borrow
- **Add New Books** — Create book records with full metadata
- **Edit & Delete Books** — Update or remove book records
- **Search** — Find books by title, author, or ISBN
- **Detailed Book Info** — Title, Author, ISBN, Genre, Year, Publisher, Pages, Shelf Location, and Copy Count
- **Pagination** — All book listings are paginated

---

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm
- SQLite (or MySQL/PostgreSQL)

### Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd library-management

# 2. Install dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Set up the database
php artisan migrate
php artisan db:seed   # Optional: seed with sample data

# 5. Build frontend assets
npm run build

# 6. Start the development server
php artisan serve
```

Visit `http://127.0.0.1:8000` to access the app.

---

## Usage

| Page | URL |
|------|-----|
| Home | `/` |
| Login | `/login` |
| Register | `/register` |
| Forgot Password | `/forgot-password` |
| All Books | `/all/books` |
| Available Books | `/books/available` |
| Fiction | `/books/fiction` |
| Non-Fiction | `/books/nonfiction` |
| Add a Book | `/createbook` |

Book pages require authentication. Register an account, verify your email, then browse the collection.

---

## Routes

| Method | Route | Middleware | Controller | Description |
|--------|-------|-----------|------------|-------------|
| GET | `/` | — | — | Welcome page |
| GET | `/login` | `guest` | `LoginController@showLoginForm` | Login form |
| POST | `/login` | `guest` | `LoginController@login` | Log in |
| GET | `/register` | `guest` | `RegisterController@showRegistrationForm` | Register form |
| POST | `/register` | `guest` | `RegisterController@register` | Register |
| GET | `/forgot-password` | `guest` | `PasswordResetLinkController@create` | Forgot password form |
| POST | `/forgot-password` | `guest` | `PasswordResetLinkController@store` | Send reset link |
| GET | `/reset-password/{token}` | `guest` | `NewPasswordController@create` | Reset password form |
| POST | `/reset-password` | `guest` | `NewPasswordController@store` | Reset password |
| GET | `/verify-email` | `auth` | `EmailVerificationPromptController` | Verification notice |
| GET | `/verify-email/{id}/{hash}` | `auth,signed` | `VerifyEmailController` | Verify email |
| POST | `/email/verification-notification` | `auth,throttle` | `EmailVerificationNotificationController@store` | Resend verification |
| POST | `/logout` | `auth` | `LogoutController@logout` | Log out |
| GET | `/all/books` | `auth` | `LibraryController@allBooks` | All books (paginated) |
| GET | `/books/search` | `auth` | `LibraryController@search` | Search books |
| GET | `/books/available` | `auth` | `LibraryController@availableBooks` | Available books |
| GET | `/books/fiction` | `auth` | `LibraryController@fictionBooks` | Fiction books |
| GET | `/books/nonfiction` | `auth` | `LibraryController@nonFictionBooks` | Non-fiction books |
| GET | `/books/{id}/edit` | `auth` | `LibraryController@editBook` | Edit book form |
| PUT | `/books/{id}` | `auth` | `LibraryController@updateBook` | Update book |
| DELETE | `/books/{id}` | `auth` | `LibraryController@deleteBook` | Delete book |
| GET | `/createbook` | `auth` | — | Book creation form |
| POST | `/books/add` | `auth` | `LibraryController@addBook` | Save new book |

---

## Database Schema

### Table: `users`

| Column | Type | Description |
|--------|------|-------------|
| `id` | BIGINT (PK) | Unique identifier |
| `name` | VARCHAR(255) | Full name |
| `email` | VARCHAR(255) | Email address (unique) |
| `email_verified_at` | TIMESTAMP | Email verification timestamp |
| `password` | VARCHAR(255) | Hashed password |
| `remember_token` | VARCHAR(100) | Remember me token |
| `created_at` | TIMESTAMP | Record created |
| `updated_at` | TIMESTAMP | Record last updated |

### Table: `library_books`

| Column | Type | Description |
|--------|------|-------------|
| `id` | BIGINT (PK) | Unique identifier |
| `title` | VARCHAR(255) | Book title |
| `author` | VARCHAR(255) | Author name |
| `genre` | VARCHAR(100) | Genre (Fiction / Non-Fiction) |
| `isbn` | VARCHAR(20) | ISBN number |
| `publication_year` | INTEGER | Year published |
| `publisher` | VARCHAR(255) | Publisher name |
| `pages` | INTEGER | Page count |
| `shelf_location` | VARCHAR(50) | Physical location |
| `available_copies` | INTEGER | Copies available |
| `is_available` | TINYINT(1) | Availability status (0/1) |
| `created_at` | TIMESTAMP | Record created |
| `updated_at` | TIMESTAMP | Record last updated |

---

## Project Structure

```
library-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── EmailVerificationNotificationController.php
│   │   │   │   ├── EmailVerificationPromptController.php
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── LogoutController.php
│   │   │   │   ├── NewPasswordController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── VerifyEmailController.php
│   │   │   ├── Controller.php
│   │   │   └── LibraryController.php
│   │   └── Requests/
│   │       ├── Auth/
│   │       │   ├── LoginRequest.php
│   │       │   └── RegisterRequest.php
│   │       └── StoreBookRequest.php
│   └── Models/
│       ├── LibraryBook.php
│       └── User.php
├── config/
│   └── ...
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   ├── reset-password.blade.php
│       │   └── verify-email.blade.php
│       ├── books/
│       │   ├── _form.blade.php
│       │   ├── all_books.blade.php
│       │   ├── available.blade.php
│       │   ├── create_book.blade.php
│       │   ├── edit.blade.php
│       │   └── genre.blade.php
│       ├── emails/
│       │   └── password-reset.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       └── welcome.blade.php
├── routes/
│   ├── web.php
│   └── console.php
└── tests/
    ├── Feature/
    │   ├── AuthTest.php
    │   └── ExampleTest.php
    └── Unit/
        └── ExampleTest.php
```

---

## Development

```bash
# Hot reload for frontend development
npm run dev

# Production build
npm run build

# Run tests
php artisan test

# Fix code style
php artisan pint
```

---

## Key Dependencies

**Backend**
- `laravel/framework` ^12.0
- `laravel/tinker` ^2.10.1

**Frontend**
- `tailwindcss` ^4.0.0
- `axios` ^1.8.2
- `laravel-vite-plugin` ^1.2.0

**Dev**
- `phpunit/phpunit` ^11.5.3
- `fakerphp/faker` ^1.23
- `laravel/pint` ^1.13

---

## Security Notes

- Never commit `.env` to version control
- Use strong database credentials in production
- Enable HTTPS in production
- Validate and sanitize all user inputs
- Leverage Laravel's built-in CSRF protection and rate limiting

---

## License

Licensed under the [MIT License](LICENSE).

---

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Templates](https://laravel.com/docs/blade)
- [Bootstrap 5](https://getbootstrap.com/docs/5.3)
- [Vite](https://vitejs.dev/guide/)
- [Eloquent ORM](https://laravel.com/docs/eloquent)
