# Content Scheduler

A Laravel-based platform for scheduling, publishing, and analyzing posts across multiple social media platforms. Designed for efficiency, scalability, and extensibility, this project demonstrates clean code, robust validation, and thoughtful feature implementation.

---

## Features

- **Multi-Platform Scheduling:** Schedule posts for platforms like Twitter, Facebook, and more.
- **Post Analytics:**  
  - View posts per platform  
  - Publishing success rate  
  - Scheduled vs. published counts
- **Rate Limiting:** Restricts users to a maximum of 10 scheduled posts per day.
- **Activity Logging:** Showing user actions using Spatie activity log.
- **Extensible Validation:** Platform-specific post validation (e.g., Twitter’s 280-character limit).
- **Custom Feature:** *Notifications*

---

## Requirements

- **PHP:** Version 8.1 or higher  
- **Composer:** For dependency management  
- **Database:** MySQL, PostgreSQL, SQLite  
- **Node.js & npm:** For frontend asset management  
- **Web Server:** Apache, Nginx, or PHP’s built-in server  

## Installation

1. **Clone the repository:**
```bash 
    git clone https://github.com/salah3id/content-scheduler.git
```
```bash 
    cd content-scheduler 
```

2. **Install dependencies:**
```bash 
   composer install 
```
```bash 
   npm install
```
```bash 
   npm run dev 
```
3. **Set up environment:**
```bash 
   cp .env.example .env 
   php artisan key:generate 
```
4. **Configure your database in `.env` file**
5. **Run migrations and seeders:**
```bash 
   php artisan migrate --seed
```
6. **Start the development server:**
```bash 
   php artisan serve
```

---

## ✅ Approach & Trade-offs

### Design Patterns Implemented

- **DTO (Data Transfer Object):**  
  Handles data transformation and structure between layers.

- **Repository Pattern:**  
  Abstracts and decouples data access from business logic.

- **Strategy Pattern:**  
  Manages platform-specific content publishing logic.

### Validation & Security

- Utilizes Laravel’s built-in validation and middleware to ensure:  
  - Security  
  - Maintainability  
  - Clean and manageable request lifecycle

- Applies **modular validation** per platform to maintain clear, isolated rules.

### Additional Highlights

- **Spatie Query Builder:**  
  Integrated in the base repository for flexible, reusable filtering across models.

- **PHP 8.1 Enums:**  
  Represent supported platforms and post statuses, ensuring strict typing and cleaner code.

- Focused on **extensibility** to allow easy addition of new platforms with minimal effort.

---

## Running Tests

To run the test suite, use the following Artisan command:

```bash
php artisan test
```


## API Documentation

You can explore and test the API endpoints using Postman.  
Access the Postman documentation here:  
[Postman API Docs](https://www.postman.com/salah3id/workspace/practicing/collection/27536537-7a278c77-0916-41b7-af52-d6eece178949?action=share&creator=27536537&active-environment=27536537-3146d30f-ddee-4e78-9cf1-36709ac939f7) 

## Demo Video

Watch the demo video showcasing the main features and workflow of the Content Scheduler:

[![Demo Video](https://img.youtube.com/vi/iNRLouPbfsw/0.jpg)](#)