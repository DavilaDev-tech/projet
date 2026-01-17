<?php

require 'auth.php';
restrictToAdmin(); // Bloque l'accès si l'utilisateur est un simple étudiant
require 'config/db.php';
include 'includes/header.php';
// Logique d'ajout
if (isset($_POST['ajouter'])) {
    $stmt = $pdo->prepare("INSERT INTO Etudiant (Nom, Prenom, Adresse, Classe) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['nom'], $_POST['prenom'], $_POST['adresse'], $_POST['classe']]);
}

$etudiants = $pdo->query("SELECT * FROM Etudiant")->fetchAll();
?>

<h2>Gestion des Étudiants</h2>
<form method="POST" class="row g-3 mb-4 shadow-sm p-3 bg-light rounded">
    <div class="col-md-3"><input type="text" name="nom" class="form-control" placeholder="Nom" required></div>
    <div class="col-md-3"><input type="text" name="prenom" class="form-control" placeholder="Prénom" required></div>
    <div class="col-md-2"><input type="text" name="classe" class="form-control" placeholder="Classe"></div>
    <div class="col-md-3"><input type="text" name="adresse" class="form-control" placeholder="Adresse"></div>
    <div class="col-md-1"><button type="submit" name="ajouter" class="btn btn-success w-100">Ajouter</button></div>
</form>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Classe</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($etudiants as $e): ?>
            <tr>
                <td><?= $e['CodeEtudiant'] ?></td>
                <td><?= $e['Nom'] ?></td>
                <td><?= $e['Prenom'] ?></td>
                <td><?= $e['Classe'] ?></td>
                <td>
                    <a href="modifier_etudiant.php?id=<?= $e['CodeEtudiant'] ?>" class="btn btn-sm btn-warning">Modifier</a>

                    <a href="supprimer.php?type=etudiant&id=<?= $e['CodeEtudiant'] ?>"
                        class="btn btn-sm btn-danger"
                        onclick="return confirm('Êtes-vous sûr ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php include 'includes/footer.php'; ?>