<?php
Class User {
    private $name;
    private $email;
    private $password;
    private $create_date;

    //user profile image url
    //private $image;

    //user's video urls
    //private $videos;


    /**
     * constructor, don't do much, may need improve.
     */
    public function User(){
    }

    /**
     * set all attributes at once, but doesn't check validation right now.
     * @param an array map contain all the attributes
     * @return true is set successfully, false otherwise.
     */
    public function set_attributes($attributes){
        if(isset($attributes['name']) && isset($attributes['email']) && isset($attributes['password']) &&
            isset($attributes['create_date'])) {
            $this->name = $attributes['name'];
            $this->email = $attributes['email'];
            $this->password = $attributes['password'];
            $this->create_date = $attributes['create_date'];
            //$this->image = $attributes['image'];
            //$this->videos = $attributes['videos'];
            return true;
        }
        else{
            echo 'the passing in attributes are not valid!!!';
            return false;
        }
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param mixed $create_date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * @param mixed $videos
     */
    public function setVideos($videos)
    {
        $this->videos = $videos;
    }
}
?>