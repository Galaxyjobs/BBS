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
        echo 'No categories defined yet.';
    }
    else{
        echo '<table border="1">
        <tr>
          <th>Category</th>
          <th>Last topic</th>
        </tr>';
        while($row=mysqli_fetch_array($result))
        {
            echo '<tr>';
                echo '<td class="leftpart">';
                    echo "<h3><a href='category.php?id={$row['cat_id']}'>" . $row['cat_name'] . '</a></h3>' . $row['cat_description'];
                echo '</td>';
                echo '<td class="rightpart">';
                            echo '<a href="topic.php?id=">Topic subject</a> at 10-10';
                echo '</td>';
            echo '</tr>';
        }
    }
    include "footer.php";
?>