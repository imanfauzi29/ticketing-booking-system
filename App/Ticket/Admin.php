<?php

namespace App\Ticket\Admin;

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