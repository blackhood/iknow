<?php
/**
 * Created by PhpStorm.
 * User: simoncai
 * Date: 11/5/14
 * Time: 1:43 PM
 */
include '../controllers/db_manager.php';

class test_db_manager extends PHPUnit_Framework_TestCase {

    public function test_constructor()
    {
        $db = new DB_manager();
        $this->assertEquals("if anything goes wrong, it should not go to this line", "if anything goes wrong, it should not go to this line");
    }

    public function test_get_a_user()
    {
        $db = new DB_manager();
        $var = array(
            "name" => "ruki",
        );

        $user = $db->get_a_user($var);
        $this->assertEquals("2014-09-01" ,$user->getCreateDate());
        $this->assertEquals( "ruki",$user->getName());
        $this->assertEquals("ruki@163.com",$user->getEmail());
        $this->assertEquals("ruki1", $user->getPassword());
    }

    public function test_create_a_user()
    {
        $db = new DB_manager();

        $var = array(
            "name" => "david",
            "email" => "david@163.com",
            "password" => "david1"
        );

        $db->create_a_user($var);
        $this->assertEquals("please check database to see if david has been inserted","please check database to see if david has been inserted");
    }
}
 