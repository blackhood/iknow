<!DOCTYPE HTML>
<html>
<?php
include("../controllers/server.php");
if (isset($_POST['submit'])) {
//        $required_field = array("email", "username","password");
//        validate_presences($required_field);
//
//        $fields_with_max_lengths = array("username" => 30);
//        validate_max_lengths($fields_with_max_lengths);

    $user = array(
        'name' => $_POST["username"],
        'email' => $_POST["email"],
        'password' => $_POST["password"],
        'confirm_p' => $_POST["confirm_p"]
    );

    $sign_up_result = Server::sign_up($user);
    if($sign_up_result == -1)
        echo "<script type='text/javascript'>alert('Password mismatch!!!!')</script>";
    else if($sign_up_result == -2){
        echo "<script type='text/javascript'>alert('Name or email existed!!!!')</script>";
    }
    else{
        /* Redirect browser */
        //echo "<script type='text/javascript'>alert('Sign up succeeded!!!!')</script>";

        //header("Location: test.html");
        $temp = "sign_in.php";

        header("Location: " . $temp);
        /* Make sure that code below does not get executed when we redirect. */

        //echo "hello";
        exit;
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
        <h2>Welcome to sign up page</h2>
        <p>Please enter your information down here to sign up</p>
    </header>
    <div class="container">
        <form id="form" method="post" action="sign_up.php" >
            <section>
                <h2>Username</h2>
                <p> <input type="text" id="user" name="username" placeholder="Username" /> </p>
                <h2>Password</h2>
                <p><input type="password" id="password" name="password" placeholder="Password" /></p>

                <h2>Re-enter Password</h2>
                <p><input type="password" id="confirm_p" name="confirm_p" placeholder="Confirm Password" /></p>
                <h2>Email</h2>
                <p><input type="email" id="email" name="email" placeholder="Email" /></p>

                <button class="button big special" name="submit" type="submit">Sign Up</button>

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