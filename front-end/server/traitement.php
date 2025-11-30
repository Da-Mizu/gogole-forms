<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = 'gogoleform';
$user = 'root';
$pass = 'admin';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupération du titre du sondage
    $titre_sondage = $_POST['titre_sondage'];

    // Insérer le titre du sondage dans la table `sondage`
    $stmtSondage = $pdo->prepare("INSERT INTO sondage (titre) VALUES (:titre)");
    $stmtSondage->execute([':titre' => $titre_sondage]);

    // Récupérer l'ID du sondage qui vient d'être inséré
    $id_sondage = $pdo->lastInsertId();

    // Vérification qu'il y a bien des questions
    if (isset($_POST['question']) && is_array($_POST['question'])) {
        foreach ($_POST['question'] as $key => $question) {

            // Insérer la question dans la table `questions`
            $stmtQuestion = $pdo->prepare("INSERT INTO questions (intitule, id_sondage) VALUES (:intitule, :id_sondage)");
            $stmtQuestion->execute([
                ':intitule' => $question,
                ':id_sondage' => $id_sondage
            ]);

            // Récupérer l'ID de la question insérée
            $id_question = $pdo->lastInsertId();

            // Vérification des réponses de la question
            if (isset($_POST['reponse'][$key]) && is_array($_POST['reponse'][$key])) {
                foreach ($_POST['reponse'][$key] as $reponse) {

                    // Insérer les propositions dans la table `propositions`
                    $stmtPropositions = $pdo->prepare("INSERT INTO propositions (id_question, proposition) VALUES (:id_question, :proposition)");
                    $stmtPropositions->execute([
                        ':id_question' => $id_question,
                        ':proposition' => $reponse
                    ]);
                }
            }
        }

        // Message de confirmation
        echo "<p>Le sondage a été créé avec succès !</p>";

        // Bouton de retour
        echo '<p><a href="CreatePage.php"><button>Créer un autre sondage</button></a></p>';
        echo '<p><a href="MainPage.html"><button>Retour à la page d\'accueil</button></a></p>';
    } else {
        echo "<p>Erreur : aucune question n'a été ajoutée.</p>";
    }
}
?>
