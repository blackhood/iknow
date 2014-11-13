<?php
/**
 * Created by PhpStorm.
 * User: simoncai
 * Date: 11/5/14
 * Time: 9:24 PM
 */

class test_user extends PHPUnit_Framework_TestCase {
    public function test_set_attributes()
    {
        $user = new User();

        $attributes = array(
            'name' => 'simon',
            'email' => 'simon@email.com',
            'password' => '123456',
            'create_date' => '2014-11-5'
        );

        $result = $user -> set_attributes($attributes);

        $this->assertEquals(true, $result);
        $this->assertEquals("simon", $user->getName());
        $this->assertEquals("simon@email.com", $user->getEmail());
    }

    public function test_set_get_name()
    {
        $user = new User();

        $user -> setName("David");
        $result = $user -> getName();

        $this->assertEquals("David", $result);
    }

    public function test_set_get_date()
    {
        $user = new User();

        $user -> setCreateDate("2014-9-22");
        $result = $user -> getCreateDate();

        $this->assertEquals("2014-9-22", $result);
    }

    public function test_set_get_email()
    {
        $user = new User();

        $user -> setEmail("david@gmail.com");
        $result = $user -> getEmail();

        $this->assertEquals("david@gmail.com", $result);
    }
}
 