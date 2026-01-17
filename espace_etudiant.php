<?php
require 'auth.php';
require 'config/db.php';
include 'includes/header.php';

$monNom = $_SESSION['username'];

// 1. Récupérer les livres empruntés par cet étudiant spécifiquement
// (On suppose que le NomUtilisateur correspond au Nom dans la table Etudiant)
$queryEmprunts = "SELECT L.Titre, Emp.DateEmprunt 
                  FROM Emprunter Emp
                  JOIN Livre L ON Emp.CodeLivre = L.CodeLivre
                  JOIN Etudiant E ON Emp.CodeEtudiant = E.CodeEtudiant
                  WHERE E.Nom = ?";
$stmt = $pdo->prepare($queryEmprunts);
$stmt->execute([$monNom]);
$mesLivres = $stmt->fetchAll();
?>

<h3>Espace Etudiant</h3>
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <h5>Mes Emprunts</h5>
                <h2><?= count($mesLivres) ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h4>Mes livres actuellement en main</h4>
    <table class="table border">
        <thead>
            <tr><th>Titre du livre</th><th>Date d'emprunt</th></tr>
        </thead>
        <tbody>
            <?php foreach($mesLivres as $ml): ?>
            <tr>
                <td><?= htmlspecialchars($ml['Titre']) ?></td>
                <td><?= $ml['DateEmprunt'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'includes/footer.php'; ?>