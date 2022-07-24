<?php
    include "header.php";
    include "connect.php";
    
    
    if($_SERVER['REQUEST_METHOD'] != 'POST')
    {
        echo '<form method="post" action="">
        目录名: <input type="text" name="cat_name" />
        描述: <br><textarea name="cat_description" /></textarea>
        <input type="submit" value="提交修改" />
     </form>';
    }
    else{
        $sql="update categories set  cat_name='".mysqli_real_escape_string($conn,$_POST['cat_name'])."',
        cat_description='".mysqli_real_escape_string($conn,$_POST['cat_description'])."'
        where cat_id='".$_GET["id"]."'
            ";
        $result=mysqli_query($conn,$sql);
    if(!$result)
    {
        echo 'Error' . mysqli_error($conn);
    }
    else
    {
        echo '目录已经被修改成功';
    }
}
    
    include "footer.php";
?>