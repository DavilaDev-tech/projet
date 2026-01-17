<?php
// On vérifie si une session est déjà lancée, sinon on la démarre
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    /* On crée une classe qui utilise les variables de couleur Bootstrap */
.hover-yellow:hover {
    background-color: #ffc107; 
    color: #000; 
    transition: 0.3s;
    cursor: pointer;
}
</style>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg  mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Bibliothèque</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link hover-yellow" href="index.php">Emprunts</a></li>         
                <li class="nav-item"><a class="nav-link hover-yellow" href="etudiants.php">Étudiants</a></li>
                <li class="nav-item"><a class="nav-link hover-yellow" href="livres.php">Livres</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">