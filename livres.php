<?php
require 'auth.php'; // Protection de la page
require 'config/db.php';
include 'includes/header.php';
restrictToAdmin(); // Bloque l'accès si l'utilisateur est un simple étudiant

if (isset($_POST['ajouter_livre'])) {
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date = $_POST['date_edition'];
    $image_name = 'default.jpg';

    // Gestion du fichier
    if (isset($_FILES['couverture']) && $_FILES['couverture']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['couverture']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (in_array(strtolower($ext), $allowed) && $_FILES['couverture']['size'] < 2000000) {
            $image_name = time() . "_" . $filename;
            move_uploaded_file($_FILES['couverture']['tmp_name'], "uploads/" . $image_name);
        }
    }

    $stmt = $pdo->prepare("INSERT INTO Livre (Titre, Auteur, DateEdition, Couverture) VALUES (?, ?, ?, ?)");
    $stmt->execute([$titre, $auteur, $date, $image_name]);
}

$livres = $pdo->query("SELECT * FROM Livre")->fetchAll();
?>

<h2>Gestion des Livres</h2>
<form method="POST" enctype="multipart/form-data" class="row g-3 mb-4 p-3 bg-white border">
    <div class="col-md-3"><input type="text" name="titre" class="form-control" placeholder="Titre" required></div>
    <div class="col-md-2"><input type="text" name="auteur" class="form-control" placeholder="Auteur" required></div>
    <div class="col-md-2"><input type="date" name="date_edition" class="form-control"></div>
    <div class="col-md-3"><input type="file" name="couverture" class="form-control"></div>
    <div class="col-md-2"><button type="submit" name="ajouter_livre" class="btn btn-primary w-100">Ajouter</button></div>
</form>

<div class="row">
    <?php foreach ($livres as $l): ?>
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="uploads/<?= $l['Couverture'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h6><?= htmlspecialchars($l['Titre']) ?></h6>
                    <p class="small"><?= htmlspecialchars($l['Auteur']) ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<a href="supprimer.php?type=livre&id=<?= $l['CodeLivre'] ?>"
    class="btn btn-sm btn-outline-danger w-100 mt-2"
    onclick="return confirm('Supprimer ce livre ?')">Supprimer</a>
<a href="modifier_livre.php?id=<?= $l['CodeLivre'] ?>" class="btn btn-sm btn-warning">Modifier</a>
<?php include 'includes/footer.php'; ?>