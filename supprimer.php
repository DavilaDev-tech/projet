<?php
require 'auth.php';
require 'config/db.php';

// Suppression d'un Étudiant
if (isset($_GET['type']) && $_GET['type'] == 'etudiant' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM Etudiant WHERE CodeEtudiant = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: etudiants.php?msg=Etudiant supprimé");
}

// Suppression d'un Livre
if (isset($_GET['type']) && $_GET['type'] == 'livre' && isset($_GET['id'])) {
    // Optionnel : Supprimer aussi le fichier image sur le serveur
    $stmtImg = $pdo->prepare("SELECT Couverture FROM Livre WHERE CodeLivre = ?");
    $stmtImg->execute([$_GET['id']]);
    $livre = $stmtImg->fetch();
    
    if ($livre && $livre['Couverture'] != 'default.jpg') {
        unlink("uploads/" . $livre['Couverture']); // Supprime le fichier physique
    }

    $stmt = $pdo->prepare("DELETE FROM Livre WHERE CodeLivre = ?");
    $stmt->execute([$_GET['id']]);
    header("Location: livres.php?msg=Livre supprimé");
}
exit();