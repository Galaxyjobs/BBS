<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>forum</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<h1>forum</h1>
    <div id="wrapper">
    <div id="menu">
        <a class="item" href="index.php">主页</a> -
        <a class="item" href="create_topic.php">创建话题</a> -
        <a class="item" href="create_cat.php">创建目录</a>
         
        <!-- <div id="userbar"> -->
        <?php
            session_start();
            echo '<div id="userbar">';
            if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in']==true)
            {
                echo '你好'.$_SESSION['user_name'].'.<a href="signout.php">退出</a>';
            }
            else
            {
                echo '<a href="signin.php">登录</a> 或者 <a href="signup.php">创建账号</a>';
            }
            echo '</div>';       
        ?>
    </div>
        <div id="content">