<?php
require 'auth.php';
require 'config/db.php';
include 'includes/header.php';

// 1. Récupérer les infos de l'étudiant
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM Etudiant WHERE CodeEtudiant = ?");
    $stmt->execute([$_GET['id']]);
    $etudiant = $stmt->fetch();
}

// 2. Traiter la mise à jour
if (isset($_POST['modifier'])) {
    $sql = "UPDATE Etudiant SET Nom=?, Prenom=?, Adresse=?, Classe=? WHERE CodeEtudiant=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['nom'], 
        $_POST['prenom'], 
        $_POST['adresse'], 
        $_POST['classe'], 
        $_POST['id']
    ]);
    echo "<script>window.location.href='etudiants.php';</script>";
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">Modifier l'étudiant</div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $etudiant['CodeEtudiant'] ?>">
                    
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($etudiant['Nom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Prénom</label>
                        <input type="text" name="prenom" class="form-control" value="<?= htmlspecialchars($etudiant['Prenom']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Classe</label>
                        <input type="text" name="classe" class="form-control" value="<?= htmlspecialchars($etudiant['Classe']) ?>">
                    </div>
                    <div class="mb-3">
                        <label>Adresse</label>
                        <textarea name="adresse" class="form-control"><?= htmlspecialchars($etudiant['Adresse']) ?></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="etudiants.php" class="btn btn-secondary">Annuler</a>
                        <button type="submit" name="modifier" class="btn btn-success">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>