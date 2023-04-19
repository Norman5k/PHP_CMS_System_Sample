<?php

include_once "scripts/main_script.php";
include_once "scripts/database_script.php";
include_once "scripts/profile_script.php";
include_once "scripts/goods_script.php";


session_start();

user_reg($connect);
user_login($connect);
buy_goods($connect);
ses_destroy();


include_once get_path_to_page();

?>