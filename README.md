<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Discover Pavilion: Your go-to hub for vibrant conversations and engaging community interactions. Connect with others by following their journeys and enjoying a stream of thought-provoking blog posts. Express yourself by customizing your avatar and dive into profiles to find like-minded individuals worth following. Whether you're here to make lasting connections or simply to join the lively global chat, Pavilion is your space to shine among peers who are online and ready to chat. Step into Pavilion, where every voice is heard, and every post can inspire.

## Features
> User Profiles: Customize your personal avatar and profile.
> Community Interactions: Follow user journeys and join discussions.
Blog Platform: Share and discover thought-provoking content.
Real-Time Chat: Connect with peers through the live chat feature.

Technical Stack
Framework: Laravel
PHP Version: 8.2.15
Database: MySQL 8.3.0
Frontend: Node.js 19.2.0

```
git clone https://github.com/rkponn/laravel-projects/mainapp.git pavilion
cd pavilion
composer install
npm install
```

Environment Setup
Environment File: Set up your .env file using the sample provided in the repository.
Database Configuration: Configure your MySQL database.
Pusher Setup: For real-time chat, create a Pusher account and set up the necessary credentials in your .env file.

```
php artisan key:generate
php artisan migrate
npm run dev
php artisan serve
```


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
