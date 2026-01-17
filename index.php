<?php
require 'auth.php';
restrictToAdmin();
require 'config/db.php';
include 'includes/header.php';

// 1. RÉCUPÉRATION DES DONNÉES POUR LE FORMULAIRE ET LES STATS
$totalLivres = $pdo->query("SELECT COUNT(*) FROM Livre")->fetchColumn();
$totalEtudiants = $pdo->query("SELECT COUNT(*) FROM Etudiant")->fetchColumn();
$empruntsActifs = $pdo->query("SELECT COUNT(*) FROM Emprunter")->fetchColumn();

// Liste des étudiants et livres pour les menus déroulants
$listeEtudiants = $pdo->query("SELECT CodeEtudiant, Nom, Prenom FROM Etudiant ORDER BY Nom ASC")->fetchAll();
$listeLivres = $pdo->query("SELECT CodeLivre, Titre FROM Livre ORDER BY Titre ASC")->fetchAll();

// Liste des emprunts pour le tableau
$queryEmprunts = "SELECT E.CodeEtudiant, E.CodeLivre, Et.Nom, Et.Prenom, L.Titre, E.DateEmprunt 
                  FROM Emprunter E
                  JOIN Etudiant Et ON E.CodeEtudiant = Et.CodeEtudiant
                  JOIN Livre L ON E.CodeLivre = L.CodeLivre
                  ORDER BY E.DateEmprunt DESC";
$emprunts = $pdo->query($queryEmprunts)->fetchAll();
?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        background: linear-gradient(135deg, #1b4332 0%, #2d6a4f 100%);
        font-family: 'Poppins', sans-serif;
        color: #fff;
        min-height: 100vh;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        background: rgba(255, 255, 255, 0.2);
    }

    .stat-number {
        font-size: 2.8rem;
        font-weight: 700;
        color: #b7e4c7;
    }

    .table-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 20px;
        color: #1b4332;
    }

    .btn-custom {
        border-radius: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-label { font-weight: 500; color: #d8f3dc; }
</style>

<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold">Tableau de Bord</h1>
        <p class="opacity-75">Gestionnaire de Bibliothèque Émeraude</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card glass-card stat-card p-4 text-center border-0">
                <i class="fas fa-book-open fa-3x mb-3 text-warning"></i>
                <h5>Livres</h5>
                <div class="stat-number"><?= $totalLivres ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card glass-card stat-card p-4 text-center border-0">
                <i class="fas fa-user-graduate fa-3x mb-3 text-info"></i>
                <h5>Étudiants</h5>
                <div class="stat-number"><?= $totalEtudiants ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card glass-card stat-card p-4 text-center border-0">
                <i class="fas fa-hand-holding-heart fa-3x mb-3 text-danger"></i>
                <h5>Emprunts</h5>
                <div class="stat-number"><?= $empruntsActifs ?></div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-12">
            <div class="card glass-card p-4 border-0">
                <h4 class="mb-4 text-white"><i class="fas fa-plus-circle me-2"></i>Nouvel Emprunt</h4>
                <form action="ajouter_emprunt.php" method="POST" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label">Choisir l'Étudiant</label>
                        <select name="code_etudiant" class="form-select form-select-lg border-0 shadow-sm" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach($listeEtudiants as $e): ?>
                                <option value="<?= $e ['CodeEtudiant'] ?>">
                                    <?= htmlspecialchars($e['Nom']." ".$e['Prenom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label">Choisir le Livre</label>
                        <select name="code_livre" class="form-select form-select-lg border-0 shadow-sm" required>
                            <option value="">-- Sélectionner --</option>
                            <?php foreach($listeLivres as $l): ?>
                                <option value="<?= $l['CodeLivre'] ?>">
                                    <?= htmlspecialchars($l['Titre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-warning btn-lg w-100 btn-custom shadow">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="table-container shadow-lg">
                <h4 class="mb-4"><i class="fas fa-history me-2"></i>Emprunts en cours</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Étudiant</th>
                                <th>Livre</th>
                                <th>Date d'emprunt</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($emprunts as $emp): ?>
                            <tr class="align-middle">
                                <td><strong><?= htmlspecialchars($emp['Nom']." ".$emp['Prenom']) ?></strong></td>
                                <td><?= htmlspecialchars($emp['Titre']) ?></td>
                                <td><span class="badge bg-secondary"><?= date('d/m/Y', strtotime($emp['DateEmprunt'])) ?></span></td>
                                <td>
                                    <a href="rendre_livre.php?id_etudiant=<?= $emp['CodeEtudiant'] ?>&id_livre=<?= $emp['CodeLivre'] ?>" 
                                       class="btn btn-sm btn-outline-success btn-custom"
                                       onclick="return confirm('Confirmer le retour de ce livre ?')">
                                       <i class="fas fa-check me-1"></i> Rendu
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($emprunts)): ?>
                                <tr><td colspan="4" class="text-center py-4">Aucun emprunt enregistré.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Petit effet de fondu au chargement
    document.addEventListener('DOMContentLoaded', function() {
        document.body.style.opacity = '0';
        document.body.style.transition = 'opacity 0.8s';
        document.body.style.opacity = '1';
    });
</script>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        
        // Si il y a une erreur dans l'URL
        if (urlParams.has('error')) {
            Swal.fire({
                icon: 'error',
                title: 'Attention !',
                text: urlParams.get('error'),
                confirmButtonColor: '#d33'
            });
        }

        // Si il y a un message de succès
        if (urlParams.has('msg')) {
            Swal.fire({
                icon: 'success',
                title: 'Réussi !',
                text: urlParams.get('msg'),
                timer: 3000,
                showConfirmButton: false
            });
        }
    });
</script>
<?php include 'includes/footer.php'; ?>
