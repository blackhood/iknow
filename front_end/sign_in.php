<?php
session_start();
$_SESSION['username'] = null;

?>
<!DOCTYPE HTML>
<html>
<?php
include('../controllers/server.php');
if (isset($_POST['submit'])) {
    $name = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $user = array(
        'name' => $_POST["username"],
        'password' => $_POST["password"]
    );

    $sign_in_result = Server::sign_in($user);

    if($sign_in_result == true){
        echo "<script type='text/javascript'>alert('Sign in succeed!!!!')</script>";
        $_SESSION['username'] = $name;
        header("Location: profile.php");
    }
    else{
        echo "<script type='text/javascript'>alert('Sign in failed!!!!')</script>";
    }

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
        <form id="form" method="post" action="sign_in.php" >
            <section>
                <h2>Username</h2>
                <p> <input type="text" id="user" name="username" placeholder="Username" /> </p>
                <h2>Password</h2>
                <p><input type="password" id="password" name="password" placeholder="Password" /></p>
                <button class="button big special" name="submit" type="submit">Sign In</button>
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