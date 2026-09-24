<?php
require_once "db_connexion.php";

$idNote = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);
if ($idNote === false || $idNote === null) {
    http_response_code(400);
    exit('Identifiant de note invalide.');
}

$suppression = $PDO->prepare('DELETE FROM note WHERE id_note = :id_note');
$suppression->execute(['id_note' => $idNote]);

header('Location: index.php');
exit;
