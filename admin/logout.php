<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

unset($_SESSION['user_id']);

redirect_to('login.php');

?>