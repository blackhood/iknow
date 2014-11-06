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
            'create_data' => '2014-11-5'
        );

        $result = $user -> set_attributes($attributes);

        $this->assertEquals(true, $result);
        $this->assertEquals("simon", $user->getName());
        $this->assertEquals("simon@email.com", $user->getEmail());
    }
}
 