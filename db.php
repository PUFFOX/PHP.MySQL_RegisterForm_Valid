<?php
// $conn = new mysqli ("localhost","root","");
//if ($conn->connect_error)
//{
//     echo "Connection error";
//     die();
// } else {
//     echo "Connection successfull";
// };
// $myquery = "CREATE DATABASE HW0206DB";
// if ($conn->query($myquery)) {
//     echo "Database HW0206DB was created<br>";
//
// } else
// {
//     echo "Error - database HW0206DB wasn't created: $conn->error<br>";
// }
//// $conn->close();

$conn = new mysqli ("localhost","root","","HW0206DB");
if ($conn->connect_error)
{
echo "Connection error";
die();
};
echo "Connection successfull<br>";

$createTableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(50) NOT NULL,
    surname VARCHAR(50) NOT NULL,
    country VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL
)";

if (!$conn->query($createTableQuery))
{
    echo "Datatable wasn't created: $conn->error<br>";
    die();
 };
 echo "Datatable was created<br>";


//$myquery = "INSERT INTO `users`(`login`, `password`, `name`, `surname`, `country`,`city`) VALUES
//     ('Alex',123456789,'James','Smit', 'USA','California')";
//
// if (!$conn->query($myquery)) {
//     echo "Data wasn't inserted: $conn->error<br>";
//     die();};
// echo "Data was inserted<br>";

$conn->close();
?>