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
                echo 'The category could not be displayed, please try again later.' . mysql_error();
            }
            else
            {
                if($result->num_rows==0)
                {
                    echo 'This category does not exist.';
                }
                else
                {
                    if($row = mysqli_fetch_assoc($result))
                    {
                        echo '<h2>Topics in ′' . $row['cat_name'] . '′ category</h2>';
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
                        echo 'The topics could not be displayed, please try again later.';
                    }
                    else
                    {
                        if($result->num_rows==0)
                        {
                            echo "There are no topics in this category yet.";
                        }
                        else
                        {

                        }
                    }
                }
            }
    include "footer.php";
?>