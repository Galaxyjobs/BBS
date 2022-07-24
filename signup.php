<?php
    include "header.php";
    include "connect.php";
    if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in'])
    {
        echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
    }
    else{
    echo "<h3>sign up</h3>";
    if($_SERVER["REQUEST_METHOD"]!="POST")
    {
        echo '
            <form method="post" action="">
            Username:<input type="text" name="user_name">
            Password: <input type="password" name="user_pass">
            Password again: <input type="password" name="user_pass_check">
            E-mail: <input type="email" name="user_email">
            <input type="submit" value="Add category" />
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
                $errors[]="The username can only contain letters and digits.";
            }
            if(strlen($_POST['user_name'])>30)
            {
                $errors[]="The username cannot be longer than 30 characters.";
            }
        }
        else
        {
            $errors[]="The username field must not be empty.";
        }
        if(!empty($_POST['user_pass']))
        {
            if($_POST['user_pass']!=$_POST['user_pass_check'])
            {
                $errors[]="The two passwords did not match.";
            }

        }
        else
        {
            $errors[]="The password field cannot be empty.";
        }
        if(!empty($errors))
        {
            echo 'Uh-oh.. a couple of fields are not filled in correctly..';
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
                echo 'Something went wrong while registering. Please try again later.';
            }
            else
            {
                echo 'Successfully registered! You can now <a href="signin.php"> sign in </a>and post!';
            }
        }
    }



    }
    include "footer.php";

?>