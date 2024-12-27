<?php

include_once('template/message_tpl.php');

include_once('template/header_tpl.php');
renderHeader('loginpage');

include_once('template/content_login_register_edit_tpl.php');
login();

include_once('template/footer_tpl.php');

?>