<?php
    include "header.php";
    include "connect.php";
    if($_SESSION['user_level']==0)
    {
        ?>
        <script>
            alert("你没有权限创建目录，请联系管理员");
            window.location.href="index.php";
        </script>
        <?php
    }
    else{

    
    if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form method="post" action="">
        目录名: <input type="text" name="cat_name" />
        描述: <br><textarea name="cat_description" /></textarea>
        <input type="submit" value="添加目录" />
     </form>';
}
else{
    $sql="insert into categories(cat_name,cat_description) 
        values('".mysqli_real_escape_string($conn,$_POST['cat_name'])."',
        '".mysqli_real_escape_string($conn,$_POST['cat_description'])."'
        )
    ";
    $result=mysqli_query($conn,$sql);
    if(!$result)
    {
        echo 'Error' . mysqli_error($conn);
    }
    else
    {
        echo '新目录已经被添加成功';
    }
}
    }
    include "footer.php";
?>