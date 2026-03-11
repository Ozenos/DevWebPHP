<?php
function getTicketUsers(PDO $pdo, int $ticketID): array {

    // 1. Récupérer l'owner du ticket
    $stmt = $pdo->prepare("SELECT owner FROM tickets WHERE ID = ?");
    $stmt->execute([$ticketID]);
    $ownerID = $stmt->fetchColumn();

    // 2. Récupérer les utilisateurs liés dans la table relation
    $stmt = $pdo->prepare("SELECT userID FROM tickets_collaborators WHERE ticketID = ?");
    $stmt->execute([$ticketID]);
    $linkedUsers = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. Fusionner les IDs
    $userIDs = $linkedUsers;
    if ($ownerID) {
        $userIDs[] = $ownerID;
    }

    // Supprimer les doublons
    $userIDs = array_unique($userIDs);

    if (empty($userIDs)) {
        return [];
    }

    // 4. Récupérer les usernames
    $placeholders = implode(',', array_fill(0, count($userIDs), '?'));
    $stmt = $pdo->prepare("SELECT username FROM users WHERE ID IN ($placeholders)");
    $stmt->execute($userIDs);

    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>