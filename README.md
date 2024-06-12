# News Articles Project
This project is an assignment provided by Mobcast Innovations as part of selection process.The main goal is to display news articles fetched from an API for better understanding of MVC arcitecture. It includes features like sorting, searching and pagination through the articles. The project is built using Laravel.

## Table of Contents
1. [Installation](#installation)
2. [Usage](#usage)
3. [Packages Used](#packages-used)

## Installation

### Prerequisites
Before you begin, ensure you have met the following requirements:

- Installed PHP 7.3 or higher.
- Installed Composer.
- Installed Git.

Setup
1. Clone the repository:
    git clone https://github.com/your-username/news-articles.git
    cd news-articles

2. Install PHP dependencies:
    composer install

3. Create a copy of your .env file:
    cp .env.example .env

4. Set up your environment variables:
    Open the .env file and configure your api and other settings.
    NEWS_API_URL=your_api_url

5. Start the development server:
    php artisan serve

Your application should now be running on http://localhost:8000.

## Usage:
- Visit the home page to view the list of news articles.
- Use the search bar to filter articles by title or description.
- Use the sort dropdown to sort articles.

## Packages Used:
- PHP Packages:
    laravel/framework: 8.x

- JavaScript Packages
    bootstrap: 4.5.x (Frontend framework)

