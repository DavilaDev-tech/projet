<?php
require 'auth.php';
require 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codeEtudiant = $_POST['code_etudiant'];
    $codeLivre = $_POST['code_livre'];
    $dateEmprunt = date('Y-m-d');

    // VERIFICATION : Est-ce que le livre est déjà emprunté ?
    $check = $pdo->prepare("SELECT COUNT(*) FROM Emprunter WHERE CodeLivre = ?");
    $check->execute([$codeLivre]);
    
    if ($check->fetchColumn() > 0) {
        // Le livre est déjà pris, on renvoie une erreur
        header("Location: index.php?error=Ce livre est déjà en cours d'emprunt");
    } else {
        // Le livre est libre, on procède à l'insertion
        $stmt = $pdo->prepare("INSERT INTO Emprunter (CodeEtudiant, CodeLivre, DateEmprunt) VALUES (?, ?, ?)");
        $stmt->execute([$codeEtudiant, $codeLivre, $dateEmprunt]);
        header("Location: index.php?msg=Emprunt enregistré avec succès");
    }
    exit();
}