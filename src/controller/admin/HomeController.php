<?php

namespace controllerdmin;

class HomeController
{
    public function index()
    {
        require __DIR__ . '/../../view/admin/home.php';
    }
}
