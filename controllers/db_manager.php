<?php
include '../models/user.php';

/**
 * Class DB_manager
 */
class DB_manager
{
    /**
     * @var mysqli is a database connection of this manager
     */
    private $db;
    /**
     * @var string path to the configuration file
     */
    private $configuration_file_path = "../php.ini";

    /**
     * constructor of db_manager which will make a connection to the database automatically
     */
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

    /**
     * runs query to get a user from user table in database
     * @param $var array {"name" => "user_name"}
     * @return bool|User
     */
    public function get_a_user ($var) {
        $name = $var['name'];
        $user = array();

        //use sql prepare to get user information from user table using
        //user's name
        if ( $stmt = $this->db->prepare("SELECT password FROM user WHERE user.name = ?") ){
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->bind_result($password);
            $stmt->fetch();

            if ($password == NULL) {
                $stmt->close();
                return NULL;
            } else {
                $user['password'] = $password;
                $stmt->close();
                return $user;
            }
        } else {
            echo "get_a_user: select statement went wrong";
            return false;
        }
    }

    /**
     * stores a new user into database user table
     * @param $var array {"name" => "?", "email" => "?", "password" => "?"}
     */
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

    public function check_name_email_existed ($var) {
        $name = $var['name'];
        $email = $var['email'];

        if ( $stmt = $this->db->prepare("SELECT name FROM user WHERE name = ? OR email = ?") ){
            $stmt->bind_param('ss', $name, $email);
            $stmt->execute();
            $stmt->bind_result($n);
            $stmt->fetch();

            echo $n;
            if ($n != NULL) {
                return 1;
            }

        } else {
            echo "check_name_email_existed: query statement went wrong";
        }
        $stmt->close();

        return 0;
    }
}
?>