<?php
    include "header.php";
    include "connect.php";
    $sql="select 
        topic_id,
        topic_subject
        from topics
        where 
        topics.topic_id='".mysqli_real_escape_string($conn,$_GET['id'])."'    
    ";
    $result=mysqli_query($conn,$sql);
    if(!$result)
    {
        echo "有一个预料之外的错误，请稍后再试";
    }
    else
    {
        $row=mysqli_fetch_assoc($result);
        echo '
                <table border=1 >
                    <tr>
                        <th colspan=2 class="topic_th">'.$row['topic_subject'].'</th>
                        <th></th>
                    </tr>
                      
        ';
        $sql="select
            posts.post_topic,
            posts.post_content,
            posts.post_date,
            posts.post_by,
            users.user_id,
            users.user_name
            from posts
            left join users
            on posts.post_by=users.user_id
            where posts.post_topic='".mysqli_real_escape_string($conn,$_GET['id'])."'
        ";
        $result=mysqli_query($conn,$sql);
        if(!$result)
        {
            echo "有一个预料之外的错误，请稍后再试";
        }
        else
        {
            while($row=mysqli_fetch_assoc($result))
            {
                echo '
                     <tr>
                        <td class="rightpart">'.$row['user_name'].'.<br>'.$row['post_date'].'</td>
                        <td class="leftpart">'.$row['post_content'].'</td>
                     </tr>
                ';
            }
            echo '</table>';
        }
        if(!isset($_SESSION['signed_in'])||$_SESSION['signed_in']==false)
        {
            echo "如果你想回复，请先 ".'<a href="signin.php">登录 </a>';
        }
        else
        {
            if($_SERVER['REQUEST_METHOD']!='POST')
            {
                echo '<h3>Reply:</h3><br>';
                echo '<form method="POST" action="">';
                echo '<textarea name="reply_content"></textarea>';
                echo '<input type="submit" value="提交回复">';
                echo '</form>';
            }
            else    
            {
                $sql="insert into 
                    posts(post_content,
                    post_date,
                    post_topic,
                    post_by)
                values('".mysqli_real_escape_string($conn,$_POST['reply_content'])."',
                    now(),
                    '".mysqli_real_escape_string($conn,$_GET['id'])."',
                    '".$_SESSION['user_id']."'
                )
            ";
                $result=mysqli_query($conn,$sql);
                if(!$result)
                {
                    echo '你的回复提交时发生了错误，请稍后再试';
                }
                else
                {
                    echo '你的回复已经被保存，前往 <a href="topic.php?id=' . htmlentities($_GET['id']) . '">话题</a>查看.';
                }
            }
        }    
        
    }
    include "footer.php";
?>