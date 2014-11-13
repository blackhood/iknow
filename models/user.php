<?php

/**
 * Class User
 */
Class User {
    /**
     * @var string user name of this user
     */
    private $name;
    /**
     * @var string email of this user
     */
    private $email;
    /**
     * @var string hashed password of this user
     */
    private $password;
    /**
     * @var string the created date of this user
     */
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
            return true;
        }
        else{
            echo 'the passing in attributes are not valid!!!';
            return false;
        }
    }

    /**
     * @return create date
     */
    public function getCreateDate()
    {
        return $this->create_date;
    }

    /**
     * @param string $create_date
     * set create date
     */
    public function setCreateDate($create_date)
    {
        $this->create_date = $create_date;
    }

    /**
     * @return string email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param set $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    /**
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param set string name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return get password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param set password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

}
?>