<?php
require 'config/db.php';
session_start();
$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE NomUtilisateur = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // TEST DE FORCE : On compare directement les textes
        if ($password == $user['MotDePasse']) {
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['username'] = $user['NomUtilisateur'];
            $_SESSION['role'] = $user['Role'];

            if ($_SESSION['role'] === 'admin') {
                header("Location: index.php");
            } else {
                header("Location: espace_etudiant.php");
            }
            exit();
        } else {
            $error = "Mot de passe faux. Lu dans la base : " . $user['MotDePasse'];
        }
    } else {
        $error = "Utilisateur '$username' non trouvé dans la base.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Bibliothèque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .login-container { margin-top: 100px; }
        .card { border: none; border-radius: 15px; }
        .card-header { background: #0d6efd; color: white; border-radius: 15px 15px 0 0 !important; }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-lg">
                <div class="card-header text-center p-4">
                    <h3>BiblioManage</h3>
                    <p class="mb-0">Authentification</p>
                </div>
                <div class="card-body p-4">
                    
                    <?php if(!empty($error)): ?>
                        <div class="alert alert-danger text-center"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Nom d'utilisateur</label>
                            <input type="text" name="username" class="form-control" placeholder="ex: admin" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" name="password" class="form-control" placeholder="••••" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="login" class="btn btn-primary btn-lg">Se connecter</button>
                        </div>
                    </form>

                </div>
                <div class="card-footer text-center py-3">
                    <small class="text-muted">Accès réservé aux membres de la bibliothèque</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>