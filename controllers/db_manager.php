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

    public function get_videos_of_user ($var) {
        $name = $var['name'];

        if ( $stmt = $this->db->prepare("SELECT v.name, v.size, v.url, v.type, v.create_date, v.views, v.poster_url FROM
            (video v INNER JOIN user u ON u.user_id = v.user_id )
            WHERE u.name = ?") )
        {

            $stmt->bind_param('s', $name);
            $stmt->execute();
            $stmt->bind_result($v_name, $size, $url, $type, $create_date, $views, $poster_url);

            $videos = array();

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

//                echo ("inside");
//                echo $v_name;
//                echo $size;
//                echo $url;
//                echo $type;
//                echo $create_date;
//                echo $views;
//                echo $poster_url;
            }

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

    public function upload_video ($user_name, $video) {

        // Bucket Name
        $bucket="iknow-video-sources";
        if (!class_exists('S3'))require_once('../library/S3.php');

        //AWS access info
        if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAIRZINNE5XDLYDS3A');
        if (!defined('awsSecretKey')) define('awsSecretKey', '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');
        $s3 = new S3(awsAccessKey, awsSecretKey);

        //Here you can add valid file extensions.
        $valid_formats = array("txt", "jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP","mp4");

        //upload video on s3
        $name = $video['name'];
        $size = $video['size'];
        $tmp = $video['tmp_name'];
        $ext = $this -> getExtension($name);
        $create_date = date("Y-m-d");

        if(strlen($name) > 0)
        {
            // File format validation
            if(in_array($ext,$valid_formats))
            {
                // File size validation
                if($size<(1024*1024))
                {
                    //Rename image name.
                    $actual_image_name = time().".".$ext;
                    $folder_name = "newfolder2/";

                    if($s3->putObjectFile($tmp, $bucket , $folder_name.$actual_image_name, S3::ACL_PUBLIC_READ) )
                    {
                        $msg = "S3 Upload Successful.";
                        https://s3-us-west-2.amazonaws.com/iknow-video-sources/newfolder2/1415652709.mp4
                        $url='http://s3-us-west-2.amazonaws.com/'.$bucket.'/'.$folder_name .$actual_image_name;
                    }
                    else
                        $msg = "S3 Upload Fail.";
                }
                else
                    $msg = "Image size Max 1 MB";
            }
            else
                $msg = "Invalid file, please upload image file.";
        }
        else
            $msg = "Please select image file.";


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

    public function getExtension($str)
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

}
?>