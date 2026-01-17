<?php
require 'auth.php';
require 'config/db.php';

if (isset($_GET['idL']) && isset($_GET['idE'])) {
    $stmt = $pdo->prepare("DELETE FROM Emprunter WHERE CodeLivre = ? AND CodeEtudiant = ?");
    $stmt->execute([$_GET['idL'], $_GET['idE']]);
}

header("Location: index.php");
exit();