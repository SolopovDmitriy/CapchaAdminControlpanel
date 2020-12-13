<?php

namespace MyAdmApp {

    use MyApp\DBEngine as Engine;

    class  UserModel extends Engine
    {
        public function __construct()
        {
            parent::__construct('users');
        }

        public function checkUser($email, $password)
        {
            $result = $this->getManyRows([
                'email' => $email,
                'password' => $password
            ], 'id', 'ASC', 1);

            return ($result == null) ? null : $result[0];
        }
    }
}