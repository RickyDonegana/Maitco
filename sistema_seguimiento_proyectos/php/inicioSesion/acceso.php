<?php
include('../php/conn.php');

session_start();
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
} else {
    header('Location: ../pages/login.php');
    die();
}