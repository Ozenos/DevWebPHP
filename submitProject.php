<?php
// Sécurité de base
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée');
}

// Récupération des données
$title = trim($_POST['title'] ?? '');

$errors = [];

// Validation du titre
if ($title === '') {
    $errors[] = "Le titre est obligatoire.";
}

// S’il y a des erreurs
if (!empty($errors)) {
    http_response_code(400);
    foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
    exit;
}

// Données valides → traitement (ex: base de données)
echo "<p style='color:green;'>Ticket créé avec succès</p>";
?>