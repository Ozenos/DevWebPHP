<?php
$_errorTitle = false;
$_errorTime = false;

// DANS LE CAS OU UNE ID EST FOURNIE, MODE EDITION
if (isset($_GET["id"])) {
  // connexion BDD
  $dsn = "mysql:host=localhost:3306;dbname=cross_tickets_db;charset=utf8mb4";
  $user = "root";
  $password = "root";

  try {
    $pdo = new PDO($dsn, $user, $password, [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
  } catch (PDOException $e) {
    die("Erreur connexion : " . $e->getMessage());
  }

  // Récupération des données
  $sql = "SELECT * FROM tickets WHERE id=:id";
  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    ":id" => $_GET["id"],
  ]);

  $ticket = $stmt->fetch();

  // on gère le traitement du formulaire
  if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sécurité de base
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      http_response_code(405);
      exit('Méthode non autorisée');
    }

    // Récupération des données
    $title = trim($_POST['title'] ?? '');
    $time = $_POST['time'] ?? '';

    $errors = [];

    // Validation du titre
    if ($title === '') {
      $errors[] = "Le titre est obligatoire.";
      $_errorTitle = true;
    }

    // Validation du temps estimé
    if ($time === '') {
      $errors[] = "Le temps estimé est obligatoire.";
      $_errorTime = true;
    } else if (!filter_var($time, FILTER_VALIDATE_INT) || (int) $time <= 0) {
      $errors[] = "Le temps estimé doit être un nombre entier positif.";
      $_errorTime = true;
    }

    if (!empty($errors)) {  // S’il y a des erreurs
      http_response_code(400);/*
      foreach ($errors as $error) {
        echo "<p style='color:red;'>$error</p>";
      }*/
    } else {  // Données valides → traitement
      $sql = "UPDATE tickets SET title=:title, time=:time, advancement=:advancement, facturation=:facturation, owner=:owner WHERE id=:id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute([
        ":id" => $_POST["id"],
        ":title" => $_POST["title"],
        ":time" => $_POST["time"],
        ":advancement" => $_POST["advancement"],
        ":facturation" => $_POST["facturation"],
        ":owner" => $_POST["owner"]
      ]);
      header("location:listTicket.php");
    }
  }
}

// DANS LE CAS OU AUCUNE ID N'EST FOURNIE, MODE CREATION
else if (isset($_POST["title"])) {
  // Sécurité de base
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Méthode non autorisée');
  }

  // Récupération des données
  $title = trim($_POST['title'] ?? '');
  $time = $_POST['time'] ?? '';

  $errors = [];

  // Validation du titre
  if ($title === '') {
    $errors[] = "Le titre est obligatoire.";
    $_errorTitle = true;
  }

  // Validation du temps estimé
  if ($time === '') {
    $errors[] = "Le temps estimé est obligatoire.";
    $_errorTime = true;
  } elseif (!filter_var($time, FILTER_VALIDATE_INT) || (int) $time <= 0) {
    $errors[] = "Le temps estimé doit être un nombre entier positif.";
    $_errorTime = true;
  }

  if (!empty($errors)) {  // S’il y a des erreurs
    http_response_code(400);/*
    foreach ($errors as $error) {
      echo "<p style='color:red;'>$error</p>";
    }*/
  } else {  // Données valides → traitement
    echo "<p style='color:green;'>Ticket créé avec succès</p>";

    $dsn = "mysql:host=localhost:3306;dbname=cross_tickets_db;charset=utf8mb4";
    $user = "root";
    $password = "root";

    try {
      $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);
    } catch (PDOException $e) {
      die("Erreur connexion : " . $e->getMessage());
    }

    // on gère le traitement du formulaire
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $sql = "INSERT INTO tickets (title, time, advancement, facturation, owner) VALUES (:title, :time, :advancement, :facturation, :owner)";
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo->prepare($sql);

      try {
        $stmt->execute([
          ":title" => $_POST["title"],
          ":time" => $_POST["time"],
          ":advancement" => $_POST["advancement"],
          ":facturation" => $_POST["facturation"],
          ":owner" => $_POST["owner"]
        ]);
      } catch (PDOException $e) {
        echo $e->getMessage();
      }

      header("location:listTicket.php");
    }
  }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#1c1917',   //stone-900
            secondary: '#f3f4f6', //gray-100
            tertiary: '#e5e7eb',  //gray-200
            accent: '#57534e',    //stone-600
            background: '#FFFFFF',
            text: '#030712',      //gray-950
            footertext: "#a8a29e" //stone-400
          },
        },
      },
    };
  </script>
  <script src="newTicket.js" defer></script>
  <title>Cross Tickets - Nouveau ticket</title>
  <link rel="shortcut icon" href="Ticket.jpg" />
</head>

<body class="min-h-screen bg-tertiary flex items-center justify-center">

  <div class="w-full max-w-2xl bg-background rounded-xl shadow-lg p-8">
    <h1 class="text-2xl font-bold mb-6 text-text">
      Création d’un ticket
    </h1>

    <form class="space-y-1" id="submitform" action="" method="POST">
      <input type="hidden" name="id" value="<?= $ticket["id"] ?>">

      <!-- Titre -->
      <div>
        <label class="block text-sm font-medium text-accent mb-1">
          Titre *
        </label>
        <input type="text" id="title" placeholder="Ex : Dysfonctionnement de l’export PDF" name="title"
          value="<?= $ticket["title"] ?>"
          class="w-full rounded-lg bg-secondary px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p id="title_error"
          class="<?= ($_errorTitle) ? "" : "invisible"; ?> inline-block text-sm font-medium text-red-600 rounded-md border border-red-300 bg-red-200 mt-1 ml-2 py-1 px-2">
          Veuillez inclure un titre</p>
      </div>

      <!-- Statut et Type -->
      <div class="flex">
        <!-- Statut -->
        <div class="w-1/4 mb-2">
          <label class="block text-sm font-medium text-accent mb-1">
            Statut
          </label>
          <select name="advancement"
            class="rounded-lg bg-secondary px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="En cours" <?= ($ticket["advancement"] === "En cours") ? "selected" : "" ?>>
              En cours</option>
            <option value="Ouvert" <?= ($ticket["advancement"] === "Ouvert") ? "selected" : "" ?>>
              Ouvert</option>
            <option value="Terminé" <?= ($ticket["advancement"] === "Terminé") ? "selected" : "" ?>>
              Terminé</option>
          </select>
        </div>

        <!-- Type -->
        <div class="w-1/4 mb-2">
          <label class="block text-sm font-medium text-accent mb-1">
            Type
          </label>
          <select name="facturation"
            class="rounded-lg bg-secondary px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="Inclus" <?= ($ticket["facturation"] === "Inclus") ? "selected" : "" ?>>
              Inclus</option>
            <option value="Facturable" <?= ($ticket["facturation"] === "Facturable") ? "selected" : "" ?>>
              Facturable</option>
          </select>
        </div>
      </div>

      <!-- Description -->
      <div>
        <label class="block text-sm font-medium text-accent mb-1">
          Description
        </label>
        <textarea rows="4" placeholder="Décrivez le problème rencontré…" value="<?= $ticket["description"] ?>"
          class="w-full rounded-lg bg-secondary px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <!-- Temps estimé -->
      <div>
        <label class="block text-sm font-medium text-accent mb-1">
          Temps estimé (en heures) *
        </label>
        <input type="number" id="time" min="1" step="1" placeholder="1" name="time" value="<?= $ticket["time"] ?>"
          class="w-full rounded-lg bg-secondary px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p id="time_error"
          class="<?= ($_errorTime) ? "" : "invisible"; ?> inline-block text-sm font-medium text-red-600 rounded-md border border-red-300 bg-red-200 mt-1 ml-2 py-1 px-2">
          Veuillez inclure une estimation de temps en heures entières</p>
      </div>

      <!-- Collaborateurs -->
      <div>
        <label class="block text-sm font-medium text-accent mb-1">
          Collaborateurs
        </label>
        <input type="text" name="owner" placeholder="Ex : Alice Martin, Lucas Bernard" value="<?= $ticket["owner"] ?>"
          class="w-full rounded-lg bg-secondary px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <p class="text-xs text-accent mt-1">
          Séparer les noms par des virgules
        </p>
      </div>

      <!-- Bouton -->
      <div class="flex flex-col items-center">
        <p id="success"
          class="invisible inline-block text-md font-medium text-lime-700 rounded-md border border-lime-300 mb-2 bg-lime-200 py-1 px-2">
          Ticket généré</p>
        <p class="inline-block text-md font-medium text-text py-1 px-2">
          * : champs obligatoires</p>
        <button type="submit"
          class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-accent transition">
          Générer le ticket
        </button>
      </div>

    </form>
  </div>

</body>

</html>