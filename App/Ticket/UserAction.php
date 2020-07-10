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
        $json = file_get_contents($path);
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

    protected function pushData($path, $new_data)
    {
        $json = json_encode($new_data, JSON_PRETTY_PRINT);
        file_put_contents($path, $json);

        return true;
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
    public function updateMaskapai($id);
    public function delMaskapai($id);

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
            echo "Masukkan kode maskapai : ";
            $flight_code = strtoupper(trim(fgets(STDIN)));
            echo "Masukkan nama maskapai : ";
            $flight_name = trim(fgets(STDIN));

            $fCode = '';
            foreach ($this->data_flight as $value) {

                if ($flight_code == $value['flight_code']) {

                    echo "Oops, Flight Code sudah ada!\n\n";
                    sleep(1);
                    $res = $this->prompt();

                    if ($res == 'Y') {
                        return $this->addMaskapai();
                    } elseif ($res == 'N') {
                        echo "Anda akan keluar!\n";
                        sleep(1);
                        echo "Good Bye!";
                        sleep(1);
                        system('clear');
                        return;
                    } else {
                        return;
                    }

                    return;
                } else {
                    $fCode = $flight_code;
                }
            }

            $new_data = [
                "flight_code" => $fCode,
                "flight_name" => $flight_name,
                "flight_image" => $this->default_img
            ];

            array_push($this->data_flight, $new_data);
            $this->pushData('../../data/flight.json', $this->data_flight);

            echo "data Added!\n";
            return $this->data_flight;
        }
    }

    function showMaskapai()
    {

        $mask = "|%11s |%-30.30s |\n";

        printf($mask, '-----------', '------------------------------');
        printf($mask, 'Flight Code', 'Flight name');
        printf($mask, '-----------', '------------------------------');
        foreach ($this->data_flight as $flight) {
            printf($mask, $flight['flight_code'], $flight['flight_name']);
        }

        printf($mask, '-----------', '------------------------------');

        $code = $this->getCode("flight");
        switch ($code[1]) {
            case '1':
                $this->addMaskapai();
                break;
            case '2':
                $this->updateMaskapai($code[0]);
                break;
            case '3':
                $this->delMaskapai($code[0]);
                break;
            default:
                echo "please";
                break;
        }
    }

    function updateMaskapai($id)
    {
        echo "\nmasukan name: ";
        $input = strtoupper(trim(fgets(STDIN)));

        $fl = $this->data_flight;

        for ($i = 0; $i < count($fl); $i++) {
            if ($id == $fl[$i]['flight_code']) {
                $fl[$i]['flight_name'] = $input;
                print_r($fl);
            }
        }
        $this->pushData('../../data/airport.json', $fl);
    }

    function delMaskapai($id)
    {
        if (True) { //user validate will implement tomorrow
            $index = 0;
            for ($i = 0; $i < count($this->data_flight); $i++) {
                if ($this->data_flight[$i]["flight_code"] == $id) {
                    $index = $i;
                }
            }
            unset($this->data_flight[$index]);

            if ($this->pushData('../../data/flight.json', $this->data_flight)) {
                echo "data $id deleted!\n";
            } else {
                echo "data failed to delete\n";
            }
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
            printf($mask, $af['flight_code'], $af['flight_name']);
        }
        printf($mask, '-----------', '-----------------------------------------');

        $code = $this->getCode("Airport");

        switch ($code[1]) {
            case '1':
                $this->addAirport();
                break;
            case '2':
                echo "\nedit: ";
                $data = fgets(STDIN);
                $this->updateAirport($code[0], $data);
                break;
            case '3':
                $this->delAirport($code[0]);
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

        $this->pushData($this->airport, $airport);
        echo "update Berhasil!";
    }
    function setDataSchedule()
    {
        echo "Add new schedule flight\n";
        echo "Add flight code(QZ123) :";
        $flight_code = strtoupper(fgets(STDIN));
        echo "Flight name: ";
        $flight_name = fgets(STDIN);
        echo "Flight from(CGK): ";
        $flight_from = fgets(STDIN);
        echo "Flight to(BDG): ";
        $flight_to = fgets(STDIN);
        echo "Flight route[from-to]: ";
        $flight_route = fgets(STDIN);
        echo "Flight transit: ";
        $flight_transit = fgets(STDIN);
        echo "Flight datetime: ";
        $flight_datetime = fgets(STDIN);
        echo "Flight price: ";
        $flight_price = fgets(STDIN);
        echo "FLight publishfare (1-10): ";
        $flight_publishfare = fgets(STDIN);
        echo "Flight baggage: ";
        $flight_baggage = fgets(STDIN);
        echo "Flight facilities: ";
        $flight_facilities = fgets(STDIN);

        $data = [
            "flight" => $flight_name,
            "flight_code" => $flight_code,
            "flight_from" => $flight_from,
            "flight_to" => $flight_to,
            "flight_route" => $flight_route,
            "flight_date" => $flight_date,
            "flight_transit" => $flight_transit,
            "flight_datetime" => $flight_datetime,
            "flight_price" => intval($flight_price),
            "flight_publishfare" => intval($flight_publishfare),
            "flight_baggage" => $flight_baggage,
            "flight_facilities" => intval($flight_facilities)
        ];

        return $data;
    }


    function addSchedule()
    {
        // clear terminal
        system('clear');
        $data = self::setDataSchedule();

        array_push($this->schedule, $data);
        $this->pushData('../../data/schedule.json', $this->schedule);
    }

    function delAirport($id)
    {
        if (True) { //user validate will implement tomorrow

            $index = 0;
            for ($i = 0; $i < count($this->data_airport); $i++) {
                if ($this->data_airport[$i]["flight_code"] == $id) {
                    $index = $i;
                }
            }
            unset($this->data_airport[$index]);

            if ($this->pushData('../../data/airport.json', $this->data_airport)) {
                echo "data $id deleted!\n";
            } else {
                echo "data failed to delete\n";
            }
            // return $this->data_flight;
        }
    }

    function showSchedule()
    {

        $mask = "|%-11s |%-11s |%-13s |%-13s |%-13s |%-13s |%-13s| \n";
        printf($mask, '-----------', '-----------', '-------------', '-------------', '-------------', '-------------', '-------------');
        printf($mask, 'Flight Name', 'Flight code', 'Flight route', 'Flight date', 'Keberangkatan', 'Price', 'Baggage');
        printf($mask, '-----------', '-----------', '-------------', '-------------', '-------------', '-------------', '-------------');

        foreach ($this->data_schedule as $sch) {
            printf($mask, $sch['flight'], $sch['flight_code'], $sch['flight_route'], $sch['flight_date'], $sch['flight_datetime'], $sch["flight_price"], $sch['flight_baggage']);
        }
        printf($mask, '-----------', '-----------', '-------------', '-------------', '-------------', '-------------', '-------------');
    }
    function updateSchedule()
    {
        $data = $this->data_schedule;
        self::showSchedule();
        echo "Masukkan Flight Code yang ingin diubah : ";
        $flight_code = fgets(STDIN);

        $data_found = array_filter($data, function ($v) use ($flight_code) {
            return $v['flight_code'] == $flight_code;
        });

        if (count($data_found) > 0) {

            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]["flight_code"] == $flight_code) { }
            }
        }
    }
    function delSchedule()
    { }

    function getCode($flight)
    {
        echo "\nAction menu: ";
        echo "\n";
        echo "1. Add\n";
        echo "2. Update\n";
        echo "3. Delete\n\n";
        echo "pilih action: ";
        $menu = trim(fgets(STDIN));

        $code = '';
        if ($menu != 1) {
            echo "\nmasukan $flight Code: ";
            $code = strtoupper(trim(fgets(STDIN)));
        }

        $arr = [];
        $arr[] = $code;
        $arr[] = $menu;

        return $arr;
    }

    function prompt()
    {
        echo "Ulangi Lagi (Y/n) ? ";
        $again = strtoupper(trim(fgets(STDIN)));
        return $again;
    }
}


$test = new UserAction();
// $test->addMaskapai();

// $test->addSchedule();
// $test->addMaskapai();
// $test->showMaskapai();
// $test->delMaskapai();
// $test->showSchedule();
// $test->updateSchedule();
$test->showAirport();
