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
3. Set up .env
   ```
   Copy .env.example to .env
   Fill out the APP_ section
   Fill out the DB_ section
   Fill out the MAIL_ section

   You will need an API key from szunetnapok.hu to be able to use the Fill holidays function
   Add SZUNETNAPOK_API="API_KEY" to the end of file
   ```


[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Tailwindcss.com]: https://img.shields.io/badge/Tailwind_CSS-grey?style=for-the-badge&logo=tailwind-css&logoColor=38B2AC
[Tailwindcss-url]: https://tailwindcss.com/
[MySQL.com]: https://shields.io/badge/MySQL-lightgrey?logo=mysql&style=plastic&logoColor=white&labelColor=blue
[MySQL-url]: https://www.mysql.com/
