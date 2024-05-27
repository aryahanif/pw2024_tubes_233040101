<?php 
$server = "localhost";
$username = "root";
$password = "";
$name_db = "pw2024_tubes_233040101";

$koneksi = mysqli_connect($server,$username,$password,$name_db);

if(!$koneksi){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>