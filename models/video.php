<?php
Class Video {
    private $name;
    private $size;
    private $url;
    private $type;
    private $creator;
    private $create_date;
    private $views;
    private $poster_url;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @return mixed
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return mixed
     */
    public function getViews()
    {
        return $this->views;
    }

    public function Video(){

    }

    /**
     * @return mixed
     */
    public function getPosterUrl()
    {
        return $this->poster_url;
    }


    public function set_attributes($attributes){
        if(isset($attributes['name']) && isset($attributes['size']) && isset($attributes['url']) &&
            isset($attributes['type']) && isset($attributes['creator']) && isset($attributes['create_date']) &&
            isset($attributes['views']) && isset($attributes['poster_url'])) {
            $this->name = $attributes['name'];
            $this->size = $attributes['size'];
            $this->url = $attributes['url'];
            $this->type = $attributes['type'];
            $this->creator = $attributes['creator'];
            $this->create_date = $attributes['create_date'];
            $this->views = $attributes['views'];
            $this->poster_url = $attributes['poster_url'];
            return true;
        }
        else{
            echo 'the passing in attributes are not valid!!!';
            return false;
        }
    }

    public function show_videos_in_profile($user_name){
        $db_manager = new DB_manager();
        $video_urls = $db_manager -> get_videos_of_user($user_name);

        foreach($video_urls as $url){

        }

    }
}

?>