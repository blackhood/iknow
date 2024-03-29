<?php
require_once 'db_manager.php';

define ('DIFF_PASS', -1);
define ('NAME_EMAIL_EXISTED', -2);

/**
 * Class Server
 */
class Server
{
    /**
     * sign up action from user
     * @param $var name, password and confirm password that user entered
     * @return int
     */
    public static function sign_up ($var) {

        $db = new DB_manager();
        $name = $var['name'];
        $password = $var['password'];
        $confirm_p = $var['confirm_p'];

        $email = $var['email'];

        //first compare password and confirm password are the same
        if (strcmp($password, $confirm_p) != 0) {
            return -1;
        }

        $name_email = array(
            "name" => $name,
            "email" => $email,
        );
        //check name and email if they already existed
        if ($db->check_name_email_existed ($name_email)) {
            return -2;
        };

        //hash passwords here
        $hash_p = Server::password_encrypt($password);

        //create a new user
        $user = array(
            "name" => $name,
            "password" => $hash_p,
            "email" => $email
        );

        $db->create_a_user($user);

        return 1;
    }

    /**
     * sign in check when user sign in
     * @param $var name and password of this user to sign in
     * @return bool|User
     */
    public static function sign_in ($var) {

        $db = new DB_manager();

        $name = $var['name'];
        $password = $var['password'];

        $var_name = array(
            "name" => $name
        );

        $user = $db->get_a_user($var_name);
        if ($user) {
            // found admin, now check password
            if (Server::password_check($password, $user["password"])) {
                // password matches
                return $user;
            } else {
                // password does not match
                return false;
            }
        } else {
            // admin not found
            return false;
        }
    }

    /**
     * main function to encrypt password
     * @param $password string the password that needs to be encrypted
     * @return string
     */
    public static function  password_encrypt($password) {
        $hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
        $salt_length = 22;                                   // Blowfish salts should be 22-characters or more
        $salt = Server::generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password, $format_and_salt);
        return $hash;
    }

    /**
     * generate salting password
     * @param $length int the length that you want the salting method to do
     * @return string
     */
    public static function generate_salt($length) {
        // Not 100% unique, not 100% random, but good enough for a salt
        // MD5 returns 32 characters
        $unique_random_string = md5(uniqid(mt_rand(), true));
        // Valid characters for a salt are [a-zA-Z0-9./]
        $base64_string = base64_encode($unique_random_string);
        // But not '+' which is valid in base64 encoding
        $modified_base64_string = str_replace('+', '.', $base64_string);
        // Truncate string to the correct length
        $salt = substr($modified_base64_string, 0, $length);

        return $salt;
    }

    /**
     * check if user entered correct password
     * @param $password string the password before hash
     * @param $existing_hash string the password from database which is hashed already
     * @return bool
     */
    public static function password_check($password, $existing_hash) {
        // existing hash contains format and salt at start
        $hash = crypt($password, $existing_hash);
        if ($hash === $existing_hash) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * upload a video from user
     * @param $user_name string name of this user
     * @param $video video object which is uploaded by user
     * @return bool
     */
    public static function upload_video($user_name, $video){
        $db = new DB_manager();
        $result = $db -> upload_video($user_name, $video);
        return $result;
    }
}

?>