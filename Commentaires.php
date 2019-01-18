<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 17/01/2019
 * Time: 14:33
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


$ajoutEl = "INSERT INTO `user` (`nom`, `prenom`, `commentaire`, `date`) VALUES (?, ?, ?, NOW())";


if (isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['commentaires'])) {

    $recup1 = $_POST['nom'];
    $recup2 = $_POST['prenom'];
    $recup3 = $_POST['commentaires'];


    $connection = $conn->prepare($ajoutEl);

    $connection->bind_param('sss', $recup1, $recup2, $recup3);

    $connection->execute();


    $connection->close();

    header("Location:Commentaires.php");

}

function afficheCom()
{

    global $conn;

    $tout = "SELECT * FROM `user` ORDER BY `id` DESC LIMIT 0, 5";

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


<form action="" method="post">
    <label>Votre Nom : </label><input type="text" name="nom">
    <label>Votre Prenom : </label><input type="text" name="prenom"><br><br>
    <label>Commentaire : </label><textarea name="commentaires"></textarea><br><br>
    <input type="submit" value="Envoyez">
</form>

<div class ="affichage">

    <?=afficheCom();?>
    <a href="commentaires2.php">Suivant</a>
</div>

</body>
</html>