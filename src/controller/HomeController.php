<?php

namespace App\controller;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../view/site/home.php';
    }
}
