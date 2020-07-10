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

    protected function pushData($path ,$new_data){
        $json = json_encode($new_data, JSON_PRETTY_PRINT);
        file_put_contents($path, $json);
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

    function __construct(){
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
            $flight_code = trim(fgets(STDIN));
            echo "Masukkan nama maskapai : ";
            $flight_name = trim(fgets(STDIN));

            $new_data = [
                "flight_code" => $flight_code,
                "flight_name" => $flight_name,
                "flight_image" => $this->default_img
            ];

            array_push($this->data_flight, $new_data);
            print_r($new_data);
            $this->pushData('../../data/flight.json', $this->data_flight);

            // return $this->data_flight;

        }
    }

    function showMaskapai()
    {

        if (TRUE) { // validate user

            for ($i = 0; $i < count($this->data_flight); $i++) {
                if ($this->data_flight[$i]) {
                    echo $this->data_flight[$i]["flight_code"] . "|\t " . $this->data_flight[$i]["flight_name"] . "\n";
                }
            }

        }
    }

    function updateMaskapai(){

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
    }

    function setDataSchedule(){
        echo "Add new schedule flight: ";
        echo "Add flight code :";
        $flight_code = fget(STDIN);
        echo "\Flight name: "; 
        $flight_name = fgets(STDIN);
        echo "\nFlight from: ";
        $flight_from = fgets(STDIN);
        echo "Flight to: ";
        $flight_to = fget(STDIN);
        echo "Flight route: [from-to]";
        $flight_route = fget(STDIN);
        echo "Flight transit: ";
        $flight_transit = fget(STDIN);
        echo "Flight datetime: ";
        $flight_datetime = fget(STDIN);
        echo "Flight price: ";
        $flight_price = fget(STDIN);
        echo "FLight publishfare ( 1 - 10 )";
        $flight_publishfare = int(fget(STDIN));
        echo "Flight baggage: ";
        $flight_baggage = fget(STDIN);
        echo "Flight facilities: ";
        $flight_facilities = fget(STDIN);

        $data = [
                "flight" => $flight_name,
                "flight_code" => $flight_code,
                "flight_from" => $flight_from,
                "flight_to" => $flight_to,
                "flight_route" => $flight_route,
                "flight_date" => $flight_date,
                "flight_transit" => $flight_transit,
                "flight_datetime" => $flight_datetime,
                "flight_price" => $flight_price,
                "flight_publishfare" => $flight_publishfare,
                "flight_baggage" => $flight_baggage,
                "flight_facilities" => $flight_facilities
        ];

        return $data;
    }


    function addSchedule(){
        // clear terminal
        system('cls');
        $data = self::setDataSchedule();

        array_push($this->schedule, $data);
        $this->pushData($this->schedule);

    }

    function delAirport($id){

    }

    function showSchedule()
    {

        $mask = "|%-11s |%-11s |%-13s |%-13s |%-13s |%-13s |%-13s \n";
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
        $flight_code = fget(STDIN);

        $data_found = array_filter($data, function($v) use($flight_code){return $v['flight_code'] == $flight_code;});

        if (count($data_found) > 0){
            
            for ($i = 0; $i < count($data); $i++){
                if ($data[$i]["flight_code"] == $flight_code){
                    
                }
            }
        }


    }
    function delSchedule()
    { 
        

    }
    
}

$test = new UserAction();
// $test->addMaskapai();

// $test->addSchedule();
// $test->addMaskapai();
// $test->showMaskapai();
// $test->delMaskapai();
// $test->showSchedule();
$test->updateSchedule();
