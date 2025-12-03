<?php
// login_check.php
// Vérifie si l'utilisateur existe dans la base MySQL

// Paramètres de connexion à la base (à renseigner manuellement)
$host = 'localhost';
$db = 'gogoleform';
$user = 'root';
$pass = 'admin';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base']);
    exit;
}

// Récupère les données du formulaire (JSON)
$data = json_decode(file_get_contents('php://input'), true);
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

if (!$username || !$password) {
    http_response_code(400);
    echo json_encode(['error' => 'Données manquantes']);
    exit;
}

// Vérifie si l'utilisateur existe
$stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
$stmt->execute([$username, $password]);
$user = $stmt->fetch();

if ($user) {
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Utilisateur ou mot de passe incorrect']);
}
