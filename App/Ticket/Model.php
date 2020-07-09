<?php
namespace App\Ticket;

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

    protected function addData($data){
        
    }



    
}

