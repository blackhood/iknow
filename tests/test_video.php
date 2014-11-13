<?php
/**
 * Created by PhpStorm.
 * User: simoncai
 * Date: 11/5/14
 * Time: 9:24 PM
 */

class test_user extends PHPUnit_Framework_TestCase {
    public function test_set_attributes()
    {
        $video = new Video();

        $attributes = array(
            'name' => 'best video ever.mp4',
            'size' => 1024,
            'type' => 'mp4',
            'url' => 'myvideo',
            'creator' => 'david',
            'create_date' => '2014-11-5',
            'views' => 42,
            'poster_url' => 'myposter'
        );

        $result = $video -> set_attributes($attributes);

        $this->assertEquals(true, $result);
        $this->assertEquals('best video ever.mp4', $video->getName());
        $this->assertEquals(1024, $video->getSize());
    }

    public function test_set_get_name()
    {
        $video = new Video();

        $video -> setName("David");
        $result = $video -> getName();

        $this->assertEquals("David", $result);
    }

    public function test_set_get_date()
    {
        $video = new Video();

        $video -> setCreateDate("2014-9-22");
        $result = $video -> getCreateDate();

        $this->assertEquals("2014-9-22", $result);
    }

    public function test_set_get_views()
    {
        $video = new Video();

        $video -> setViews(13);
        $result = $video -> getViews();

        $this->assertEquals(13, $result);
    }
}
 