<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\User;

class FormController extends Controller {
    public function processForm() {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $school = $_POST['school'];

        $user = new User($name, $email, $school);
    }
}
    