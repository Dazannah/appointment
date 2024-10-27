<div align="center">
    <h1>Appointment</h1>
    <p>
        <a href="https://appointment.davidfabian.hu/">Demo</a>
        <a href="https://documenter.getpostman.com/view/27659241/2sAXqzWdTk">REST API documentation</a>
    </p>
</div>


### Table of content
<ol>
    <li>
        <a href="#about-the-project">About the project</a>
        <ul>
            <li><a href="#built-with">Built with</a></li>
        </ul>
    </li>
    <li>
        <a href="#getting-started">Getting Started</a>
        <ul>
            <li><a href="#prerequisites">Prerequisites</a></li>
            <li><a href="#installation">Installation</a></li>
        </ul>
    </li>
    <li>
        <a href="#implemented-features">Implemented features</a>
        <ul>
            <li><a href="#user-interface">User</a></li>
            <li><a href="#admin-interface">Admin</a></li>
        </ul>
    </li>
</ol>


## About The Project
<div id="about-the-project">
    This project is a Laravel-Blade based appointment scheduling system designed to streamline booking and schedule management. The app provides an Admin Interface for configuring working hours, managing holidays, adding job categories, handling booking cancellations, and automating booking status updates. The User Interface allows clients to book, edit, or cancel appointments, as well as track their booking history.
</div>


### Built with

<div id="built-with">
    
[![Laravel][Laravel.com]][Laravel-url]</br>
[![Tailwind][Tailwindcss.com]][Tailwindcss-url]</br>
[![MySQL][MySQL.com]][MySQL-url]

</div>

## Getting Started
<div id="getting-started">
    
### Prerequisites
<div id="prerequisites"></div>

<li>Laravel 11 <a href="https://laravel.com/docs/11.x/installation">Installation</a></li>
<li>Database <a href="https://laravel.com/docs/11.x/database#introduction">List</a></li>
<li>Composer <a href="https://getcomposer.org/download/">Installation</a></li>
<li>NPM <a href="https://docs.npmjs.com/downloading-and-installing-node-js-and-npm">Installation</a></li>
<li>PHP version ">= 8.2.0"</li>


### Installation
<div id="installation"></div>

1. Clone the repository
   ```sh
   git clone https://github.com/Dazannah/appointment.git
   ```
2. Install dependencies
   ```sh
   composer install
   npm install
   npm run build
   ```
3. Set up .env</br>
   Copy .env.example to .env</br>

   Fill out the APP_ section</br>
   Fill out the DB_ section</br>
   Fill out the MAIL_ section</br>

   You will need an API key from szunetnapok.hu to be able to use the Fill holidays function</br>
   Add SZUNETNAPOK_API="API_KEY" to the end of file</br>
   
5. Run migration
    ```
    php artisan migrate
    ```
    or to include some dummy data
   ```
    php artisan migrate --seed
   ```
   
## Implemented features
<div id="implemented-features"></div>

### User interface
<div id="user-interface"></div>
<ul>
    <li>Book appointments (can only see time slots as "booked" if not their own)</li>
    <ul>
        <li>Book the earliest available appointment for specific job types, on one click</li>
        <li>Select a start time, and the system show the options that fit until the next appointment, or day close</li>
        <li>Add notes to the appointment</li>
    </ul>
    <li>Edit own appointments</li>
    <li>View booking history</li>
</ul>

### Admin interface
<div id="user-interface"></div>
<ul>
    <li>Edit or ban users</li>
    <li>Set working hours, default: 8:00-16:00</li>
    <li>Set vacations: full day</li>
    <li>Public holidays, default: closed</li>
    <li>Edit appointments</li>
    <li>Add notes to appointments (visible only to admin)</li>
    <li>Add notes to appointments (visible to clients)</li>
    <li>Add and edit work categories, set durations</li>
    <li>Automatically mark booked appointments as successful after the time slot ends; can be manually changed to unsuccessful</li>
</ul>

[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Tailwindcss.com]: https://img.shields.io/badge/Tailwind_CSS-grey?style=for-the-badge&logo=tailwind-css&logoColor=38B2AC
[Tailwindcss-url]: https://tailwindcss.com/
[MySQL.com]: https://shields.io/badge/MySQL-lightgrey?logo=mysql&style=plastic&logoColor=white&labelColor=blue
[MySQL-url]: https://www.mysql.com/
