<?php

require_once("App/init.php");

// use App\Ticket\Process as Ps;
use App\Ticket\User;



// echo "\n=============== Login ===============\n";
// echo "Username: ";
// $user = trim(fgets(STDIN));
// echo "Password: ";
// $password = trim(fgets(STDIN));


$user = new User();

$user->login();
