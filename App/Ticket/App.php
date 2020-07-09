<?php

// ini parent
namespace App\Ticket;

abstract class User
{

    protected $username, $password;
    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
}
