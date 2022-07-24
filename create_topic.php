<?php
    include "header.php";
    include "connect.php";
    if(!isset($_SESSION['signed_in'])||$_SESSION['signed_in']==false)
    {
        echo '对不起，你必须先 <a href="signin.php">登录</a> 才能创建话题';
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
                echo '发生了一个错误，请稍后再试';
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
                        主题:<input type="text" name="topic_subject">
                        目录:<select name="topic_cat">
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
                echo "创建主题时出现了一个错误，请稍后再试";
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
                echo '提交数据时发现了一个错误，请稍后再试' . mysqli_error($conn);
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
                    echo '你的提交出现了一个错误，请稍后再试' . mysql_error();
                    $sql="Rollback";
                    mysqli_query($conn,$sql);
                }
                else
                {
                    $sql="COMMIT;";
                    mysqli_query($conn,$sql);
                    echo '你已成功创建了 <a href="topic.php?id='. $topicid . '">新话题</a>.';
                }
            }
            }
        }
    }
    include "footer.php";
?>