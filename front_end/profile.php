
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php
    include '../views/display.php';
?><!--
Design by TEMPLATED
http://templated.co
Released for free under the Creative Commons Attribution License

Name       : Skeleton 
Description: A two-column, fixed-width design with dark color scheme.
Version    : 1.0
Released   : 20130902

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
<link href="css/cool.css" rel="stylesheet" type="text/css" media="all" />
<link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

<!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<div id="page" class="container">
	<div id="header">
		<div id="logo">
			<img src="images/pic02.jpg" alt="" />
			<h1><a href="#">Privy</a></h1>
			<span>Design by <a href="http://templated.co" rel="nofollow">TEMPLATED</a></span>
			<br/>
			<span>Gender</span>
		</div>
		<div id="menu">
			<ul>
				<li class="current_page_item"><a href="#" accesskey="1" title="">My Channel</a></li>
				<li><a href="#" accesskey="2" title="">My Subscriptions</a></li>
				<li><a href="#" accesskey="3" title="">History</a></li>
				<li><a href="#" accesskey="4" title="">Favorites</a></li>
				<!-- <li><a href="#" accesskey="5" title=""></a></li> -->
			</ul>
		</div>
	</div>
	<div id="main">
		<div id="banner">
			<img src="images/pic01.jpg" alt="" class="image-full" />
		</div>
		<div id="welcome">
			<div class="title">
				<h2>Fusce ultrices fringilla metus</h2>
				<span class="byline">Donec leo, vivamus fermentum nibh in augue praesent a lacus at urna congue</span>
			</div>
			<p>This is <strong>Privy</strong>, a free, fully standards-compliant CSS template designed by <a href="http://templated.co" rel="nofollow">TEMPLATED</a>. The photos in this template are from <a href="http://fotogrph.com/"> Fotogrph</a>. This free template is released under the <a href="http://templated.co/license">Creative Commons Attribution</a> license, so you're pretty much free to do whatever you want with it (even use it commercially) provided you give us credit for it. Have fun :) </p>
			<ul class="actions">
				<li><a href="#" class="button">Etiam posuere</a></li>
			</ul>
		</div>
		<div id="featured">
			<div class="title">
				<h2>Recent Uploads</h2>
				<span class="byline">Please subscript if you like</span>
			</div>
			<ul class="style1">
				<!--<li class="first">-->
					<!--<p class="date"><a href="#">Jan<b>05</b></a></p>-->
					 <!--<h3><a href="#">Beautiful Ocean</a></h3>-->
					 <!--<p><a href="#">Uploaded by simon</a></p>-->
					 <!--<p>3000 Views</p>-->

    				<!--<video id="example_video_1" class="video-js vjs-default-skin"-->
				           <!--controls preload="auto" width="640" height="264"-->
				           <!--poster="http://video-js.zencoder.com/oceans-clip.png"-->
				           <!--data-setup='{"example_option":true}'>-->
				        <!--<source src="https://s3-us-west-2.amazonaws.com/iknow-video-sources/oceans-clip.mp4" type='video/mp4' />-->
				        <!--<p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>-->
				    <!--</video>-->
				<!--</li>-->

                <?php

                    Display::show_videos_in_profile("qqq");
                    ?>
			</ul>
		</div>
		<div id="copyright">
			<span>&copy; iKnow. All rights reserved. | CS242</span>
		</div>
	</div>
</div>
</body>
</html>
