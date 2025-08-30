# Laravel API Starter Kit

A powerful and feature-rich Laravel starter kit for building REST APIs with modern development tools and best practices.

## Features

### Core Features
- 🚀 **Laravel 12** - Latest Laravel framework
- 🔐 **Authentication** - Laravel Sanctum for API authentication
- 👥 **Role & Permissions** - Spatie Laravel Permission package
- 📁 **Media Management** - Spatie Media Library for file handling
- 🔍 **Advanced Querying** - Spatie Query Builder for filtering and sorting
- 📄 **API Pagination** - JSON API pagination support

### Development Tools
- 🛠️ **Custom Artisan Commands** - Generators for Service, API Controller, Query Builder
- 📮 **Postman Integration** - Auto-generate Postman collections
- 🐛 **Debugging Tools** - Laradumps for enhanced debugging
- ⚡ **Laravel Boost** - MCP server for improved development experience

### Packages Included
- `spatie/laravel-permission` - Role and permission management
- `spatie/laravel-medialibrary` - File and media management
- `spatie/laravel-query-builder` - Advanced API filtering
- `spatie/laravel-json-api-paginate` - JSON API pagination
- `laravel/sanctum` - API authentication
- `laradumps/laradumps` - Advanced debugging
- `laravel/boost` - Laravel MCP server

## Quick Start

### Installation
```bash
# Clone the repository
git clone <repository-url>
cd laravel-api-starter

# Install dependencies
composer install

# Setup environment
copy .env.example .env
php artisan key:generate

# Configure database and run migrations
php artisan migrate

# Setup development tools
php artisan boost:install
php artisan laradumps:install
```

📖 **Detailed installation guide:** [docs/installation.md](docs/installation.md)

## Custom Commands

This starter kit includes powerful Artisan commands to speed up development:

- `php artisan make:service {name}` - Generate service with request classes
- `php artisan make:api {name}` - Generate API controller with resources
- `php artisan make:query {name}` - Generate query builder class
- `php artisan postman:generate-groups` - Generate Postman collection

📖 **Complete commands documentation:** [docs/console-commands.md](docs/console-commands.md)

## Architecture

- **Services** - Business logic layer
- **Repositories** - Data access layer with query builders
- **Resources** - API response transformation
- **Requests** - Input validation and authorization

## Requirements

- PHP 8.3+
- Composer
- PostgreSQL (default) or other database

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
