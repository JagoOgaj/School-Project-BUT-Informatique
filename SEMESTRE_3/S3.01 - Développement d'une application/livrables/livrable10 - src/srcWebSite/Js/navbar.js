



//recuperation photo film 
function getImageTitleBasics(idImdb) {
    var api_key = "9e1d1a23472226616cfee404c0fd33c1";
    var url = `https://api.themoviedb.org/3/find/${idImdb}?api_key=${api_key}&external_source=imdb_id&language=fr`;
    var defaultImagePath = './Images/depannage.jpg'; // Chemin de l'image par défaut

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                var imagePath = defaultImagePath; // Utilisez l'image par défaut initialement
                var results = [].concat(response.movie_results, response.tv_results, response.tv_episode_results, response.tv_season_results);

                for (var result of results) {
                    if (result && result.poster_path) {
                        imagePath = `https://image.tmdb.org/t/p/w400${result.poster_path}`;
                        break;
                    }
                }
                for (var result of results) {
                    if (result && result.still_path) {
                        imagePath = `https://image.tmdb.org/t/p/w400${result.still_path}`;
                        break;
                    }
                }
                resolve(imagePath); // Retourne le chemin de l'image trouvé ou l'image par défaut
            },
            error: function(error) {
                reject(defaultImagePath); // Retourne l'image par défaut en cas d'erreur
            }
        });
    });
}
function getImageNameBasic(idImdb) {
    var api_key = "9e1d1a23472226616cfee404c0fd33c1";
    var url = `https://api.themoviedb.org/3/find/${idImdb}?language=fr&api_key=${api_key}&external_source=imdb_id`; 
    var defaultImagePath = './Images/depannage.jpg'; // Chemin de l'image par défaut

    return new Promise((resolve, reject) => {
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                var imagePath = defaultImagePath;
                var results = response.person_results || []; // Correction ici

                for (var result of results) {
                    if (result && result.profile_path) {
                        imagePath = `https://image.tmdb.org/t/p/w400${result.profile_path}`;
                        break; // Sortez dès qu'une image est trouvée
                    }
                }

                resolve(imagePath); // Retourne le chemin de l'image trouvé ou l'image par défaut
            },
            error: function(error) {
                reject(defaultImagePath); // Utilisez `reject` en cas d'erreur
            }
        });
    });
}




var Derniere_requete;

$(document).ready(function() {
    $('#search-input').on('input', function() {
        var searchQuery = $(this).val();
        var category = $('#category').val();

        $('#search-suggestions').empty();

        if (Derniere_requete) {
            Derniere_requete.abort();
        }

        
            Derniere_requete = $.ajax({
                url: '?controller=home&action=home', // Assurez-vous que cette URL est correcte.
                type: 'POST',
                data: {
                    suggestion: searchQuery,
                    category: category
                },
                success: function(data) {
                    var suggestions = JSON.parse(data);
                    var suggestionsList = '<ul class="list-group">';

                    suggestions.forEach(function(suggestion, index) {
                        var titreOuNom = suggestion.nom;
                        var annee = suggestion.annee || 'Inconnu';
                        var details = suggestion.details || 'Inconnu';
                        var link;

                        if (category === 'tout') {
                            if (suggestion.id.startsWith('n')) {
                                link = `?controller=home&action=information_acteur&id=${suggestion.id}`;
                            } else if (suggestion.id.startsWith('t')) {
                                link = `?controller=home&action=information_movie&id=${suggestion.id}`;
                            }
                        } else {
                            link = category === 'personne' ?
                                `?controller=home&action=information_acteur&id=${suggestion.id}` :
                                `?controller=home&action=information_movie&id=${suggestion.id}`;
                        }

                        
                        suggestionsList += `
                            <li class="list-group-item">
                                <a href="${link}" class="list-group-item list-group-item-action">
                                    <img id="suggestion-img-${index}" alt="${titreOuNom}" class="suggestion-image" src="">
                                    <div class="suggestion-details">
                                        <h5 class="suggestion-title">${titreOuNom}</h5>
                                        <p class="suggestion-year">${annee}</p>
                                        <p class="suggestion-details">${details}</p>
                                    </div>
                                </a>
                            </li>`;
                    });

                    suggestionsList += '<a href="?controller=home&action=voirtousresultat&mot='+ searchQuery +'&category='+category +'"> <li class="list-group-item see-all-results">Voir tous les résultats pour "' + searchQuery + '" dans "'+category+'"</li> </a>';
                    suggestionsList += '</ul>';
                    $('#search-suggestions').html(suggestionsList);
                    $('#search-suggestions').show();

                    suggestions.forEach(function(suggestion, index) {
                          // Déterminer le type de suggestion en fonction du préfixe de suggestion.id
                                var fetchImageFunction;
                                if (suggestion.id.startsWith('n')) {
                                    fetchImageFunction = getImageNameBasic;
                                } else if (suggestion.id.startsWith('t')) {
                                    fetchImageFunction = getImageTitleBasics;
                                }

                                // Vérifier si fetchImageFunction est défini avant de l'utiliser
                                if (fetchImageFunction) {
                                    fetchImageFunction(suggestion.id).then(imageSrc => {
                                        $(`#suggestion-img-${index}`).attr('src', imageSrc);
                                    }).catch(error => {
                                        console.error('An error occurred:', error);
                                        $(`#suggestion-img-${index}`).attr('src', './Images/depannage.jpg');
                                    });
                                }
                            });
                },
                error: function(xhr, status, error) {
                    if (status !== 'abort') {
                        console.error('An error occurred:', error);
                    }
                },
                complete: function() {
                    Derniere_requete = null;
                }
            });
        
    });
});


    // Cacher les suggestions quand on clique à l'extérieur
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search-input, #search-suggestions').length) {
            $('#search-suggestions').hide();
        }
    });

