<?php

session_start();
require_once('../php/conn.php');
$pdo = conectarBaseDeDatos();
session_destroy();
header("location: ../pages/login.php");
