<!DOCTYPE html>
<html lang="fr">

<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Créer un sondage</title>
</head>

<body>

<header>
    <a href= "Mainpage.html"> <img src="logo.png" width="90"></a>
    <h1 id="txt1">GOGOLE FORMS</h1>
</header>

<br><br><br><br><br><br><br>

<form method="post" action="traitement.php" id="form-global">

    <!-- Nouveau champ pour le titre du sondage -->
    <label for="titre_sondage">Titre du sondage :</label>
    <input type="text" name="titre_sondage" id="titre_sondage" required>
    <br><br>

    <div id="zone-formulaires"></div>

    <button type="button" onclick="ajouterFormulaire()">Ajouter une question</button>

    <br><br>
    <button type="submit">Envoyer tout</button>

</form>

<script>
let compteurQuestion = 0;

function ajouterFormulaire() {

    const id = compteurQuestion;

    let div = document.createElement("div");
    div.className = "bloc-formulaire";
    div.id = "formulaire-" + id;

    div.innerHTML = `
        <h3>Question ${id + 1}</h3>

        <label>Question :</label>
        <input type="text" name="question[]" required><br><br>

        <button type="button" onclick="supprimerQuestion(this)">Supprimer La Question</button><br><br>

        <div id="reponses-${id}">
            <!-- Les réponses seront ajoutées ici -->
        </div>

        <button type="button" onclick="ajouterReponse(${id})">Ajouter une réponse</button>
        <br><br>
    `;

    document.getElementById("zone-formulaires").appendChild(div);

    compteurQuestion++;
}

function ajouterReponse(idQuestion) {

    let div = document.createElement("div");
    div.className = "bloc-reponse";

    div.innerHTML = `
        <label>Réponse :</label>
        <input type="text" name="reponse[${idQuestion}][]" required>
        <button type="button" onclick="supprimerReponse(this)">Supprimer</button>
        <br>
    `;

    document.getElementById("reponses-" + idQuestion).appendChild(div);
}

function supprimerQuestion(bouton) {
    bouton.parentElement.remove();
    compteurQuestion--;
}

function supprimerReponse(bouton) {
    bouton.parentElement.remove();
}

</script>

</body>
</html>
