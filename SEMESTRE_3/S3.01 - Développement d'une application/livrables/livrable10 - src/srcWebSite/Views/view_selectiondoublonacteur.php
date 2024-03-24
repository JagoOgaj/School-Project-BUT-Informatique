<?php require "Views/view_navbar.php"; ?>

<style>
.no-scroll{

overflow : hidden;
}
</style>
<h1 style="margin-top :100px">Sélection des éléments</h1>
<p>Veuillez choisir un élément de chaque tableau</p>
    <form id="selectionForm" action="?controller=trouver&action=titrecommun" method="post">
                             
    <div class="row m-5">
                <div class="col-md-5">
                    <h2>Choix pour "<?php echo e($personne1); ?>"</h2>
                                        
                    <div  id="movie-list1"></div>

                    <div id="pagination-container1" style="display: flex; justify-content: center;">
            <button onclick="prevPage1()"><</button>
            <div id="paginationrecherche1"></div>
            <button onclick="nextPage1()">></button>
            </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-5">
                    <h2>Choix pour "<?php echo e($personne2); ?>"</h2>
                    
                    <div  id="movie-list2"></div>

                    <div id="pagination-container2" style="display: flex; justify-content: center;">
            <button onclick="prevPage2()"><</button>
            <div id="paginationrecherche2"></div>
            <button onclick="nextPage2()">></button>
            </div>
                </div>
            </div>
            <input type="hidden" id="personne1" name="personne1" value="<?php echo e($personne1); ?>">
            <input type="hidden" id="personne2" name="personne2" value="<?php echo e($personne2); ?>">
            
            <div id="error-message" class="text-center" style="display: none; color: red; margin-bottom: 20px;">
            Il faut sélectionner un titre de chaque liste.
        </div>
        <button type="submit" id="buttondoublon" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block;" >Confirmer les deux éléments</button>

    </form>
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
 var personne1 = "<?php echo $personne1; ?>";
 var personne2 = "<?php echo $personne2; ?>";
 errorDisplayed = false;
    let acteur1 = [];
    acteur1 = <?php echo json_encode($result1); ?>;
    let acteur2 = [];
    acteur2 = <?php echo json_encode($result2); ?>;
    let moviesPerPage = 10;
    let currentPage1 = 1;
    let currentPage2 = 1;
    const submitButton = document.getElementById("buttondoublon");
    const erreur = document.getElementById("error-message");



async function displayMovies() {
    showLoadingOverlay();
    const list1 = document.getElementById("movie-list1");
    const list2 = document.getElementById("movie-list2");
    const paginationContainer1 = document.getElementById("pagination-container1");
    const paginationContainer2 = document.getElementById("pagination-container2");

    // Nettoie les contenus précédents
    list1.innerHTML = ""; 
    list2.innerHTML = ""; 

    // Calcul des indices pour la pagination
    let endIndex1 = currentPage1 * moviesPerPage;
    let startIndex1 = endIndex1 - moviesPerPage;
    let endIndex2 = currentPage2 * moviesPerPage;
    let startIndex2 = endIndex2 - moviesPerPage;

    // Extraction des films pour la page courante
    let paginatedacteur1 = acteur1.slice(startIndex1, endIndex1);
    let paginatedacteur2 = acteur2.slice(startIndex2, endIndex2);

    // Génération des cartes pour chaque film
    if (paginatedacteur1.length === 0) {
        list1.innerHTML = `<div style="color: red;">"${personne1}" ce titre n'existe pas.</div>`;
        paginationContainer1.style.display = 'none';
        errorDisplayed = true;
    } else {
        paginationContainer1.style.display = 'flex';
        for (const item of paginatedacteur1) {
            let posterPath = await getPersonnePhoto(item.nconst);
            let isSelected = item.nconst === selectednconst1 ? 'style="background-color: #FFCC00;"' : '';
            let cardContent = `<div class="cardrecherche" data-nconst="${item.nconst}" ${isSelected} style="cursor: pointer;">
                                    <img src="${posterPath}" alt="">
                                    <div class="card-bodyrecherche">
                                        <h2 class="card-1recherche">${item.primaryname}</h2>
                                        <p class="card-2recherche">${item.birthyear}</p>
                                        <p class="card-3recherche">${item.primaryprofession}</p>
                                    </div>
                                </div>`;

            list1.innerHTML += cardContent;
        }
    }

    if (paginatedacteur2.length === 0) {
        list2.innerHTML = `<div style="color: red;">"${personne2}" ce titre n'existe pas.</div>`;
        paginationContainer2.style.display = 'none';
        errorDisplayed = true;

    } else {
        paginationContainer2.style.display = 'flex';
        for (const item of paginatedacteur2) {
            let posterPath = await getPersonnePhoto(item.nconst);
            let isSelected = item.nconst === selectednconst2 ? 'style="background-color: #FFCC00;"' : '';
            let cardContent = `<div class="cardrecherche" data-nconst="${item.nconst}" ${isSelected} style="cursor: pointer;">
                                    <img src="${posterPath}" alt="">
                                    <div class="card-bodyrecherche">
                                        <h2 class="card-1recherche">${item.primaryname}</h2>
                                        <p class="card-2recherche">${item.birthyear}</p>
                                        <p class="card-3recherche">${item.primaryprofession}</p>
                                    </div>
                                </div>`;

            list2.innerHTML += cardContent;
        }
    }
    hideLoadingOverlay();
    submitButton.disabled = errorDisplayed;
    renderPagination1(acteur1);
    renderPagination2(acteur2);
}


function selectMovie(listId, nconst) {
  const cards = document.querySelectorAll(`#${listId} .cardrecherche`);
  cards.forEach(card => {
      if (card.getAttribute('data-nconst') === nconst) {
          card.style.backgroundColor = '#FFCC00'; // Sélectionné
      } else {
          card.style.backgroundColor = ''; // Non sélectionné
      }
  });

  if (listId === 'movie-list1') {
      selectednconst1 = nconst;
  } else if (listId === 'movie-list2') {
      selectednconst2 = nconst;
  }
}

document.getElementById("movie-list1").addEventListener("click", function(e) {
  if (e.target.closest(".cardrecherche")) {
      const nconst = e.target.closest(".cardrecherche").getAttribute("data-nconst");
      selectMovie("movie-list1", nconst);
  }
});

document.getElementById("movie-list2").addEventListener("click", function(e) {
  if (e.target.closest(".cardrecherche")) {
      const nconst = e.target.closest(".cardrecherche").getAttribute("data-nconst");
      selectMovie("movie-list2", nconst);
  }
});
document.getElementById("selectionForm").addEventListener("submit", function(e) {
    const errorMessage = document.getElementById("error-message");

    // Vérifiez si les variables selectednconst sont définies et non vides
    if (!selectednconst1 || !selectednconst2) {
        e.preventDefault(); // Empêche la soumission du formulaire
        errorMessage.style.display = 'block'; // Affiche le message d'erreur
    } else {
        errorMessage.style.display = 'none'; // Cache le message d'erreur si tout est en ordre

        // Créez ou mettez à jour des champs cachés pour les nconst sélectionnés avant la soumission
        let input1 = document.querySelector('input[name="selectednconst1"]');
        if (!input1) {
            input1 = document.createElement("input");
            input1.type = "hidden";
            input1.id = "selectednconst1";
            input1.name = "selectednconst1";
            this.appendChild(input1);
        }
        input1.value = selectednconst1;

        let input2 = document.querySelector('input[name="selectednconst2"]');
        if (!input2) {
            input2 = document.createElement("input");
            input2.type = "hidden";
            input2.name = "selectednconst2";
            input2.id = "selectednconst2";
            this.appendChild(input2);
        }
        input2.value = selectednconst2;

        // La soumission effective du formulaire peut se faire ici si nécessaire
        // ou vous pouvez retirer e.preventDefault() et laisser le formulaire se soumettre naturellement
    }
});


let selectednconst1 = null;
let selectednconst2 = null;

displayMovies();


</script>

<?php require "Views/view_footer.php"; ?>
