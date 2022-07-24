<?php
    include "header.php";
    include "connect.php";
    if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in'])
    {
        echo '你已成功登录, 如果你想的话，你可以 <a href="signout.php">登出</a> ';
    }
    else
    {
        if($_SERVER['REQUEST_METHOD']!="POST")
        {
            echo '
            <form method="post" action="">
            用户名: <input type="text" name="user_name" />
            密码: <input type="password" name="user_pass">
            <input type="submit" value="登录" />
            </form>
            ';
            $_POST['user_name']=null;
            $_POST['user_pass']=null;
        }
        else
        {
            $errors = array();
            if(empty($_POST['user_name']))
            {
                $errors[]="用户名没有填写";
            }
            if(empty($_POST['user_pass']))
            {
                $errors[]="密码没有填写";
            }
        
        if(!empty($errors))
        {
            echo "噢。。可能出了点错误";
            echo '<ul>';
            foreach ($errors as $key=>$value)
            {
                echo '<li>'.$value.'</li>';
            }
            echo '<ul>';
        }
        else
        {
            $sql="select user_id,user_name,user_level
            from users
            where user_name='".mysqli_real_escape_string($conn,$_POST['user_name'])."'
            and user_pass='".md5($_POST['user_pass'])."'
            ";
            $result=mysqli_query($conn,$sql);
            $rows=$result->num_rows;
            if(!$rows)
            {
                echo '登录时发生了点错误，请稍后再试';
            }
            else
            {
                $_SESSION['signed_in'] = true;
                while($row = mysqli_fetch_assoc($result))
                {
                    $_SESSION['user_id']    = $row['user_id'];
                    $_SESSION['user_name']  = $row['user_name'];
                    $_SESSION['user_level'] = $row['user_level'];
                }
                echo '欢迎, ' . $_SESSION['user_name'] . '. <a href="index.php">前往主页查看</a>.';
            }
        }}
    }
    include "footer.php";
?>