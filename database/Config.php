<?php 
$server = "localhost";
$user = "root";
$pass = "";
$database = "bookshelf";

$Conn = mysqli_connect($server, $user, $pass, $database);

if (!$Conn)
{
    die("<script>alert('Connection Failed.')</script>");
}
?>