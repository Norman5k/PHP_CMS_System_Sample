<?php 

if(!isset($_SESSION['user_data'])) {
    include_once "nav_bar_all.php";
} else {
    include_once "nav_bar_auth.php";
}

?>