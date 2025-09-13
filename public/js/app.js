// Fonction pour confirmer la suppression
function confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
    return confirm(message);
}

// Fonction pour afficher les messages de succès/erreur
function showAlert(message, type = 'success') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.textContent = message;
    
    const container = document.querySelector('.container');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Supprimer l'alerte après 5 secondes
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter des gestionnaires d'événements pour les boutons de suppression
    const deleteButtons = document.querySelectorAll('button[type="submit"]');
    deleteButtons.forEach(button => {
        if (button.textContent.includes('Supprimer')) {
            button.addEventListener('click', function(e) {
                if (!confirmDelete()) {
                    e.preventDefault();
                }
            });
        }
    });
}); 