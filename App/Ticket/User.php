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
        $datas = $this->get_user();

        foreach ($datas as $data) {

            if ($user == $data->username && $pass == $data->password) {
                // $this->username = $data->username;
                // $this->session = true;

            }
        }
    }

    private function get_user()
    {
        $get = file_get_contents(__DIR__ . "/data_person.json");
        return json_decode($get);
    }
}
