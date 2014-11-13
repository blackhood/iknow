<?php

class test_user extends PHPUnit_Framework_TestCase {
    public function test_sign_up()
    {
        $var = array(
            'name' => 'qqq',
            'password' => 'qqq',
            'confirm_p' => 'qqq',
            'email' => 'qqq@gmail.com'

        );
        $result = Server::sign_up($var);
        $this->assertEquals(-2, $result);
    }

    public function test_sign_in()
    {
        $var = array(
            'name' => 'invalid_user',
            'password' => 'invalid_password'
        );

        $result = Server::sign_in($var);
        $this->assertEquals(false, $result);
    }

    public function test_password_encrypt()
    {
        $password = 'qqq';

        $result = Server::password_encrypt($password);
        //hash result and original string should be different
        $this->assertNotEquals($password, $result);
    }

    public function test_generate_salt()
    {
        $salt_length = 22;
        $result = Server::generate_salt($salt_length);
        //hash result and original string should be different
        $this->assertEquals(22, strlen($result));
    }

    public function test_password_check()
    {
        $salt_length = 22;
        $result = Server::password_check("qqq", "$2y$10$YjNlZWRkNDU5NjFkNTJiYOJCqN70R1EjGoiNTHAWa7sO2dAkGzcPO");
        //hash result and original string should be different
        $this->assertNotEquals(true, $result);
    }


}
