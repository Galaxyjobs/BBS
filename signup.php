<?php
    include "header.php";
    include "connect.php";
    if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in'])
    {
        echo '你已经登录, 如果你愿意，可以 <a href="signout.php">退出</a> ';
    }
    else{
    echo "<h3>注册</h3>";
    if($_SERVER["REQUEST_METHOD"]!="POST")
    {
        echo '
            <form method="post" action="">
            用户名:<input type="text" name="user_name">
            密码: <input type="password" name="user_pass">
            再次输入密码: <input type="password" name="user_pass_check">
            邮箱: <input type="email" name="user_email">
            <input type="submit" value="注册" />
            </form>
        ';
    }
    else
    {
        $errors=array();
        if(!empty($_POST['user_name']))
        {
            if(!ctype_alnum($_POST['user_name']))
            {
                $errors[]="用户名只能字母和数字";
            }
            if(strlen($_POST['user_name'])>30)
            {
                $errors[]="用户名不能大于30个字符";
            }
        }
        else
        {
            $errors[]="用户名不能为空";
        }
        if(!empty($_POST['user_pass']))
        {
            if($_POST['user_pass']!=$_POST['user_pass_check'])
            {
                $errors[]="两次输入密码不一致";
            }

        }
        else
        {
            $errors[]="密码不能为空.";
        }
        if(!empty($errors))
        {
            echo '噢，发生了点错误';
            echo '<ul>';
            foreach($errors as $key=>$value)
            {
                echo '<li>'.$value.'</li>';
            }
        }
        else
        {
            $sql = " insert into 
                    users(user_name,user_pass,user_email,user_date,user_level)
                    values('".mysqli_real_escape_string($conn,$_POST['user_name'])."',
                    '".md5($_POST['user_pass'])."',
                    '".mysqli_real_escape_string($conn,$_POST['user_email'])."',
                    now(),
                    0
                    )";
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo '注册时发生了点错误，请稍后再试';
            }
            else
            {
                echo '成功注册，你可以 <a href="signin.php"> 登录 </a>然后发言';
            }
        }
    }



    }
    include "footer.php";

?>