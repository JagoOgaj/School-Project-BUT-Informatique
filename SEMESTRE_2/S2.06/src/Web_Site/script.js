// script.js

// Récupérer les liens de navigation dans la barre de navigation
const navLinks = document.querySelectorAll('nav a');

// Ajouter un gestionnaire d'événement pour chaque lien de navigation
navLinks.forEach(link => {
  link.addEventListener('click', navigateToPage);
});

// Fonction pour la navigation vers la page correspondante
function navigateToPage(event) {
  event.preventDefault(); // Empêcher le comportement par défaut du lien
  
  // Récupérer l'URL de la page cible à partir de l'attribut "href" du lien cliqué
  const targetPage = this.getAttribute('href');
  
  // Charger la page cible en utilisant la méthode "fetch" ou tout autre moyen de chargement de contenu dynamique
  
  // Par exemple, charger la page cible dans une div avec l'ID "content"
  const contentDiv = document.getElementById('content');
  
  fetch(targetPage)
    .then(response => response.text())
    .then(data => {
      contentDiv.innerHTML = data;
    })
    .catch(error => {
      console.log('Une erreur s\'est produite :', error);
    });
}
