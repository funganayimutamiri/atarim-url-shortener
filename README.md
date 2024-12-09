 Atarim URL Shortener Service

A Laravel-based URL shortening service developed as a technical assessment for Atarim's Mid-Level Laravel/PHP Developer position.

 Project Overview

This application demonstrates a clean, efficient implementation of a URL shortening service using Laravel 11 and PHP 8.3. It features both a RESTful API and a user-friendly frontend interface built with Tailwind CSS and Alpine.js.

 Key Features

- URL shortening with unique hash generation
- Direct URL redirection
- Clean, responsive UI
- Copy-to-clipboard functionality
- Comprehensive error handling
- API endpoints for programmatic access
- In-memory URL storage with 30-day expiration

 Technical Stack

- PHP 8.3
- Laravel 11
- Tailwind CSS
- Alpine.js
- Laravel Cache for storage
- RESTful API architecture

 Installation

1. Clone the repository:
bash
git clone https://github.com/funganayimutamiri/atarim-url-shortener.git
cd atarim-url-shortener


2. Install PHP dependencies:
bash
composer install


3. Set up environment:
bash
cp .env.example .env
php artisan key:generate


4. Install and compile frontend assets:
bash
npm install
npm run dev


 Running the Application

1. Start the Laravel development server:
bash
php artisan serve


2. In a separate terminal, run Vite for asset compilation:
bash
npm run dev


The application will be available at `http://localhost:8000`

 API Documentation

 Encode URL
- Endpoint: `POST /api/encode`
- Request Body:
json
{
    "url": "https://www.fungi.com"
}

- Success Response (201):
json
{
    "short_url": "http://127.0.0.1:8000/s0UI6m",
    "original_url": "https://www.fungi.com"
}


 Decode URL
- Endpoint: `POST /api/decode`
- Request Body:
json
{
    "short_url": "http://127.0.0.1:8000/s0UI6m"
}

- Success Response (200):
json
{
    "original_url": "https://www.fungi.com"
}


 Testing

Run the test suite:
bash
php artisan test


 Code Quality & Standards

The project follows Laravel best practices and PSR standards, demonstrating:
- Clean, maintainable code structure
- Comprehensive error handling
- Input validation
- Proper use of Laravel's service container and dependency injection
- RESTful API design principles
- Frontend/Backend separation of concerns

 Technical Decisions

1. Cache Storage: Utilized Laravel's cache system for URL storage, demonstrating efficient memory usage while maintaining quick access times.

2. Frontend Framework Choice: Implemented a lightweight stack with Tailwind CSS and Alpine.js to create a responsive, interactive UI without the overhead of larger frameworks.

3. Error Handling: Comprehensive error handling both in the API and UI layers ensures a robust user experience.

4. API Design: RESTful API implementation allows for easy integration with other services while maintaining clean separation of concerns.

 Future Enhancements

The application is designed to be easily extensible. Potential enhancements could include:
- Database persistence for URLs
- User authentication and URL management
- Click tracking and analytics
- Custom short URL aliases
- QR code generation
- using extended layouts

 Contact Information
Funganayi Mutamiri

Email: mr.mutamiri@gmail.com
LinkedIn: https://www.linkedin.com/in/funganayi-marc-mutamiri-89507816a/
GitHub: https://github.com/funganayimutamiri


Developed as a technical assessment for the Mid-Level Laravel/PHP Developer position at Atarim.