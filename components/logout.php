<?php

include 'config.php';

setcookie('user_id', '', time() - 1, '/');
setcookie('chef_id', '', time() - 1, '/');

header('location:../index.php');

?>