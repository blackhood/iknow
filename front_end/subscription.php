<?php
session_start();
$user_name = $_SESSION['username'];
require_once '../views/display.php';
require_once('../controllers/server.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
			<h1><a href="#"><?php echo $user_name; ?></a></h1>
			<span>Design by <a href="http://templated.co" rel="nofollow">CS242</a></span>
			<br/>
			<span>Gender</span>
		</div>
		<div id="menu">
			<ul>
				<li><a href="profile.php" accesskey="1" title="">Channel</a></li>
				<li class="current_page_item"><a href="#" accesskey="2" title="">Subscriptions</a></li>
				<li><a href="#" accesskey="3" title="">Edit Information</a></li>
				<li><a href="#" accesskey="4" title="">Favorites</a></li>
			</ul>
		</div>
	</div>
	<div id="main">
		<div id="banner">
			<img src="images/pic01.jpg" alt="" class="image-full" />
		</div>
		<div id="welcome">
			<div class="title">
				<h2>Subscriptions</h2>
            </div>
		</div
		<div id="featured">
			<ul class="style1">
                <?php
                    Display::show_user_subscription($user_name);
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
