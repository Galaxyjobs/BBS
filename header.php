<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>SDU forum</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>SDU forum</h1>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">Home</a> -
        <a class="item" href="create_topic.php">Create a topic</a> -
        <a class="item" href="create_cat.php">Create a category</a>
         
        <!-- <div id="userbar"> -->
        <?php
            session_start();
            echo '<div id="userbar">';
            if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
            {
                echo 'Hello!'.$_SESSION['user_name'].'.Not you?<a href="signout.php">Sign out</a>';
            }
            else
            {
                echo '<a href="signin.php">Sign in</a> or <a href="signup.php">Create an account</a>';
            }
            echo '</div>';       
        ?>
    </div>
        <div id="content">