<?php
$idProf = filter_input(INPUT_GET, 'id_prof', FILTER_VALIDATE_INT);
if ($idProf === false || $idProf === null) {
    header('Location: index.php');
    exit;
}

header('Location: filtre.php?id_prof=' . $idProf);
exit;
