// utilities.js

function initializeDeleteButtons() {
    document.addEventListener("DOMContentLoaded", function () {
        // Sélectionnez tous les boutons de suppression
        const deleteButtons = document.querySelectorAll(".delete-category-btn");

        // Ajoutez un gestionnaire d'événements à chaque bouton
        deleteButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                // Récupérez l'ID de la catégorie à supprimer à partir de l'attribut data-category-id
                const categoryId = button.getAttribute("data-category-id");

                // Créez une boîte de dialogue de confirmation personnalisée
                const confirmation = confirm("Êtes-vous sûr de vouloir supprimer cette catégorie ?");

                // Si l'utilisateur confirme la suppression, exécutez le code de suppression ici
                if (confirmation) {
                    // Supprimez la catégorie ou effectuez l'action de suppression ici
                    console.log("Suppression de la catégorie avec l'ID " + categoryId);
                }
            });
        });
    });
}

// Exportez la fonction pour pouvoir l'utiliser dans d'autres fichiers
export { initializeDeleteButtons };
