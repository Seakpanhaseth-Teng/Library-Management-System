```markdown
# Library Management System

A comprehensive web-based library management system built with **Laravel 12** and **Blade Templates**. This application allows librarians and administrators to manage books, track availability, and organize library inventory efficiently.

## 🎯 About This Project

The Library Management System is a full-featured application designed to help libraries manage their book collections effectively. It provides intuitive interfaces for browsing books by genre, viewing availability, and adding new books to the library inventory.

## 💻 Tech Stack

### Backend
- **Framework**: [Laravel 12](https://laravel.com) - Modern PHP web framework
- **PHP Version**: 8.2+
- **ORM**: Eloquent (Laravel's native ORM)
- **Database**: SQLite (default) or MySQL/PostgreSQL

### Frontend
- **Templating**: Blade (Laravel's templating engine)
- **Styling**: [Tailwind CSS 4.0](https://tailwindcss.com) - Utility-first CSS framework
- **UI Components**: Bootstrap 5.3 (for tables in book views)
- **Build Tool**: [Vite 6.2.4](https://vitejs.dev) - Fast module bundler

### Development Tools
- **Testing**: PHPUnit 11.5.3
- **Code Analysis**: Pint (Laravel code style fixer)
- **Package Manager**: Composer, npm
- **Development Server**: Laravel Sail (Docker-based)

## ✨ Features

### Core Functionality
- **📚 View All Books**: Display complete library inventory with detailed information
- **🔍 Filter by Genre**: Browse books by category (Fiction, Non-Fiction)
- **✅ Availability Tracking**: Check which books are available for borrowing
- **➕ Add New Books**: Create and add new book records to the library system
- **📋 Book Details**: Track comprehensive book information including:
  - Title and Author
  - Genre and ISBN
  - Publication Year
  - Publisher Name
  - Page Count
  - Shelf Location
  - Available Copy Count
  - Availability Status

### User Interface
- Responsive design for desktop and mobile devices
- Clean, intuitive navigation
- Bootstrap-styled data tables for easy browsing
- Form-based book creation interface

## 📁 Project Structure

```
library-management/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── LibraryController.php    # Main book management controller
│   │       └── BookController.php
│   └── Models/
│       ├── LibraryBook.php              # Main book model
│       ├── Book.php
│       └── User.php
├── database/
│   ├── migrations/
│   │   └── 2025_05_07_092636_create_library_books_table.php
│   ├── seeders/
│   │   ├── BookSeeder.php
│   │   └── DatabaseSeeder.php
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
│   ├── css/
│   │   └── app.css                      # Tailwind styles
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── routes/
│   ├── web.php                          # Web application routes
│   └── console.php
├── config/
│   ├── app.php
│   ├── database.php
│   └── ... (other config files)
├── tests/
│   ├── Feature/
│   └── Unit/
├── composer.json
├── package.json
├── vite.config.js
├── phpunit.xml
└── README.md
```

## 🚀 Getting Started

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js & npm
- SQLite (or MySQL/PostgreSQL if you prefer)

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd library-management
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Set up the database**
   ```bash
   # Run migrations to create tables
   php artisan migrate
   
   # Optional: Seed the database with sample data
   php artisan db:seed
   ```

6. **Build frontend assets**
   ```bash
   npm run build
   ```

7. **Start the development server**
   ```bash
   php artisan serve
   ```

The application will be available at `http://127.0.0.1:8000`

## 📖 Usage Guide

### Viewing Books

**Home Page**: Navigate to `http://127.0.0.1:8000/` to see the welcome page

**View All Books**: 
- Go to `http://127.0.0.1:8000/all/books`
- Displays all books in the library in a table format
- Shows: Title, Author, Publisher, Year, Genre, Pages, Shelf Location, Available Copies

**View Available Books**:
- Go to `http://127.0.0.1:8000/books/available`
- Shows books currently available for borrowing

**Filter by Genre**:
- **Fiction**: `http://127.0.0.1:8000/books/fiction`
- **Non-Fiction**: `http://127.0.0.1:8000/books/nonfiction`

### Adding Books

1. Navigate to `http://127.0.0.1:8000/createbook`
2. Fill in the book details:
   - Title
   - Author
   - Genre
   - ISBN
   - Publication Year
   - Publisher
   - Number of Pages
   - Shelf Location
   - Available Copies
   - Availability Status
3. Click "Submit" to add the book to the library
4. You'll be redirected to the all books view

## 🌐 API Routes

The application exposes the following web routes:

| Method | Route | Controller | Description |
|--------|-------|-----------|-------------|
| GET | `/` | - | Welcome page |
| GET | `/all/books` | `LibraryController@allBooks` | View all books |
| GET | `/books/available` | `LibraryController@availableBooks` | View available books |
| GET | `/books/fiction` | `LibraryController@fictionBooks` | View fiction books |
| GET | `/books/nonfiction` | `LibraryController@nonFictionBooks` | View non-fiction books |
| GET | `/createbook` | - | Display book creation form |
| POST | `/books/add` | `LibraryController@addBook` | Add a new book |

## 🗄️ Database Schema

### library_books Table

| Column | Type | Description |
|--------|------|-------------|
| id | INT (Primary Key) | Unique book identifier |
| title | VARCHAR | Book title |
| author | VARCHAR | Author name |
| genre | VARCHAR | Genre (Fiction/Non-Fiction) |
| isbn | VARCHAR | ISBN number |
| publication_year | INT | Year of publication |
| publisher | VARCHAR | Publisher name |
| pages | INT | Total pages |
| shelf_location | VARCHAR | Physical location in library |
| available_copies | INT | Number of available copies |
| is_available | BOOLEAN | Availability status |
| created_at | TIMESTAMP | Creation timestamp |
| updated_at | TIMESTAMP | Last update timestamp |

## 🛠️ Development

### Development Server with Hot Reload

```bash
npm run dev
```

This starts Vite's development server with hot module replacement for fast frontend development.

### Build for Production

```bash
npm run build
```

### Run Tests

```bash
php artisan test
```

### Code Style Formatting

```bash
php artisan pint
```

## 📝 Available NPM Scripts

```json
{
  "build": "vite build",      // Production build
  "dev": "vite"               // Development server
}
```

## 📦 Key Dependencies

**Backend**:
- `laravel/framework` ^12.0
- `laravel/tinker` ^2.10.1

**Frontend**:
- `tailwindcss` ^4.0.0
- `axios` ^1.8.2
- `laravel-vite-plugin` ^1.2.0
- `@tailwindcss/vite` ^4.0.0

**Development**:
- `phpunit/phpunit` ^11.5.3
- `fakerphp/faker` ^1.23
- `mockery/mockery` ^1.6
- `laravel/pint` ^1.13

## 🔐 Security Notes

- Always keep .env file secure and never commit it to version control
- Use strong database credentials in production
- Enable HTTPS in production environments
- Validate and sanitize all user inputs
- Use Laravel's built-in security features (CSRF protection, etc.)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 📞 Support

For issues, questions, or suggestions, please open an issue in the repository or contact the development team.

## 🎓 Learning Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Blade Templates Guide](https://laravel.com/docs/blade)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)
- [Vite Guide](https://vitejs.dev/guide/)
- [Laravel Eloquent ORM](https://laravel.com/docs/eloquent)

---

**Last Updated**: March 2026  
**Version**: 1.0.0
```

You can copy this entire README content and paste it directly into your `README.md` file. The document is well-structured with sections for tech stack, features, setup instructions, usage guide, routes, database schema, and development information.You can copy this entire README content and paste it directly into your `README.md` file. The document is well-structured with sections for tech stack, features, setup instructions, usage guide, routes, database schema, and development information.