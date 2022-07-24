<?php
    include "header.php";
    include "connect.php";
    $sql='select 
    cat_id,
    cat_name,
    cat_description
    from categories
    ';
    $result=mysqli_query($conn,$sql);
    $rows=$result->num_rows;
    if($rows==0)
    {
        echo '还没有创建任何目录';
    }
    else{
        echo '<table border="1">
        <tr>
          <th>目录</th>
        </tr>';
        while($row=mysqli_fetch_array($result))
        {
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo "<h3><a href='category.php?id={$row['cat_id']}'>" . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                    if(isset($_SESSION['user_level'])&&$_SESSION['user_level']==1)
                    {   
                        echo '<a class="delete" href="delete_cat.php?id='.$row['cat_id'].'">删除</a>';
                        echo '<a class="alter" href="alter_cat.php?id='.$row['cat_id'].'">修改</a>';
                    }
                echo '</td>';
            echo '</tr>';
        }
    }
    include "footer.php";
?>