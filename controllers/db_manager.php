<?php
include '../models/user.php';
include '../models/video.php';

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

        //get parameters
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

    /**
     * @param $var name and email of this user to check if they are used by other users
     * @return int
     */
    public function check_name_email_existed ($var) {
        //get names and emails from var
        $name = $var['name'];
        $email = $var['email'];

        if ( $stmt = $this->db->prepare("SELECT name FROM user WHERE name = ? OR email = ?") ){
            $stmt->bind_param('ss', $name, $email);
            $stmt->execute();
            $stmt->bind_result($n);
            $stmt->fetch();

            if ($n != NULL) {
                return 1;
            }

        } else {
            echo "check_name_email_existed: query statement went wrong";
        }
        $stmt->close();

        return 0;
    }

    /**
     * @param $var name of this user
     * @return array|bool|int
     */
    public function get_videos_of_user ($var) {
        $name = $var['name'];

        //run query to get all the videos of this user
        if ( $stmt = $this->db->prepare("SELECT v.name, v.size, v.url, v.type, v.create_date, v.views, v.poster_url FROM
            (video v INNER JOIN user u ON u.user_id = v.user_id )
            WHERE u.name = ?") )
        {
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->bind_result($v_name, $size, $url, $type, $create_date, $views, $poster_url);

            $videos = array();

            //use this while loop to create all videos objects of this user
            while ($row = $stmt->fetch()) {
                $video = new Video();
                $var = array(
                    "name" => $v_name,
                    "size" => $size,
                    "url" => $url,
                    "type" => $type,
                    "creator" => $name,
                    "create_date" => $create_date,
                    "views" => $views,
                    "poster_url" => $poster_url
                );

                $video->set_attributes($var);
                array_push($videos, $video);
            }

            //if there's none video of this user just return false
            if (sizeof($videos) == 0) {
                return false;
            }
            else {
                return $videos;
            }

        } else {
            echo "check_name_email_existed: query statement went wrong";
        }
        $stmt->close();
        return 0;
    }

    /**
     * @param $user_name string name of this user
     * @param $video video object from the user upload
     * @return bool
     */
    public function upload_video ($user_name, $video) {

        // Bucket Name
        list($name, $size, $ext, $create_date, $url) = $this->upload_to_aws($video);

        //get user id by user name
        if ( $stmt = $this->db->prepare("SELECT user_id FROM user WHERE user.name = ?") ){
            $stmt->bind_param('s', $user_name);
            $stmt->execute();
            $stmt->bind_result($user_id);
            $stmt->fetch();
        }

        $stmt->close();

        $poster_url = "https://s3-us-west-2.amazonaws.com/iknow-video-sources/quick-time/Screen+Shot+2014-11-09+at+8.22.55+PM.png";

        //update mysql
        //insert into video table
        $views = 0;
        if ( $stmt = $this->db->prepare("INSERT INTO video ( name, size, url, type, user_id, create_date, poster_url) VALUES ( ?, ?, ?, ?,?, ?, ?)") ){
            $stmt->bind_param('sdssdss', $name, $size, $url, $ext, $user_id, $create_date, $poster_url);
            $stmt->execute();
        } else {
            echo "upload video: insert statement went wrong";
        }

        $video_id = $this->db->insert_id;

        //insert video id and user_table
        if ( $stmt = $this->db->prepare("INSERT INTO user_to_video (user_id, video_id) VALUES (?, ?)") )
        {
            $stmt->bind_param('ii', $user_id, $video_id);
            $stmt->execute();
        } else {
            echo "upload video: insert statement went wrong";
        }
        $stmt->close();

        return true;
    }

    /**
     * @param $str string get the extension of this file name
     * @return string
     */
    public function getExtension($str)
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    /**
     * @param $var name and follower name of this action
     */
    public function subscript ($var) {
        $user = $var['user'];
        $follower = $var['follower'];

        //get user id and follower id
        if ( $stmt = $this->db->prepare("SELECT user_id FROM user WHERE name = ?") ){
            $stmt->bind_param('s', $user);
            $stmt->execute();
            $stmt->bind_result($user_id);
            $stmt->fetch();
        } else {
            echo "subscript: query statement went wrong";
        }
        if ( $stmt = $this->db->prepare("SELECT user_id FROM user WHERE name = ?") ){
            $stmt->bind_param('s', $follower);
            $stmt->execute();
            $stmt->bind_result($follower_id);
            $stmt->fetch();
        } else {
            echo "subscript: query statement went wrong";
        }
        //update two ids in the relation table in database
        if ( $stmt = $this->db->prepare("INSERT INTO user_subscription (user_id, follower_id) VALUES (?, ?)") ){
            $stmt->bind_param('dd', $user_id, $follower_id);
            $stmt->execute();
        } else {
            echo "subscript: insert statement went wrong";
        }
        $stmt->close();
    }

    /**
     * @param $var name of this user
     * @return array|bool
     */
    public function get_subscription($var) {

        $name = $var['name'];
        //get user id
        if ( $stmt = $this->db->prepare("SELECT user_id FROM user WHERE name = ?") ){
            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->bind_result($user_id);
            $stmt->fetch();
        } else {
            echo "get_subscription: query statement went wrong";
        }
        $users = array();
        $stmt -> close();

        //get subscriptions name of user

        if ( $stmt = $this->db->prepare("SELECT u.name FROM (user u INNER JOIN user_subscription us ON u.user_id = us.user_id ) WHERE us.follower_id = ? ") )
        {
            $stmt->bind_param('d', $user_id);
            $stmt->execute();
            $stmt->bind_result($user_name);

            while ($row = $stmt->fetch()) {
                array_push($users, $user_name);
            }
            if (sizeof($users) == 0) {
                return false;
            }
        }
        return $users;
    }

    /**
     * @param $video
     * @return array
     */
    public function upload_to_aws($video)
    {
        $bucket = "iknow-video-sources";
        if (!class_exists('S3')) require_once('../library/S3.php');

        //AWS access info
        if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIRZINNE5XDLYDS3A');
        if (!defined('awsSecretKey')) define('awsSecretKey', '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');
        $s3 = new S3(awsAccessKey, awsSecretKey);

        //Here you can add valid file extensions.
        $valid_formats = array("txt", "jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP", "mp4");

        //upload video on s3
        $name = $video['name'];
        $size = $video['size'];
        $tmp = $video['tmp_name'];
        $ext = $this->getExtension($name);
        $create_date = date("Y-m-d");

        if (strlen($name) > 0) {
            // File format validation
            if (in_array($ext, $valid_formats)) {
                // File size validation
                if ($size < (1024 * 1024)) {
                    //Rename image name.
                    $actual_image_name = time() . "." . $ext;
                    $folder_name = "newfolder2/";

                    if ($s3->putObjectFile($tmp, $bucket, $folder_name . $actual_image_name, S3::ACL_PUBLIC_READ)) {
                        $msg = "S3 Upload Successful.";
                        https://s3-us-west-2.amazonaws.com/iknow-video-sources/newfolder2/1415652709.mp4
                        $url = 'http://s3-us-west-2.amazonaws.com/' . $bucket . '/' . $folder_name . $actual_image_name;
                        return array($name, $size, $ext, $create_date, $url);
                    } else
                        $msg = "S3 Upload Fail.";return array($name, $size, $ext, $create_date, $url);
                } else
                    $msg = "Image size Max 1 MB";return array($name, $size, $ext, $create_date, $url);
            } else
                $msg = "Invalid file, please upload image file.";return array($name, $size, $ext, $create_date, $url);
        } else
            $msg = "Please select image file.";return array($name, $size, $ext, $create_date, $url);
    }

}
?>