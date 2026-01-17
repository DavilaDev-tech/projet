</div> <footer class="mt-5 p-4 bg-light text-center border-top">
          <p class="text-muted small">
        Connecté en tant que : 
        <strong>
            <?php 
                // Affiche le nom s'il existe, sinon affiche "Invité"
                echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Invité'; 
            ?>
        </strong> 
        | <a href="logout.php" class="text-danger">Se déconnecter</a>
    </p>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/script.js"></script>
</body>
</html>



