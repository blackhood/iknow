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

    public function test_check_name_email_existed(){

        $db = new DB_manager();

        $var = array(
            "name" => "qqq",
            "email" => "d@163.com",
        );

        $var2 = array(
            "name" => "qqq1",
            "email" => "david@163.com",
        );

        $var3 = array(
            "name" => "qqq",
            "email" => "david@163.com",
        );

        $var4 = array(
            "name" => "qqq1",
            "email" => "d@163.com",
        );

        $this->assertEquals(1 ,$db->check_name_email_existed($var));
        $this->assertEquals(1 ,$db->check_name_email_existed($var2));
        $this->assertEquals(1 ,$db->check_name_email_existed($var3));
        $this->assertEquals(0 ,$db->check_name_email_existed($var4));


    }

    public function test_get_videos_of_user () {

        $db = new DB_manager();

        $var = array(
            "name" => "qqq",
        );

        $var2 = array(
            "name" => "aaa",
        );

        $res1 = $db->get_videos_of_user($var);
        $res2 = $db->get_videos_of_user($var2);

        $this->assertEquals(4 ,sizeof($res1));
        $this->assertEquals(0 ,sizeof($res2));
    }

    public function test_get_extension () {
        $db = new DB_manager();

        $file1 = "hello.c";
        $file2 = "hello.py";
        $file3 = "hello.cpp";
        $file4 = "hello.java";
        $file5 = "hello.php";
        $file6 = "hello.html";
        $file7 = "hello.mp4";

        $this->assertEquals("c" , $db->getExtension($file1));
        $this->assertEquals("py" , $db->getExtension($file2));
        $this->assertEquals("cpp" , $db->getExtension($file3));
        $this->assertEquals("java" , $db->getExtension($file4));
        $this->assertEquals("php" , $db->getExtension($file5));
        $this->assertEquals("html" , $db->getExtension($file6));
        $this->assertEquals("mp4" , $db->getExtension($file7));

    }
}
 