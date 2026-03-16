<?php

namespace model;

class Contato extends GenericModel
{
    private $telefone;
    private $email;

    public function __construct($telefone, $email)
    {
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }
}