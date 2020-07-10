<?php

namespace App\Ticket;
// model for test class sebelum dipisah-pisah
class Model{

    protected function getDataFlight(){
        $path = '../../data/flight.json';
        $data = self::getData($path);
        return $data;
    }

    protected function getData($path){
        $file = fopen($path, 'r');
        $json = fread($file, filesize($path));
        $data = json_decode($json, true);
        return $data;
    }

    protected function getDataAirport(){
        $path = '../../data/airport.json';
        $data = self::getData($path);
        return $data;
    }

    protected function getDataSchedule(){
        $path = '../../data/schedule.json';
        $data = self::getData($path);
        return $data;
    }

    protected function writeDataFlight($new_data){
        $path = '../../data/flight.json';

        file_put_contents($path, $new_data);
    }
    
}

// interface customer sebelum dipisah-pisah
interface Customer{

    public function searchAllSchedule();
    public function booking();
}


// interface admin sebelum disatukan digunakan untuk percobaan
interface Admin{

    public function addMaskapai();
    public function showMaskapai();
    public function updateMaskapai();
    public function delMaskapai();

    public function addAirport();
    public function showAirport();
    public function updateAirport();
    public function delAirport();

    public function addSchedule();
    public function showSchedule();
    public function updateSchedule();
    public function delSchedule();

}



class UserAction extends Model implements Customer, Admin{
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

    function searchAllSchedule(){
        if (True){
            print_r($this->data_schedule);
        } else{
            echo "Anda belum login!";
        }
        
    }

    function booking(){
        
    }


    function addMaskapai(){
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
            $this->writeDataFlight($this->data_flight);
            // $this->writeDataFlight($new_data);
            // return $this->data_flight;
            

        }
    

    }

    function showMaskapai(){

        if (TRUE){ // validate user
            
            echo "Flight Code|\t Flight Name|";
            for ($i = 0; $i < count($this->data_flight); $i++){
                if ($this->data_flight[$i]){
                    echo $this->data_flight[$i]["flight_code"] . "|\t " . $this->data_flight[$i]["flight_name"]. "\n";
    
                 }
            }
        }

    }

    function updateMaskapai(){
        echo "Masukkan id yang ingin diupdate :";

    }
    function delMaskapai(){
        if (True){//user validate will implement tomorrow
            echo "Masukkan flight code : ";
            $flight_code = trim(fgets(STDIN));
            $index = 0;
            for ($i = 0; $i < count($this->data_flight); $i++){
                if ($this->data_flight[$i]["flight_code"] == $flight_code){
                    $index = $i;
                }
            }
            unset($this->data_flight[$index]);

            return $this->data_flight;
        }
    }

    function addAirport(){

    }
    function showAirport(){

    }
    function updateAirport(){

    }
    function delAirport(){

    }

    function addSchedule(){

        for ($i = 0; $i < count($this->data_schedule); $i++){
            if ($this->data_schedule[$i]){
                
            }
        }

    }
    function showSchedule(){

    }
    function updateSchedule(){

    }
    function delSchedule(){

    }

}


$test = new UserAction();
// $test->addAirport();
// $test->searchAllSchedule();
$test->addMaskapai();
// $test->showMaskapai();
// $test->delMaskapai();