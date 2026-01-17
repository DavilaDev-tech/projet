document.addEventListener('DOMContentLoaded', function() {
    // Confirmation avant suppression ou rendu
    const deleteButtons = document.querySelectorAll('.btn-outline-success, .btn-danger');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if(!confirm("Êtes-vous sûr de vouloir effectuer cette action ?")) {
                e.preventDefault();
            }
        });
    });

    // Notification automatique : Disparition des alertes après 3 secondes
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 3000);
    });
});