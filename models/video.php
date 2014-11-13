<?php

/**
 * Class Video
 */
Class Video {
    /**
     * @var string name of this video
     */
    private $name;
    /**
     * @var int size of this video
     */
    private $size;
    /**
     * @var string url of this video
     */
    private $url;
    /**
     * @var string extension of this video
     */
    private $type;
    /**
     * @var int creator ID of this video
     */
    private $creator;
    /**
     * @var string create date of this video
     */
    private $create_date;
    /**
     * @var int number of views of this video
     */
    private $views;
    /**
     * @var string poster url of this video
     */
    private $poster_url;

    /**
     * @param string $create_date
     * set create date of this video
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @param int $creator
     * set create id of this video
     */
    public function setCreator($creator)
    {
        $this->creator = $creator;
    }

    /**
     * @param string $name
     * set name of this video
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $poster_url
     * set poster_url of this video
     */
    public function setPosterUrl($poster_url)
    {
        $this->poster_url = $poster_url;
    }

    /**
     * @param int $size
     * set size of this video
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param string $type
     * set extension of this video
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $url
     * set video url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @param int $views
     * set number of views of this video
     */
    public function setViews($views)
    {
        $this->views = $views;
    }

    /**
     * @return name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return create date
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @return creator id
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * @return size
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return video url on AWS S3
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return views
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * default constructor, doesn't do anything yet
     */
    public function Video(){

    }

    /**
     * @return mixed
     */
    public function getPosterUrl()
    {
        return $this->poster_url;
    }


    /**
     * @param $attributes
     * @return bool
     */
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

    /**
     * @param $user_name
     */
    public function show_videos_in_profile($user_name){
        $db_manager = new DB_manager();
        $video_urls = $db_manager -> get_videos_of_user($user_name);

        foreach($video_urls as $url){

        }
    }
}

?>