<?php
//include('../models/video.php');
include('../controllers/db_manager.php');
Class Display
{
    public static function show_videos_in_profile($user_name){
        $db_manager = new DB_manager();
        $var = array(
            "name" => $user_name
        );
        $videos = $db_manager -> get_videos_of_user($var);

        if($videos == false){
            echo 'no video';
            return;
        }
        foreach($videos as $video){
            $url = $video -> getUrl();
            $name = $video -> getName();
            $poster_url = $video ->getPosterUrl();
            $create_data = $video -> getCreateDate();
            $creator = $video -> getCreator();
            $views = $video -> getViews();
            echo '
                 <li>
                    <p class="date"><a href="#">' . $create_data . '</b></a></p>
					<h3><a href="#">' . $name .'</a></h3>
					<p><a href="#">Uploaded by ' .$creator .'</a></p>
					<p>' .$views .' Views</p>

                    <video id="example_video_1" class="video-js vjs-default-skin"
                           controls preload="auto" width="640" height="264"
                           poster="' . $poster_url . '"
                           data-setup=\'{"example_option":true}\'>
                    <source src="'. $url .'" type=\'video/mp4\' />
                    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                    </video>
                 </li>
            ';

        }

    }



}

?>