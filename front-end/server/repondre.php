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

// Ici on suppose qu'un utilisateur existe avec hash = 1 (admin), tu peux adapter pour un vrai système de login
$hash_utilisateur = 1;

// Si le formulaire est soumis
if (isset($_POST['reponse']) && isset($_POST['id_sondage'])) {
    $id_sondage = $_POST['id_sondage'];

    foreach ($_POST['reponse'] as $id_question => $valeur) {
        $stmt = $pdo->prepare("INSERT INTO reponses (valeur, id_question, hash) VALUES (:valeur, :id_question, :hash)");
        $stmt->execute([
            ':valeur' => $valeur,
            ':id_question' => $id_question,
            ':hash' => $hash_utilisateur
        ]);
    }
    echo "<p>Merci, vos réponses ont été enregistrées !</p>";
}

// Lecture de l'id_sondage depuis l'URL
if (isset($_GET['id_sondage'])) {
    $id_sondage = $_GET['id_sondage'];

    // Récupération du sondage
    $stmtS = $pdo->prepare("SELECT * FROM sondage WHERE id_sondage = :id_sondage");
    $stmtS->execute([':id_sondage' => $id_sondage]);
    $sondage = $stmtS->fetch(PDO::FETCH_ASSOC);

    if ($sondage) {
        echo "<h1>".htmlspecialchars($sondage['titre'])."</h1>";

        $stmtQ = $pdo->prepare("SELECT * FROM questions WHERE id_sondage = :id_sondage");
        $stmtQ->execute([':id_sondage' => $id_sondage]);
        $questions = $stmtQ->fetchAll(PDO::FETCH_ASSOC);

        if ($questions) {
            echo '<form method="post">';
            echo '<input type="hidden" name="id_sondage" value="'.$id_sondage.'">';

            foreach ($questions as $q) {
                echo '<h3>' . htmlspecialchars($q['intitule']) . '</h3>';

                $stmtP = $pdo->prepare("SELECT proposition FROM propositions WHERE id_question = :id_question");
                $stmtP->execute([':id_question' => $q['id_question']]);
                $propositions = $stmtP->fetchAll(PDO::FETCH_ASSOC);

                foreach ($propositions as $p) {
                    $val = htmlspecialchars($p['proposition']);
                    echo '<label><input type="radio" name="reponse['.$q['id_question'].']" value="'.$val.'" required> '.$val.'</label><br>';
                }
            }

            echo '<br><button type="submit">Envoyer mes réponses</button>';
            echo '</form>';
        } else {
            echo "<p>Aucune question pour ce sondage.</p>";
        }

    } else {
        echo "<p>Sondage introuvable.</p>";
    }

} else {
    // Liste des sondages disponibles si aucun id_sondage n'est donné
    $stmt = $pdo->query("SELECT * FROM sondage ORDER BY id_sondage DESC");
    $sondages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<h1>Choisissez un sondage :</h1>";
    foreach ($sondages as $s) {
        echo '<p><a href="repondre.php?id_sondage='.$s['id_sondage'].'">'.htmlspecialchars($s['titre']).'</a></p>';
    }
}
?>
