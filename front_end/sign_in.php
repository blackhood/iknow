<!DOCTYPE HTML>
<html>
<?php
    if (isset($_POST['submit'])) {
        $name = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
    }
?>
<head>
    <title>Sign Up</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
    </noscript>
</head>
<body id="top">

<!-- Header -->
<header id="header" class="skel-layers-fixed">
    <h1><a href="index.html">Iknow</a></h1>
</header>

<!-- Main -->
<section id="main" class="wrapper style1">
    <header class="major">
        <h2>Welcome to iknow</h2>
        <p>Please enter your information down here to sign in</p>
    </header>
    <div class="container">
        <form id="form" method="post" action="sign_up.php" >
            <section>
                <h2>Username</h2>
                <p> <input type="text" id="user" name="username" placeholder="Username" /> </p>
                <h2>Password</h2>
                <p><input type="email" id="email" name="email" placeholder="Password" /></p>
                <ul class="actions">
                    <li><a href="test.html" class="button big special" name="submit" type="submit">Sign In</a></li>
                </ul>
            </section>
        </form>
    </div>
</section>

<!-- Footer -->
<footer id="footer">
    <div class="container">
        <ul class="copyright">
            <li>&copy; CS242. All rights reserved.</li>
        </ul>
    </div>
</footer>
</body>
</html>