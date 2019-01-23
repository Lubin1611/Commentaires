<?php
/**
 * Created by PhpStorm.
 * User: Administrateur
 * Date: 17/01/2019
 * Time: 14:33
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


if(isset($_SESSION['login']) and isset($_SESSION['pwd'])) {
    comModo();
} 


$query = "SELECT COUNT(id) as nbMessage FROM `user2`";

$resultatM = $conn->query($query);

$data = $resultatM->fetch_assoc();

$total = $data['nbMessage'];

$parPage = 4;
$nbPage = ceil($total / $parPage);
$pageCourante = 1;


$login_valide = (isset($_POST['username']) ? $_POST['username'] : NULL);
$pwd = (isset($_POST['mdp']) ? $_POST['mdp'] : NULL);


$pwd = sha1($pwd);


$req = "SELECT * FROM `moderation` WHERE '$login_valide' = username and '$pwd' = password";
$sql = $conn->query($req);
$row = $sql->fetch_assoc();

$login_valide = $row['username'];
$pwd = $row['password'];


///print_r($total);


$ajoutEl = "INSERT INTO `user2` (`nom`, `prenom`, `commentaire`, `date`) VALUES (?, ?, ?, NOW())";


if (isset($_POST['nom']) and isset($_POST['prenom']) and isset($_POST['commentaires'])) {

    $recup1 = $_POST['nom'];
    $recup2 = $_POST['prenom'];
    $recup3 = $_POST['commentaires'];


    $connection = $conn->prepare($ajoutEl);

    $connection->bind_param('sss', $recup1, $recup2, $recup3);

    $connection->execute();


    $connection->close();



}



function comModo()
{

    global $parPage;
    global $conn;
    global $pageCourante;
    global $nbPage;
    global $login_valide;
    global $pwd;




    $tout = "SELECT * FROM `user2` ORDER BY `id` DESC LIMIT " . (($pageCourante - 1) * $parPage) . ", $parPage";

    $result = $conn->query($tout);

    echo '<div>';

    while ($row = $result->fetch_assoc()) {
        $suppr = $row['id'];

        echo "<p id = 'encart'>" . $row['nom'] . " " . $row['prenom'] . " le " . $row['date'] . '"<a href ="delete.php?id=' . $suppr . '">Supprimer</a>"</p>"';
        echo "<p id = 'encart2'>" . $row['commentaire'] . "</p>";
    }
    echo '</div>';

    if (isset($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $nbPage) {

        $pageCourante = $_GET['page'];

    } else {

        $pageCourante = 1;
    }


    for ($i = 1; $i <= $nbPage; $i++) {

        if ($i == $pageCourante) {

            echo "<span class = 'styleIndex' id = 'message'>" . $i . "</span>";

        } else {

            echo "<a href=\"Commentaires.php?page=$i\" id = 'message'>$i</a>";

        }

    }


}


function com()
{
    global $parPage;
    global $conn;
    global $pageCourante;
    global $nbPage;
    global $login_valide;
    global $pwd;


    $tout = "SELECT * FROM `user2` ORDER BY `id` DESC LIMIT " . (($pageCourante - 1) * $parPage) . ", $parPage";

    $result = $conn->query($tout);

    echo '<div>';

    while ($row = $result->fetch_assoc()) {

        echo "<p id = 'encart'>" . $row['nom'] . " " . $row['prenom'] . " le " . $row['date'] . "</p>";
        echo "<p id = 'encart2'>" . $row['commentaire'] . "</p>";
    }
    echo '</div>';


    if (isset($_GET['page']) and $_GET['page'] > 0 and $_GET['page'] <= $nbPage) {

        $pageCourante = $_GET['page'];

    } else {

        $pageCourante = 1;
    }


    for ($i = 1; $i <= $nbPage; $i++) {

        if ($i == $pageCourante) {

            echo "<span class = 'styleIndex' id = 'message'>" . $i . "</span>";

        } else {

            echo "<a href=\"Commentaires.php?page=$i\" id = 'message'>$i</a>";

        }

    }

}

function modooupas()
{

    global $login_valide;
    global $pwd;


    if (isset($_POST['username']) and isset($_POST['mdp'])) {
        if ($login_valide == $_POST['username'] && $pwd == sha1($_POST['mdp'])) {
            
            session_start();

        $_SESSION['login'] = $_POST['username'];
        $_SESSION['pwd'] = $_POST['mdp'];
        
        
        
        
        
        
        
        

            comModo();

        }
    }

    else {

        com();
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
    <label>Votre Nom : </label><input type="text" name="nom" id="nom">
    <label>Votre Prenom : </label><input type="text" name="prenom" id="prenom"><br><br>
    <label>Commentaire : </label><textarea name="commentaires" id="comment"></textarea><br><br>
    <input type="submit" value="Envoyez" id="message">

</form>

<div id='espacemod'>

    <h2>Espace Moderation</h2>

    <form action="" method="post">
        <label>Nom d'utilisateur</label><input type="text" name="username" id="username">
        <label>Mot de passe</label><input type="password" name="mdp" id="mdp">
        <input type="submit" value="Envoyez">
    </form>
</div>


<div class="affichage">

    <?= modooupas(); ?>


</div>
<script src="ajax.js"></script>
</body>
</html>