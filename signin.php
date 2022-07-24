<?php
    include "header.php";
    include "connect.php";
    if(isset($_SESSION['signed_in'])&&$_SESSION['signed_in'])
    {
        echo 'You are already signed in, you can <a href="signout.php">sign out</a> if you want.';
    }
    else
    {
        if($_SERVER['REQUEST_METHOD']!="POST")
        {
            echo '
            <form method="post" action="">
            Username: <input type="text" name="user_name" />
            Password: <input type="password" name="user_pass">
            <input type="submit" value="Sign in" />
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
                $errors[]="The username field must not be empty.";
            }
            if(empty($_POST['user_pass']))
            {
                $errors[]="The password field must not be empty.";
            }
        
        if(!empty($errors))
        {
            echo "Uh-oh.. a couple of fields are not filled in correctly.";
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
                echo 'Something went wrong while signing in. Please try again later.';
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
                echo 'Welcome, ' . $_SESSION['user_name'] . '. <a href="index.php">Proceed to the forum overview</a>.';
            }
        }}
    }
    include "footer.php";
?>