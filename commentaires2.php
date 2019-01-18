<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 18/01/2019
 * Time: 15:10
 */

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "espace_commentaires";

$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

} else {

    $conn->select_db($dbname);


}

function afficheCom2()
{

    global $conn;

    $tout = "SELECT * FROM `user` ORDER BY `id` DESC LIMIT 5, 20 ";

    $result = $conn->query($tout);

    echo '<div>';

    while ($row = $result->fetch_assoc()) {

        echo "<p class = 'encart'>" .$row['nom']. " " .  $row['prenom']." le ". $row['date']."</p>";
        echo "<p>" .$row['commentaire']. "</p>";
    }
    echo '</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Espaces Commentaires</h1>

<div class ="affichage">

<?=afficheCom2();?>

    <a href="Commentaires.php">Retour</a>
</div>

</body>
</html>