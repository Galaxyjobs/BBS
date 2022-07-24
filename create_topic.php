<?php
    include "header.php";
    include "connect.php";
    if($_SESSION['signed_in']==false)
    {
        echo 'Sorry, you have to be <a href="/forum/signin.php">signed in</a> to create a topic.';
    }
    else
    {
        if($_SERVER['REQUEST_METHOD']!='POST')
        {
            $sql='select 
                    cat_id,
                    cat_name,
                    cat_description
                from categories;
            ';
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo 'Error while selecting from database. Please try again later.';
            }
            else
            {
                if($result->num_rows==0)
                {
                    if($_SESSION['user_level']==1)
                    {
                        echo "You have not created categories yet.";
                    }
                    else
                    {
                        echo 'Before you can post a topic, you must wait for an admin to create some categories.';
                    }
                }
                else
                {
                    echo '<form method="post" action="">
                        Subject:<input type="text" name="topic_subject">
                        Category:<select name="topic_cat">
                    ';
                    while($row=mysqli_fetch_array($result))
                    {
                        echo '<option value="'.$row["cat_id"].'">'.$row["cat_name"].'</option>';
                    }
                    echo '</select>';
                    echo '<br>';
                    echo 'Message: <br><textarea name="post_content" /></textarea>
                    <input type="submit" value="Create topic" />
                 </form>';
                }
            }
        }
        else
        {
            $sql="BEGIN WORK";
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo "An error occured while creating your topic. Please try again later.";
            }
            else
            {
                $sql="insert into 
                topics(topic_subject,
                topic_date,
                topic_cat,
                topic_by)
                values('".mysqli_real_escape_string($conn,$_POST['topic_subject'])."',
                    now(),
                    '".mysqli_real_escape_string($conn,$_POST['topic_cat'])."',
                    '".$_SESSION['user_id']."'
            )";
            $result=mysqli_query($conn,$sql);
            if(!$result)
            {
                echo 'An error occured while inserting your data. Please try again later.' . mysqli_error($conn);
                $sql="ROLLBACK";
                $result=mysqli_query($conn,$sql);
            }
            else
            {
                $topicid=mysqli_insert_id($conn);
                $sql="insert into 
                posts(post_content,
                post_date,
                post_topic,
                post_by)
                values('".mysqli_real_escape_string($conn,$_POST['post_content'])."',
                now(),
                '".$topicid."',
                '".$_SESSION['user_id']."')
                ";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo 'An error occured while inserting your post. Please try again later.' . mysql_error();
                    $sql="Rollback";
                    mysqli_query($conn,$sql);
                }
                else
                {
                    $sql="COMMIT;";
                    mysqli_query($conn,$sql);
                    echo 'You have successfully created <a href="topic.php?id='. $topicid . '">your new topic</a>.';
                }
            }
            }
        }
    }
    include "footer.php";
?>