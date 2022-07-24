<?php
    include "header.php";
    include "connect.php";
    session_destroy();
    echo "You have successfully signed out.";
    include "footer.php";
?>