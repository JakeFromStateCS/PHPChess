<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require '/var/www/html/vendor/autoload.php';

// Load the environment variables
$dotENV = new Dotenv();
$dotENV->load(__DIR__ . '/.env');


// Initialize the database
