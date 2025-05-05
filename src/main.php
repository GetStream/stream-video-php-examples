<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use App\Services\TokenService;

function main() {
    $tokenService = new TokenService();
    // You can add your main application logic here
    echo "Application started!\n";
}

// Run the main function
main(); 