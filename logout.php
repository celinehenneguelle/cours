<?php


require_once("pdo.php");
session_start();
session_destroy();
header("Location: index.php");
