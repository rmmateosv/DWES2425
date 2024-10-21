<?php
require_once 'Modelo.php';
session_start();
//Si no hay sessión iniciada, redirigimos a login
if(!isset($_SESSION['usuario'])){
    header('location:login.php');
}
?>