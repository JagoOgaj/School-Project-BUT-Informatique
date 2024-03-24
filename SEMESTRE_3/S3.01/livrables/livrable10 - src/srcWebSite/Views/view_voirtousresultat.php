<?php require "Views/view_navbar.php"; ?>
<style>
.bouton-favori{
    border-radius: 5px 5px 5px 5px;
    background-color: #FFCC00;
    padding: 5px 10px;
 }

#favoriButton:hover, 
#favoriButton:visited:hover, 
#favoriButton:link:hover, 
#favoriButton:active:hover,
#favoriButton {
    text-decoration: none !important;
}
.no-scroll{

overflow : hidden;
}
</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <?php if (isset($titre)): ?>
        <h1>Résultats "<?= e($titre) ?>" dans "<?= e($category) ?>"  </h1>
        <?php endif; ?>
        <p>
         
        <a href="?controller=recherche" style="text-decoration: none;">
        <button type="submit" id="favoriButton" class="btn btn-warning boutonFonctionnalite" style =" color: white;display: block;" >
            &#8592; Realiser une nouvelle recherche
        </button>
        </a>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-2 m-5">
        <div id="movies-par-page-container">
            <label for="movies-par-page" style ="border-left:2px solid #FFCC00; padding-left: 6px;">Afficher par :</label>
            <select id="movies-par-page" onchange="changeMoviesPerPage()" class="form-control">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
    </div>
    <div class="col-md-6"></div>

    <div class="col-md-2 m-5">
        <label for="sort" style ="border-left:2px solid #FFCC00; padding-left: 6px;">Trier par :</label>
        <select id="sort" onchange="sortMovies()" class="form-control">
        <option value="">Sélectionner ...</option>
       
        <option value="title-asc">Titre - Ascendant</option>
        <option value="title-desc">Titre - Descendant</option>
        <option value="date-asc">Date - Ascendant</option>
        <option value="date-desc">Date - Descendant</option>
        <option value="genres-asc">Genres/Metier - Ascendant</option>
        <option value="genres-desc">Genres/Metier - Descendant</option>
     
       

        </select>

    </div>

</div>





  
                
        
            <div class = "col-md-9 mx-auto" id="movie-list"></div>
            
            <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count"></div>
            <div id="pagination-container" style="display: flex; justify-content: center;">
            <button onclick="prevPage()"><</button>
            <div id="paginationrecherche"></div>
            <button onclick="nextPage()">></button>
            </div>
                
        
            <div id="loadingOverlay">
    <div class="loader"></div>
</div>



<script src="Js/function.js"></script>
<script>
    function showLoadingOverlay() {
  document.getElementById("loadingOverlay").style.display = "flex";
  window.scrollTo(0, 0);
  document.body.classList.add("no-scroll"); // Empêche le défilement
}

function hideLoadingOverlay() {
  document.getElementById("loadingOverlay").style.display = "none";
  document.body.classList.remove("no-scroll"); // Réactive le défilement
}

    let movies = [];
    movies = <?php echo json_encode($recherche); ?>;
    let currentPage = 1;
    let moviesPerPage = 10;

async function displayMovies() {
  showLoadingOverlay();
    const list = document.getElementById("movie-list");
    list.innerHTML = ""; // Efface la liste actuelle
    let endIndex = currentPage * moviesPerPage;
    let startIndex = endIndex - moviesPerPage;
    let paginatedMovies = movies.slice(startIndex, endIndex);
    for (const item of paginatedMovies) {
      let posterPath = item.id.startsWith('t') ? await getFilmPhoto(item.id) : await getPersonnePhoto(item.id);
        let hrefValue = item.id.startsWith('t') ? `?controller=home&action=information_movie&id=${item.id}` : `?controller=home&action=information_acteur&id=${item.id}`;

        let cardContent = `<a href="${hrefValue}" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche" style="cursor: pointer;">
                <img src="${posterPath}" alt="${item.id}">
                <div class="card-bodyrecherche">
            <h2 class="card-1recherche">${displayValue(item.nom, 'Aucune information')}</h2>
            <p class="card-2recherche">Date : ${displayValue(item.annee, 'Aucune information')}</p>`;

        if (item.id.startsWith('t')) {
            cardContent += `<p class="card-3recherche">Genres : ${displayValue(item.details, 'Aucune information')}</p>`;
        } else if (item.id.startsWith('n')) {
            cardContent += `<p class="card-3recherche">Métier : ${displayValue(item.details, 'Aucune information')}</p>`;
        }

        cardContent += `</div></div></a>`;
        list.innerHTML += cardContent;
    }
    hideLoadingOverlay(); 
    document.getElementById("count").innerText = `Résultat : ${movies.length}`;
    window.scrollTo({ top: 0 });
    renderPagination();
}





function sortMovies() {
  let sortOrder = document.getElementById("sort").value;
  movies.sort((a, b) => {
    let valueA, valueB;

    // Helper function to handle 'Aucune information'
    const getSortableValue = (value, isNumber) => {
      if (value == null || value === '') {
        return isNumber ? -Infinity : 'ZZZZZZZZ'; // Treat missing numbers as very low, strings as very high
      }
      return isNumber ? parseFloat(value) : value.toUpperCase();
    };

    switch (sortOrder) {
      case 'title-asc':
        valueA = getSortableValue(a.nom, false);
        valueB = getSortableValue(b.nom, false);
        return valueA.localeCompare(valueB);
      case 'title-desc':
        valueA = getSortableValue(a.nom, false);
        valueB = getSortableValue(b.nom, false);
        return valueB.localeCompare(valueA);
      case 'date-asc':
        valueA = getSortableValue(a.annee, true);
        valueB = getSortableValue(b.annee, true);
        return valueA - valueB;
      case 'date-desc':
        valueA = getSortableValue(a.annee, true);
        valueB = getSortableValue(b.annee, true);
        return valueB - valueA;
      case 'genres-asc':
        valueA = getSortableValue(a.details, false);
        valueB = getSortableValue(b.details, false);
        return valueA.localeCompare(valueB);
      case 'genres-desc':
        valueA = getSortableValue(a.details, false);
        valueB = getSortableValue(b.details, false);
        return valueB.localeCompare(valueA);
      default:
      return 0;
    }
  });
  currentPage = 1; // Reset to the first page
  displayMovies();
}

   // Vérifie si le tableau movies est vide ou null et appelle displayNoResultsMessage si c'est le cas
   if (!movies || movies.length === 0) {
  displayNoResultsMessage();
} else {
  // Continue avec l'affichage des résultats si des données sont présentes
  displayMovies();
}
</script>

<?php require "Views/view_footer.php"; ?>