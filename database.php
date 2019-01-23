<?php
/**
 * Created by PhpStorm.
 * User: Lubin
 * Date: 22/01/2019
 * Time: 14:14
 */

$servername = "localhost";
$username = "id7331055_lubin";
$password = "exobase";
$dbname = "id7331055_nibul";

$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

} else {

    $conn->select_db($dbname);


}


$tout = "SELECT * FROM `user2` order by id DESC ";

$result = $conn->query($tout);

$data1 = $result ->fetch_assoc();

echo json_encode($data1);

