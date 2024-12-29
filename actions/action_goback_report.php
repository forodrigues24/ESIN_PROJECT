<?php
session_start();



$_SESSION['report_clicked']=True;
header('Location: ../doutor.php');
