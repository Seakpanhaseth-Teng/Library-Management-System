# 📚 Library Management System

A web-based library management system built with **Laravel 12** and **Blade Templates**, designed to help librarians manage book collections, track availability, and organize inventory efficiently.

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12 (PHP 8.2+) |
| ORM | Eloquent |
| Database | SQLite (default), MySQL, or PostgreSQL |
| Frontend | Blade Templates, Tailwind CSS 4.0, Bootstrap 5.3 |
| Build Tool | Vite 6.2.4 |
| Testing | PHPUnit 11.5.3 |

---

## ✨ Features

- **View All Books** — Browse the complete library inventory in a table layout
- **Filter by Genre** — Quickly find Fiction or Non-Fiction titles
- **Availability Tracking** — See which books are ready to borrow
- **Add New Books** — Create book records with full metadata
- **Detailed Book Info** — Title, Author, ISBN, Genre, Year, Publisher, Pages, Shelf Location, and Copy Count

---

## 🚀 Getting Started

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

## 📖 Usage

| Page | URL |
|------|-----|
| Home | `/` |
| All Books | `/all/books` |
| Available Books | `/books/available` |
| Fiction | `/books/fiction` |
| Non-Fiction | `/books/nonfiction` |
| Add a Book | `/createbook` |

To add a book, navigate to `/createbook`, fill in the details, and click **Submit**. You'll be redirected to the full book list on save.

---

## 🌐 Routes

| Method | Route | Controller Method | Description |
|--------|-------|-------------------|-------------|
| GET | `/` | — | Welcome page |
| GET | `/all/books` | `LibraryController@allBooks` | All books |
| GET | `/books/available` | `LibraryController@availableBooks` | Available books |
| GET | `/books/fiction` | `LibraryController@fictionBooks` | Fiction books |
| GET | `/books/nonfiction` | `LibraryController@nonFictionBooks` | Non-fiction books |
| GET | `/createbook` | — | Book creation form |
| POST | `/books/add` | `LibraryController@addBook` | Save new book |

---

## 🗄️ Database Schema

**Table: `library_books`**

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT (PK) | Unique identifier |
| `title` | VARCHAR | Book title |
| `author` | VARCHAR | Author name |
| `genre` | VARCHAR | Fiction / Non-Fiction |
| `isbn` | VARCHAR | ISBN number |
| `publication_year` | INT | Year published |
| `publisher` | VARCHAR | Publisher name |
| `pages` | INT | Page count |
| `shelf_location` | VARCHAR | Physical location |
| `available_copies` | INT | Copies available |
| `is_available` | BOOLEAN | Availability status |
| `created_at` | TIMESTAMP | Record created |
| `updated_at` | TIMESTAMP | Record last updated |

---

## 📁 Project Structure

```
library-management/
├── app/
│   ├── Http/Controllers/
│   │   ├── LibraryController.php   # Core book management
│   │   └── BookController.php
│   └── Models/
│       ├── LibraryBook.php
│       ├── Book.php
│       └── User.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── books/
│   │   │   ├── all_books.blade.php
│   │   │   ├── available.blade.php
│   │   │   ├── fiction.blade.php
│   │   │   ├── nonfiction.blade.php
│   │   │   └── createbook.blade.php
│   │   └── welcome.blade.php
│   ├── css/app.css
│   └── js/
├── routes/
│   ├── web.php
│   └── console.php
└── tests/
    ├── Feature/
    └── Unit/
```

---

## 🧑‍💻 Development

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

## 📦 Key Dependencies

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

## 🔐 Security Notes

- Never commit `.env` to version control
- Use strong database credentials in production
- Enable HTTPS in production
- Validate and sanitize all user inputs
- Leverage Laravel's built-in CSRF protection

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/your-feature`
3. Commit your changes: `git commit -m 'Add your feature'`
4. Push to the branch: `git push origin feature/your-feature`
5. Open a Pull Request

---

## 📄 License

Licensed under the [MIT License](LICENSE).

---

## 🎓 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Templates](https://laravel.com/docs/blade)
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Vite](https://vitejs.dev/guide/)
- [Eloquent ORM](https://laravel.com/docs/eloquent)