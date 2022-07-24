<?php
    
    include "connect.php";
    session_start();
    session_destroy();
    include "header.php";
    echo "你已经成功登出";
    include "footer.php";
?>