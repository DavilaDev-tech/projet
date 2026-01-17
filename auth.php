<?php
//session_start();
//if (!isset($_SESSION['user_id'])) {
 //   header("Location: login.php");
   // exit();
//}

if (session_status() === PHP_SESSION_NONE) { session_start(); }

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fonction pour restreindre une page aux Admins uniquement
function restrictToAdmin() {
    if ($_SESSION['role'] !== 'admin') {
        header("Location: espace_etudiant.php?error=Acces_Interdit");
        exit();
    }
}
?>

