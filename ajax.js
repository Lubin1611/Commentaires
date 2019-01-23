

    function ajaxRequest()
{
    var xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function() {

        if (this.readyState == 4 && this.status == 200) {

            //document.getElementById('dataUpdate').innerHTML = this.responseText;
            var obj = JSON.parse(this.responseText);
            console.log(obj.id + "" + obj.nom + " " + obj.prenom + " " + obj.commentaire + " " + obj.date);
            document.getElementById("encart").innerHTML = obj.nom + " " + obj.prenom + obj.date;
            document.getElementById("encart2").innerHTML = obj.commentaire;
        }

    };

    xhttp.open("GET", "database.php", true);

    xhttp.send();


}

document.getElementById('message').addEventListener('click', function () {
       ajaxRequest();
});