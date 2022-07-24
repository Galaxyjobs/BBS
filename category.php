<?php
    include "header.php";
    include "connect.php";
    $sql = "SELECT
            cat_id,
            cat_name,
            cat_description
        FROM
            categories
        WHERE
            cat_id = '".mysqli_real_escape_string($conn,$_GET['id'])."'";
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo '目录目前还无法显示，请稍后重试' . mysql_error();
            }
            else
            {
                if($result->num_rows==0)
                {
                    echo '目录还没有被创建';
                }
                else
                {
                    if($row = mysqli_fetch_assoc($result))
                    {
                        echo '<h2>目录′' . $row['cat_name'] . '′下的话题 </h2>';
                    }
                    $sql = "SELECT  
                    topic_id,
                    topic_subject,
                    topic_date,
                    topic_cat
                FROM
                    topics
                WHERE
                    topic_cat = " . mysqli_real_escape_string($conn,$_GET['id']);
                    $result=mysqli_query($conn,$sql);
                    if(!$result)
                    {
                        echo '话题还不能显示，请稍后再试';
                    }
                    else
                    {
                        if($result->num_rows==0)
                        {
                            echo "这个目录下还没有任何话题";
                        }
                        else
                        {
                            echo '<table border="1">
                                    <tr>
                                    <th>话题</th>
                                    <th>创建于</th>
                                </tr>';
                                while($row = mysqli_fetch_assoc($result))
                                {               
                                    echo '<tr>';
                                    echo '<td class="leftpart">';
                                    echo '<h3><a href="topic.php?id=' . $row['topic_id'] . '">' . $row['topic_subject'] . '</a><h3>';
                                    echo '</td>';
                                    echo '<td class="rightpart">';
                                    echo date('d-m-Y', strtotime($row['topic_date']));
                                    echo '</td>';
                                    echo '</tr>';
                } 
                        }
                    }
                }
            }
    include "footer.php";
?>