<?php
require 'auth.php';
require 'config/db.php';

if (isset($_GET['id_etudiant']) && isset($_GET['id_livre'])) {
    $codeEtudiant = $_GET['id_etudiant'];
    $codeLivre = $_GET['id_livre'];

    // On supprime la ligne dans la table Emprunter pour libérer le livre
    $stmt = $pdo->prepare("DELETE FROM Emprunter WHERE CodeEtudiant = ? AND CodeLivre = ?");
    $stmt->execute([$codeEtudiant, $codeLivre]);

    header("Location: index.php?msg=Livre rendu et disponible");
    exit();
} else {
    header("Location: index.php");
    exit();
}