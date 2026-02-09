<?php
// Sécurité de base
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée');
}

// Récupération des données
$title = trim($_POST['title'] ?? '');
$time  = $_POST['time'] ?? '';

$errors = [];

// Validation du titre
if ($title === '') {
    $errors[] = "Le titre est obligatoire.";
}

// Validation du temps estimé
if ($time === '') {
    $errors[] = "Le temps estimé est obligatoire.";
} elseif (!filter_var($time, FILTER_VALIDATE_INT) || (int)$time <= 0) {
    $errors[] = "Le temps estimé doit être un nombre entier positif.";
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
