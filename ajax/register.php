<?php
include_once '../coreSettings.php';
include_once BASE_PATH.'/main/user-class.php';

$user = new sh_user();

if( $user->_authenticate() ){
	
echo "You are already logined.";

}else{

$result = $user->_register_action();

echo $result;

}

?>