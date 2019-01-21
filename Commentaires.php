<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 17/01/2019
 * Time: 14:33
 */

$servername = "localhost";
$username = "id7331055_lubin";
$password = "########";
$dbname = "id7331055_nibul";

$conn = new mysqli($servername, $username, $password);


if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

} else {

    $conn->select_db($dbname);


}

$query = "SELECT COUNT(id) as nbMessage FROM `user2`";

$resultatM = $conn->query($query);

$data = $resultatM->fetch_assoc();

$total = $data['nbMessage'];

///print_r($total);



$parPage = 4;
$nbPage = ceil($total / $parPage);
$pageCourante = 1;



$ajoutEl = "INSERT INTO `user2` (`nom`, `prenom`, `commentaire`, `date`) VALUES (?, ?, ?, NOW())";


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
    global $parPage;
    global $conn;
    global $pageCourante;
    global $nbPage;

    if(isset($_GET['page']) and $_GET['page']>0 and $_GET['page']<= $nbPage ) {

        $pageCourante = $_GET['page'];

    } else {

        $pageCourante = 1;
    }

    $tout = "SELECT * FROM `user2` ORDER BY `id` DESC LIMIT " . (($pageCourante - 1) * $parPage) . ", $parPage";

    $result = $conn->query($tout);

    echo '<div>';

    while ($row = $result->fetch_assoc()) {

        echo "<p class = 'encart'>" . $row['nom'] . " " . $row['prenom'] . " le " . $row['date'] . "</p>";
        echo "<p class = 'encart2'>" . $row['commentaire'] . "</p>";
    }
    echo '</div>';

    for ($i = 1; $i <= $nbPage; $i++) {

        if ($i == $pageCourante) {

            echo "<span id = 'styleIndex'>" .$i. "</span>";

        } else {

            echo "<a href=\"Commentaires.php?page=$i\">$i</a>";

        }

    }

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

<div class="affichage">

    <?= afficheCom(); ?>

</div>

</body>
</html>