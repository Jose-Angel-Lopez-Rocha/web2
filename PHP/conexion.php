<?php

$server="localhost";
$user="root";
$pass="";
$db="zapateria";
$puerto=4306;

$conexion=new mysqli($server,$user,$pass,$db,$puerto);

if($conexion->connect_errno){
    die("Conexion fallida" . $conexion->connect_errno);}
?>