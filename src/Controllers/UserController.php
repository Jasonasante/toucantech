<?php

namespace MVC\Controllers;

use MVC\Controller;
use MVC\Models\User;

class UserController extends Controller {
    public function index() {
        $users = [
            new User('John Doe', 'john@example.com','school1'),
            new User('Jane Doe', 'jane@example.com','school1')
        ];

        $this->render('user/index', ['users' => $users]);
    }
}
    