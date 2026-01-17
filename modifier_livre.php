<?php
require 'auth.php';
require 'config/db.php';
include 'includes/header.php';

// 1. Récupérer les informations actuelles du livre
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM Livre WHERE CodeLivre = ?");
    $stmt->execute([$_GET['id']]);
    $livre = $stmt->fetch();
}

// 2. Traiter la modification
if (isset($_POST['modifier_livre'])) {
    $id = $_POST['id'];
    $titre = $_POST['titre'];
    $auteur = $_POST['auteur'];
    $date = $_POST['date_edition'];
    $image_name = $_POST['ancienne_image']; // Par défaut, on garde l'ancienne

    // Vérifier si une nouvelle image a été téléchargée
    if (isset($_FILES['couverture']) && $_FILES['couverture']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['couverture']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($ext), $allowed) && $_FILES['couverture']['size'] < 2000000) {
            $image_name = time() . "_" . $filename;
            move_uploaded_file($_FILES['couverture']['tmp_name'], "uploads/" . $image_name);
            
            // Supprimer l'ancienne image du serveur pour gagner de la place (si ce n'est pas l'image par défaut)
            if ($_POST['ancienne_image'] != 'default.jpg' && file_exists("uploads/" . $_POST['ancienne_image'])) {
                unlink("uploads/" . $_POST['ancienne_image']);
            }
        }
    }

    $sql = "UPDATE Livre SET Titre=?, Auteur=?, DateEdition=?, Couverture=? WHERE CodeLivre=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$titre, $auteur, $date, $image_name, $id]);
    
    echo "<script>window.location.href='livres.php';</script>";
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-warning">Modifier le livre : <?= htmlspecialchars($livre['Titre']) ?></div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" class="row">
                    <input type="hidden" name="id" value="<?= $livre['CodeLivre'] ?>">
                    <input type="hidden" name="ancienne_image" value="<?= $livre['Couverture'] ?>">

                    <div class="col-md-8">
                        <div class="mb-3">
                            <label>Titre</label>
                            <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($livre['Titre']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Auteur</label>
                            <input type="text" name="auteur" class="form-control" value="<?= htmlspecialchars($livre['Auteur']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label>Date d'édition</label>
                            <input type="date" name="date_edition" class="form-control" value="<?= $livre['DateEdition'] ?>">
                        </div>
                        <div class="mb-3">
                            <label>Changer la couverture (laisser vide pour garder l'actuelle)</label>
                            <input type="file" name="couverture" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <label>Couverture actuelle</label>
                        <img src="uploads/<?= $livre['Couverture'] ?>" class="img-thumbnail mt-2" style="max-height: 250px;">
                    </div>

                    <div class="col-12 d-flex justify-content-between mt-4">
                        <a href="livres.php" class="btn btn-secondary">Retour</a>
                        <button type="submit" name="modifier_livre" class="btn btn-success">Mettre à jour le livre</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>