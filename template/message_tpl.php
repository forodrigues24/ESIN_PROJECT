<?php

session_start();
$msg = $_SESSION['msg'] ?? null;
$msg2 = $_SESSION['msg2'] ?? null;

unset($_SESSION['msg']);
unset($_SESSION['msg2']);


?>