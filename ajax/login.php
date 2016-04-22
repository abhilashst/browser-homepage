<?php
include_once '../coreSettings.php';
include_once BASE_PATH.'/main/user-class.php';

$user = new sh_user();

$result = $user->_login_action();

echo $result;

?>