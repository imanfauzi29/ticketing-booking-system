<?php

namespace App\Ticket;


class User
{
    public $username, $password, $session;

    function login()
    {
        echo "\n=============== Login ===============\n";
        echo "Username: ";
        $user = trim(fgets(STDIN));
        echo "Password: ";
        $pass = trim(fgets(STDIN));

        $this->_validate($user, $pass);
    }

    private function _validate($user, $pass)
    {
        $data = $this->get_user();

        if ($user == $data[0]->username && $pass == $data[0]->password) {
            // $this->username = $data->username;
            // $this->session = true;
            echo "Selamat datang " . $data[0]->username;
            if ($data[0]->role == 1) {
                // redirect admin
            }else {
                // redirect customer
            }
        } else {
            echo "gagal";
        }
    }

    private function get_user()
    {
        $get = file_get_contents(__DIR__ . "/data_person.json");
        return json_decode($get);
    }
}
