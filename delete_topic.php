<?php
    include "header.php";
    include "connect.php";
    $sql="delete from topics
        where topic_id='".mysqli_real_escape_string($conn,$_GET['id'])."'
    ";
    $result=mysqli_query($conn,$sql);
    if(!$result)
    {
        echo "删除失败，出现了一些预料之外的错误";
    }
    else
    {
        echo '删除成功';
    }
    include "footer.php";
?>