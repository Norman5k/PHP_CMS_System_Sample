<?php 

if((!isset($_POST['log'])) || ($_POST['log'] === 'auth')) {
    include_once "content/auth_form.php";
} elseif($_POST['log'] === 'reg') {
    include_once "content/reg_form.php";
}

?>