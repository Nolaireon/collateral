<?php
session_name('webtest');
session_start();
$_SESSION['user'] = array('id'=>3, 'name'=>'denis');
echo $_SESSION['user']['id']." = ".$_SESSION['user']['name'];
?>