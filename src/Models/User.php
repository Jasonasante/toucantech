<?php

namespace MVC\Models;

class User {
    public $name;
    public $email;
    public $school;

    public function __construct($name, $email, $school) {
        $this->name = $name;
        $this->email = $email;
        $this->school = $school;
    }
}
    