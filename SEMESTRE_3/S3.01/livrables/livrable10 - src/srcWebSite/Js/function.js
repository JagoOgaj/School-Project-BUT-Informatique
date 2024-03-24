


function displayValue(value, defaultValue) {
    return (value === null || value === undefined || value === '') ? defaultValue : value;
  }
  
  function formatRating(rating) {
    return (rating === null || rating === undefined || rating === '') ? "Aucune information" : `${rating}/10.0`;
  }
  
  
  function renderPagination() {
    const paginationContainer = document.getElementById('paginationrecherche');
    paginationContainer.innerHTML = ''; // Efface la pagination actuelle
  
    let pageCount = Math.ceil(movies.length / moviesPerPage);
  
    // Toujours afficher le premier bouton de page
    appendPageButton(1);
  
    // Gérer les cas où il y a plus de 5 pages
    if (pageCount > 5) {
      let startPage, endPage;
      if (currentPage <= 3) {
        // Afficher les premières pages
        startPage = 2;
        endPage = 4;
      } else if (currentPage >= pageCount - 2) {
        // Afficher les dernières pages
        startPage = pageCount - 3;
        endPage = pageCount - 1;
      } else {
        // Afficher les pages autour de la page courante
        startPage = currentPage - 1;
        endPage = currentPage + 1;
      }
  
      // Gérer l'affichage des boutons "..."
      if (startPage > 2) {
        paginationContainer.appendChild(createEllipsisButton());
      }
      for (let i = startPage; i <= endPage; i++) {
        appendPageButton(i);
      }
      if (endPage < pageCount - 1) {
        paginationContainer.appendChild(createEllipsisButton());
      }
    } else {
      // Afficher tous les boutons si 5 pages ou moins
      for (let i = 2; i < pageCount; i++) {
        appendPageButton(i);
      }
    }
  
    // Toujours afficher le dernier bouton de page si plus d'une page
    if (pageCount > 1) {
      appendPageButton(pageCount);
    }
  }
  
  function appendPageButton(pageNumber) {
    const paginationContainer = document.getElementById('paginationrecherche');
    let pageItem = document.createElement('button');
    pageItem.innerText = pageNumber;
    pageItem.onclick = function() {
      currentPage = pageNumber;
      displayMovies();
      renderPagination(); // Re-render la pagination pour mettre à jour les boutons
    };
  
    // Ajoute la classe 'active' si c'est la page courante
    if (currentPage === pageNumber) {
      pageItem.classList.add('active');
    }
  
    paginationContainer.appendChild(pageItem);
  }
  
  function renderPagination1(tab) {
    const paginationContainer1 = document.getElementById('paginationrecherche1');
    paginationContainer1.innerHTML = ''; // Efface la pagination actuelle
  
    let pageCount1 = Math.ceil(tab.length / moviesPerPage);
  
    // Toujours afficher le premier bouton de page
    appendPageButton1(1);
  
    // Gérer les cas où il y a plus de 5 pages
    if (pageCount1 > 5) {
      let startPage1, endPage1;
      if (currentPage1 <= 3) {
        // Afficher les premières pages
        startPage1 = 2;
        endPage1 = 4;
      } else if (currentPage1 >= pageCount1 - 2) {
        // Afficher les dernières pages
        startPage1 = pageCount1 - 3;
        endPage1 = pageCount1 - 1;
      } else {
        // Afficher les pages autour de la page courante
        startPage1 = currentPage1 - 1;
        endPage1 = currentPage1 + 1;
      }
  
      // Gérer l'affichage des boutons "..."
      if (startPage1 > 2) {
        paginationContainer1.appendChild(createEllipsisButton());
      }
      for (let i = startPage1; i <= endPage1; i++) {
        appendPageButton1(i);
      }
      if (endPage1 < pageCount1 - 1) {
        paginationContainer1.appendChild(createEllipsisButton());
      }
    } else {
      // Afficher tous les boutons si 5 pages ou moins
      for (let i = 2; i < pageCount1; i++) {
        appendPageButton1(i);
      }
    }
  
    // Toujours afficher le dernier bouton de page si plus d'une page
    if (pageCount1 > 1) {
      appendPageButton1(pageCount1);
    }
  }
  
  function appendPageButton1(pageNumber) {
    const paginationContainer1 = document.getElementById('paginationrecherche1');
    let pageItem1 = document.createElement('button');
    pageItem1.innerText = pageNumber;
    pageItem1.onclick = function() {
      currentPage1 = pageNumber;
      displayMovies();
      renderPagination1(); // Re-render la pagination pour mettre à jour les boutons
    };
  
    // Ajoute la classe 'active' si c'est la page courante
    if (currentPage1 === pageNumber) {
      pageItem1.classList.add('active');
    }
  
    paginationContainer1.appendChild(pageItem1);
  }
  function renderPagination2(tab2) {
    const paginationContainer2 = document.getElementById('paginationrecherche2');
    paginationContainer2.innerHTML = ''; // Efface la pagination actuelle
  
    let pageCount2 = Math.ceil(tab2.length / moviesPerPage);
  
    // Toujours afficher le premier bouton de page
    appendPageButton2(1);
  
    // Gérer les cas où il y a plus de 5 pages
    if (pageCount2 > 5) {
      let startPage2, endPage2;
      if (currentPage2 <= 3) {
        // Afficher les premières pages
        startPage2 = 2;
        endPage2 = 4;
      } else if (currentPage2 >= pageCount2 - 2) {
        // Afficher les dernières pages
        startPage2 = pageCount2 - 3;
        endPage2 = pageCount2 - 1;
      } else {
        // Afficher les pages autour de la page courante
        startPage2 = currentPage2 - 1;
        endPage2 = currentPage2 + 1;
      }
  
      // Gérer l'affichage des boutons "..."
      if (startPage2 > 2) {
        paginationContainer2.appendChild(createEllipsisButton());
      }
      for (let i = startPage2; i <= endPage2; i++) {
        appendPageButton2(i);
      }
      if (endPage2 < pageCount2 - 1) {
        paginationContainer2.appendChild(createEllipsisButton());
      }
    } else {
      // Afficher tous les boutons si 5 pages ou moins
      for (let i = 2; i < pageCount2; i++) {
        appendPageButton2(i);
      }
    }
  
    // Toujours afficher le dernier bouton de page si plus d'une page
    if (pageCount2 > 1) {
      appendPageButton2(pageCount2);
    }
  }
  
  function appendPageButton2(pageNumber) {
    const paginationContainer2 = document.getElementById('paginationrecherche2');
    let pageItem2 = document.createElement('button');
    pageItem2.innerText = pageNumber;
    pageItem2.onclick = function() {
      currentPage2 = pageNumber;
      displayMovies();
      renderPagination2(); // Re-render la pagination pour mettre à jour les boutons
    };
  
    // Ajoute la classe 'active' si c'est la page courante
    if (currentPage2 === pageNumber) {
      pageItem2.classList.add('active');
    }
  
    paginationContainer2.appendChild(pageItem2);
  }
  function createEllipsisButton() {
    let ellipsisButton = document.createElement('button');
    ellipsisButton.innerText = '...';
    ellipsisButton.disabled = true;
    return ellipsisButton;
  }
  
  
  function changeMoviesPerPage() {
    moviesPerPage = document.getElementById("movies-par-page").value;
    currentPage = 1; // Reset to the first page
    displayMovies();
    renderPagination();
  }
  
  
  
  
  function prevPage() {
    if (currentPage > 1) {
      currentPage--;
      displayMovies();
    }
  }
  
  function nextPage() {
    if (currentPage * moviesPerPage < movies.length) {
      currentPage++;
      displayMovies();
    }
  }
  function prevPage1() {
    if (currentPage1 > 1) {
      currentPage1--;
      displayMovies();
    }
  }
  
  function nextPage1() {
    if (currentPage1 * moviesPerPage < movies1.length) {
      currentPage1++;
      displayMovies();
    }
  }
  function prevPage2() {
    if (currentPage2 > 1) {
      currentPage2--;
      displayMovies();
    }
  }
  
  function nextPage2() {
    if (currentPage2 * moviesPerPage < movies2.length) {
      currentPage2++;
      displayMovies();
    }
  }
  function displayNoResultsMessage() {
    const list = document.getElementById("movie-list");
    const sortSelect = document.getElementById("sort");
    const moviesPerPageSelect = document.getElementById("movies-par-page");

    // Affiche un message indiquant qu'aucun résultat n'a été trouvé
    list.innerHTML = `<div class=" col-md-5 mx-auto m-5 alert alert-warning" role="alert" style="background-color:#FFCC00; color:white;">0 résultat trouvé.</div>`;

    // Désactive les sélections de tri et d'affichage par nombre
    sortSelect.disabled = true;
    moviesPerPageSelect.disabled = true;

    // Cache ou modifie les messages de pagination ou d'autres éléments si nécessaire
    document.getElementById("pagination-container").style.display = "none";
    document.getElementById("count").innerText = "";
}
async function getFilmPhoto(id) {
  const apiKey = "9e1d1a23472226616cfee404c0fd33c1";
  const url = `https://api.themoviedb.org/3/find/${id}?api_key=${apiKey}&language=fr&external_source=imdb_id`;

  try {
      const response = await fetch(url);
      const data = await response.json();

      // Liste des catégories de résultats à vérifier
      const resultCategories = ["movie_results", "tv_results", "tv_episode_results", "tv_season_results"];

      for (const category of resultCategories) {
        if (data[category].length > 0) {
            // Vérifie si poster_path est disponible
            if (data[category][0].poster_path) {
                return `https://image.tmdb.org/t/p/w400${data[category][0].poster_path}`;
            } 
            // Sinon, vérifie si still_path est disponible
            else if (data[category][0].still_path) {
                return `https://image.tmdb.org/t/p/w400${data[category][0].still_path}`;
            }
        }
    }
    

      // Si aucun poster n'est trouvé dans aucune catégorie
      return "./Images/depannage.jpg";
  } catch (error) {
      console.error("Erreur lors de la récupération des données:", error);
      return "./Images/depannage.jpg"; // Retourne le chemin vers une image de dépannage en cas d'erreur
  }
}



async function getPersonnePhoto(id) {
    const apiKey = "9e1d1a23472226616cfee404c0fd33c1";
    const url = `https://api.themoviedb.org/3/find/${id}?api_key=${apiKey}&language=fr&external_source=imdb_id`;

    try {
        const response = await fetch(url);
        const data = await response.json();

        let posterPath = "./Images/depannage.jpg"; // Photo de dépannage par défaut

        if (data.person_results && data.person_results.length > 0 && data.person_results[0].profile_path) {
            posterPath = `https://image.tmdb.org/t/p/w400${data.person_results[0].profile_path}`;
        }

        return posterPath;
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
        return "./Images/depannage.jpg";
            
        
    }
}

