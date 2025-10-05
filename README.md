# Illustrasia - Illustration Marketplace

Illustrasia is a web-based platform built with Laravel that serves as a marketplace for artists and art enthusiasts to sell and purchase illustrations. The application features a robust backend API, dual user roles, and secure authentication, including social login with Google.

## ✨ Key Features

-   **Dual User Roles**: Users can register and operate as either a **Buyer** or a **Seller**, each with a tailored experience.
-   **Secure Authentication**: Standard email/password registration and login, with an added option for seamless authentication via Google Account (Socialite).
-   **Marketplace System**: Sellers can upload and manage their illustration listings, while buyers can browse, search, and purchase artwork.
-   **API-Driven Backend**: Built on a powerful RESTful API, allowing for flexible integration with various front-end clients.
-   **Protected Routes**: Utilizes Laravel's middleware to protect routes and ensure that only authenticated and authorized users can access specific features.
-   **Admin Dashboard**: A dedicated interface for administrators to manage users, artwork listings, and overall site settings.

## 🛠️ Tech Stack

-   **Backend Framework**: Laravel
-   **API**: RESTful API
-   **Authentication**: Laravel Sanctum / Fortify, Laravel Socialite (for Google Login)
-   **Database**: MySQL (or any Laravel-supported DB)

## 🚀 Getting Started

Follow these instructions to get a copy of the project up and running on your local machine for development and testing purposes.

### **Prerequisites**

-   PHP >= 8.1
-   Composer
-   Node.js & NPM
-   A local database server (e.g., MySQL)

### **Installation**

1.  **Clone the repository:**
    ```sh
    git clone [https://github.com/FerrelNW/laravel-illustrasia.git](https://github.com/FerrelNW/laravel-illustrasia.git)
    cd laravel-illustrasia
    ```

2.  **Install PHP dependencies:**
    ```sh
    composer install
    ```

3.  **Create your environment file:**
    ```sh
    cp .env.example .env
    ```

4.  **Generate an application key:**
    ```sh
    php artisan key:generate
    ```

5.  **Configure your `.env` file:**
    Update the `DB_*` variables with your local database credentials. Also, set up your Google credentials for the social login feature.
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=illustrasia2
    DB_USERNAME=root
    DB_PASSWORD=

    GOOGLE_CLIENT_ID=your_google_client_id
    GOOGLE_CLIENT_SECRET=your_google_client_secret
    GOOGLE_REDIRECT_URI=[http://127.0.0.1:8000/auth/google/callback](http://127.0.0.1:8000/auth/google/callback)
    ```

6.  **Run the database migrations:**
    ```sh
    php artisan migrate
    ```

7.  **Start the development server:**
    ```sh
    php artisan serve
    ```

The application will be running at `http://127.0.0.1:8000`.
