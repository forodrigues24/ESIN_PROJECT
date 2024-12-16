<?php

session_start();
$msg = $_SESSION['msg'] ?? null;
unset($_SESSION['msg']);

?>