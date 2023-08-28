<?php

require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/TravelApp/Core/helpers.php';
require_once __DIR__ . '/TravelApp/Core/error_handler.php';
require __DIR__ . '/TravelApp/TravelApp.php';


$app = new TravelApp\TravelApp();
$app->run();

?>
