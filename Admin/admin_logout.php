<?php

include '../connect.php';

setcookie('admin_id', '', time() - 1, '/');

header("../Admin/login.php");


?>