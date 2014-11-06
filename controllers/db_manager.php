<?php

include '../models/user.php';

class DB_manager
{
    private $db;
    private $configuration_file_path = "../php.ini";

    function DB_manager (){
        //parse configuration file
        $ini_array = parse_ini_file($this->configuration_file_path);
        $db_host = $ini_array['db_host'];
        $db_name = $ini_array['db_name'];
        $db_user = $ini_array['db_user'];
        $db_password = $ini_array['db_password'];

        //make a connection
        $mysqli = new mysqli($db_host, $db_user , $db_password, $db_name);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }

        $this->db = $mysqli;
    }

    public function get_a_user ($var) {
        $name = $var['name'];
        $user = new User();

        //use sql prepare to get user information from user table using
        //user's name
        if ( $stmt = $this->db->prepare("SELECT email, password, create_date FROM user WHERE user.name = ?") ){
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->bind_result($email, $password, $create_date);
            $stmt->fetch();

            //set attributes to user
            $user->set_attributes(
                array(
                    "name" => $name,
                    "email" => $email,
                    "password" => $password,
                    "create_date" => $create_date
                )
            );

            $stmt->close();
        } else {
            echo "get_a_user: select statement went wrong";
            return false;
        }
        return $user;
    }

    public function create_a_user ($var) {
        $name = $var['name'];
        $email = $var['email'];
        $password = $var['password'];
        $create_date = date("Y-m-d");

        //insert comments and get comment id
        if ( $stmt = $this->db->prepare("INSERT INTO user (name, email, password, create_date) VALUES (?, ?, ?, ?)") ){
            $stmt->bind_param('ssss', $name, $email, $password, $create_date);
            $stmt->execute();
        } else {
            echo "create_a_user: insert statement went wrong";
        }
        $stmt->close();
    }
}
?>