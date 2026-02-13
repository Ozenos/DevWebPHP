<?php
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
}

header("location:listTicket.php");
?>