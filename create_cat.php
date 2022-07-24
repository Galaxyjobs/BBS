<?php
    include "header.php";
    include "connect.php";
    if($_SESSION['user_level']==0)
    {
        ?>
        <script>
            alert("You don't have right to add a category,please contact the admin.");
            window.location.href="index.php";
        </script>
        <?php
    }
    else{

    
    if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    //the form hasn't been posted yet, display it
    echo '<form method="post" action="">
        Category name: <input type="text" name="cat_name" />
        Category description: <br><textarea name="cat_description" /></textarea>
        <input type="submit" value="Add category" />
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
        echo 'New category successfully added.';
    }
}
    }
    include "footer.php";
?>