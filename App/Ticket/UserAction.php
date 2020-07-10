<?php

namespace App\Ticket;
// model for test class sebelum dipisah-pisah
class Model
{

    protected function getDataFlight()
    {
        $path = '../../data/flight.json';
        $data = self::getData($path);
        return $data;
    }

    protected function getData($path)
    {
        $file = fopen($path, 'r');
        $json = fread($file, filesize($path));
        $data = json_decode($json, true);
        return $data;
    }

    protected function getDataAirport()
    {
        $path = '../../data/airport.json';
        $data = self::getData($path);
        return $data;
    }

    protected function getDataSchedule()
    {
        $path = '../../data/schedule.json';
        $data = self::getData($path);
        return $data;
    }

    protected function writeDataFlight($data, $new_data)
    {
        $new_data = json_encode($new_data);

        $path = '../../data/flight.json';
        $file = fopen($path, 'w');
        fwrite($file, $new_data);
    }
}

// interface customer sebelum dipisah-pisah
interface Customer
{

    public function searchAllSchedule();
    public function booking();
}


// interface admin sebelum disatukan digunakan untuk percobaan
interface Admin
{

    public function addMaskapai();
    public function showMaskapai();
    public function updateMaskapai();
    public function delMaskapai();

    public function addAirport();
    public function showAirport();
    public function updateAirport($id, $data);
    public function delAirport($id);

    public function addSchedule();
    public function showSchedule();
    public function updateSchedule();
    public function delSchedule();
}



class UserAction extends Model implements Customer, Admin
{
    protected $data_schedule;
    protected $data_flight;
    protected $data_airport;
    protected $default_img;

    function __construct()
    {
        $this->data_schedule = $this->getDataSchedule();
        $this->data_airport = $this->getDataAirport();
        $this->data_flight = $this->getDataFlight();
        $this->default_img = 'https://da8hvrloj7e7d.cloudfront.net/imageResource/2015/12/17/1450350710653-f522e35b03adb20da95195584a72713d.png';
    }

    function searchAllSchedule()
    {
        if (True) {
            print_r($this->data_schedule);
        } else {
            echo "Anda belum login!";
        }
    }

    function booking()
    { }


    function addMaskapai()
    {
        $new_data = [];
        if (True) { //using for validate user session
            echo "===Masukkan data maskapai===\n";
            echo "Masukkan kode maskapai : \n";
            $flight_code = trim(fgets(STDIN));
            echo "Masukkan nama maskapai : \n";
            $flight_name = trim(fgets(STDIN));

            $new_data = [
                "flight_code" => $flight_code,
                "flight_name" => $flight_name,
                "flight_image" => $this->default_img
            ];

            array_push($this->data_flight, $new_data);
            // $this->writeDataFlight($new_data);
            return $this->data_flight;
        }
    }

    function showMaskapai()
    {

        if (TRUE) { // validate user

            echo "Flight Code|\t Flight Name|";
            for ($i = 0; $i < count($this->data_flight); $i++) {
                if ($this->data_flight[$i]) {
                    echo $this->data_flight[$i]["flight_code"] . "|\t " . $this->data_flight[$i]["flight_name"] . "\n";
                }
            }
        }
    }
    function updateMaskapai()
    {
        echo "Masukkan id yang ingin diupdate :";
    }
    function delMaskapai()
    {
        if (True) { //user validate will implement tomorrow
            echo "Masukkan flight code : ";
            $flight_code = trim(fgets(STDIN));
            $index = 0;
            for ($i = 0; $i < count($this->data_flight); $i++) {
                if ($this->data_flight[$i]["flight_code"] == $flight_code) {
                    $index = $i;
                }
            }
            unset($this->data_flight[$index]);

            return $this->data_flight;
        }
    }

    function addAirport()
    {
        // clear terminal
        system('cls');

        echo "Add data airport: ";
        echo "\nName: ";
        // $code = 
        $name = fgets(STDIN);
        echo "\nCity Name: ";
        $city = fgets(STDIN);
        $location = rand(10000, 99999);
        $getLongLat = $this->getLongLat($city);

        $data = [
            "code" => "SYR",
            "country_code" => "US",
            "name" => $name,
            "city_name" => $city,
            "state" => "NY",
            "display_name" => "$city, $state - $name ($code)", //"Syracuse, NY - Hancock International Airport (SYR)",
            "display_title" => "$city, $state", //"Syracuse, NY",
            "display_sub_title" => "$name ($code)", //"Hancock International Airport (SYR)",
            "location_id" => $location,
            "time_zone_name" => "America/New_York",
            "latitude" => $getLongLat[0],
            "longitude" => $getLongLat[1]
        ];
    }

    function showAirport()
    {
        $airport = $this->data_airport;

        $mask = "|%11s |%-30.30s |\n";
        printf($mask, '-----------', '-----------------------------------------');
        printf($mask, 'Airport Code', 'Airport Name');
        printf($mask, '-----------', '-----------------------------------------');

        foreach ($airport as $af) {
            printf($mask, $af['code'], $af['name']);
        }
        printf($mask, '-----------', '-----------------------------------------');

        echo "\nmasukan Flight Code: ";
        $code = strtoupper(trim(fgets(STDIN)));
        echo "\nAction menu: ";
        echo "\n";
        echo "1. Add\n";
        echo "2. Update\n";
        echo "3. Delete\n\n";
        echo "pilih action: ";
        $menu = trim(fgets(STDIN));

        switch ($menu) {
            case '1':
                $this->addAirport();
                break;
            case '2':
                echo "\nedit: ";
                $data = fgets(STDIN);
                $this->updateAirport($code, $data);
                break;
            case '3':
                $this->delAirport($code);
                break;
            default:
                echo "please";
                break;
        }
    }
    function updateAirport($id, $data)
    {
        $airport = $this->data_airport;

        foreach ($airport as $af) {
            if ($af['code'] == $id) {
                $af['name'] = $data;
            } else {
                echo "Gagal Update";
            }
        }
        echo "update Berhasil!";
        file_put_contents('../../data/airport.json', $airport);
    }
    function delAirport($id)
    { }

    function addSchedule()
    { }
    function showSchedule()
    { }
    function updateSchedule()
    { }
    function delSchedule()
    { }
}


$test = new UserAction();
// $test->addMaskapai();
// $test->showMaskapai();
// $test->delMaskapai();
$test->showAirport();
