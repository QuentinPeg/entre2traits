<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/public/document/';
    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        echo '../document/' . basename($_FILES['file']['name']);
    } else {
        http_response_code(500);
        echo 'Erreur lors du téléchargement du fichier.';
    }
    exit;
}?>