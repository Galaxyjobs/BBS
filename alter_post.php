<?php
    include "header.php";
    include "connect.php";
    if($_SERVER['REQUEST_METHOD']!='POST')
    {
        echo '<h3>Reply:</h3><br>';
        echo '<form method="POST" action="">';
        echo '<textarea name="reply_content"></textarea>';
        echo '<input type="submit" value="修改回复">';
        echo '</form>';
    }
    else
    {
        $sql="update posts set post_content='".mysqli_real_escape_string($conn,$_POST['reply_content'])."'
            where post_id='".$_GET["id"]."'
        ";
        $result=mysqli_query($conn,$sql);
        if(!$result)
        {
            echo "发生了一些错误，请稍后再试";
        }
        else 
        {
            echo "修改成功";
        }
    }

    include "footer.php";
?>