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
        $path = '../../data/flight.json';
        $data = self::getData($path);
        return $data;
    }

    protected function getDataSchedule(){
        $path = '../../data/schedule.json';
        $data = self::getData($path);
        return $data;
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
    public function updateMaskapai($id);
    public function delMaskapai($id);

    public function addAirport();
    public function showAirport();
    public function updateAirport($id);
    public function delAirport($id);

    public function addSchedule();
    public function showSchedule();
    public function updateSchedule($id);
    public function delSchedule($id);

}



class UserAction extends Model implements Customer, Admin{
    protected $data_schedule;
    protected $data_flight;
    protected $data_airport;

    function __construct(){
        $this->data_schedule = $this->getDataSchedule();
        $this->data_airport = $this->getDataAirport();
        $this->data_flight = $this->getDataFlight();
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
        echo "Masukkan data maskapai penerbangan...";
        

    }

    function showMaskapai(){

    }
    function updateMaskapai($id){

    }
    function delMaskapai($id){

    }

    function addAirport(){

    }
    function showAirport(){

    }
    function updateAirport($id){

    }
    function delAirport($id){

    }

    function addSchedule(){

    }
    function showSchedule(){

    }
    function updateSchedule($id){

    }
    function delSchedule($id){

    }

}


$test = new UserAction();
$test->searchAllSchedule();