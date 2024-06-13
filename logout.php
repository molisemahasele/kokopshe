<?php
	session_start();
	session_unset($_SESSION['id']);
	$_SESSION['id'] = null;
	//session_destroy();
	header("Location: login.php");