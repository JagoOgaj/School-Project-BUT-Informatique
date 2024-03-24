<?php require "Views/view_navbar.php"; ?>

<style>
.middot{


    font-size: 24px;
}
.btncommentaire {
    background-color: #FFCC00; /* Couleur de fond initiale */
    border: 2px solid #FFCC00; /* Couleur de bordure initiale */
    color: white;
    border-radius: 25px;
    padding: 15px;
}

.btncommentaire:hover {
    background-color: #c79f00; /* Couleur de fond au survol */
    border: 2px solid #FFCC00; /* Couleur de bordure au survol */
}
.synopsie {
    max-height: 195px; /* Ajustez en fonction de l'espace disponible */
    overflow-y: scroll;
}
/* Styliser spécifiquement l'état :active */
.btncommentaire:active {
    background-color: #c79f00; /* Couleur de fond pendant le clic */
    border: 2px solid #FFCC00; /* Couleur de bordure pendant le clic */
    outline: none; /* Optionnel: supprime l'outline */
    box-shadow: none; /* Optionnel: supprime l'ombre de la boîte (si vous utilisez Bootstrap) */
}
.aucunparticipant{

    font-size:20px;
    margin-top:30px;
}
.composent-card {
    background-color: #333; /* Gris foncé */
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23); /* Effet d'ombre 3D */
    margin: 40px; /* Espacement entre les cartes */
    transition: transform 0.3s, border 0.3s; /* Ajout de la transition pour la bordure */
    
}

.composent-card:hover {
    transform: scale(1.1);
    border: 2px solid #FFCC00; /* Encadrement blanc lors du survol */
    text-decoration: none !important;
    color: inherit !important;
}



.card-title {
    color: white; /* Titre en blanc */
    font-size: 17px;/*taille de la police*/
}

.film {
    /* Styles de base pour tous les films */
    padding: 20px;
    border: 1px solid #ccc;
}

.film.favori {
    /* Styles spécifiques pour les films favoris */
    background-color: #FFCC00; /* Couleur de fond jaune */
    color: black; /* Texte en noir */
}


.custom-modal {
            color: black;
        }

        /* Style personnalisé pour le texte du formulaire */
        .custom-form-label {
            color: black;
        }

        /* Style personnalisé pour le bouton d'envoi */
        .custom-submit-btn {
            background-color: white;
            color: black;
        }
        .comment-bubble {
            background-color: #FFCC00;
            color: black;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 10px;
        }

        /* Style personnalisé pour le nom de l'auteur */
        .comment-author {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* Style personnalisé pour la note du commentaire */
        .comment-note {
            margin-bottom: 5px;
        }

        .check{
            color: black;
        }
        .titre{
            color: black;
        }
        /* Style pour le fil des notes */
        .rating-range {
            display: flex;
            justify-content: space-between;
            padding: 0 15px;
            margin-top: 10px;
        }

        .note{
            color: black;
        }
        
        .form{
            text-align: center;
        }

        .comment-rating {
        font-size: 14px;
        font-weight: bold;
        color: #888; /* Couleur de la note, vous pouvez ajuster selon vos préférences */
        margin-top: 10px; /* Espace entre le titre et la note */
        }

/* CSS pour le message "Aucun commentaire" */
        .no-comments {
            font-size: 16px;
            font-weight: bold;
            color: #888; /* Couleur du texte pour le cas où il n'y a pas de commentaires */
            text-align: center;
            margin-top: 20px; /* Espace entre le message et le reste du contenu */
        }

        .modal-content{
            background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
        }

        .star-container {
            margin-top: -15px;
            margin-left: -5px;
            display: flex;
            align-items: center; /* Aligne les étoiles verticalement */
        }
        .star {
            font-size: 20px; /* Taille des étoiles */
            color: black; /* Couleur des étoiles */
            margin-right: 5px; /* Espacement entre les étoiles */
        }

        

        .star-button {
            font-size: 50px; /* Taille de l'étoile */
            color: white; /* Couleur de l'étoile */
            background: none;
            border: none;
            cursor: pointer;
    }

    .image-container {
        position: relative;
    }

    .overlay {
        position: absolute;
        top: -10px; /* Ajustez cette valeur pour la position verticale */
        left: -10px; /* Ajustez cette valeur pour la position horizontale */
        background-color: black; /* Couleur de fond semi-transparente */
        opacity: 0.9;
        border: 1px solid gold;
        border-radius: 10px;
        transform: scale(0.7);
    }
    .no-scroll{

overflow : hidden;
}
</style>

<?php
if(isset($_GET['retour'])){
    $retour = trim(e($_GET['retour']));
    switch ($retour) {
        case 1:
            $message = "Commentaire ajouté avec succés";
            $alertClass = "alert-success";
            $image='icons8-check-50.png';
            break;
        case -1:
            $message = "Une erreur est survenu";
            $alertClass = "alert-danger";
            $image='icons8-warning-50.png';
            break;
        default:
            $message = "";
            $alertClass = "";
    }


    // Si un message a été défini, afficher l'alerte
    if ($message != "") {
        echo "<div id='myAlert' class='alert $alertClass alert-dismissible fade show' 
        role='alert' style='position: fixed; top: 0; width: 100%; z-index: 9999;'>
          <div style='padding-top: 10px'>
            <p style='border-left:2px solid black ;padding-left: 5px'>
              <img style='transform: scale(0.7); padding-bottom: 2px;' src='Images/$image' alt='warning'>$message
            </p>
        </div>
      </div>";
    }
    
    
}

$id_imdb = '';
$color = isset($_SESSION['favori']) ? 'gold' : 'white';
if(isset($_GET['id'])){
    $id_imdb = $_GET['id'];
} 
else if(isset($_GET['filmId'])){
    $id_imdb = $_GET['filmId'];
}


?>
 
 <div style="position: relative; margin-top:35px;">
    <div class="row">
        <!-- Couverture -->
        <div class="backdrop col-md-12" style="z-index: 1;">
            <img class="img-fluid" src="" alt="Couverture" style="filter: opacity(70%) brightness(15%);width: 12800px;height: 800px;">
        </div>
    </div>

    <div class="row" style="position: absolute; top: 100px; left: 100px; width: 100%; margin-top: 35px; z-index: 2;"> <!-- Superpose sur la couverture -->
        <!-- Portrait à gauche -->
        <div class="afficheportrait col-md-3 ml-3">
            <div class="image-container">
            <img id="portrait" class="img-fluid w-100" src="" alt="Portrait"> 
            <div class="overlay">
            <span><button id='favori-button' data-film-id="<?php echo $id_imdb; ?>" style='font-size: 50px;
                                                    color:
                                                    <?php 
                                                    if(isset($_SESSION['username'])){
                                                        $m = Model::getModel();
                                                        $userId = $m->getUserId($_SESSION['username'])["userid"];
                                                        if(empty($m->favorieExistFilm($userId, $id_imdb))){
                                                            echo 'white';
                                                        }
                                                        else {
                                                            echo "yellow";
                                                        }
                                                    }
                                                    else {
                                                        echo 'white';
                                                    } 
                                                    ?>;
                                                    background: none;
                                                    border: none; 
                                                    cursor: pointer;'>
                                                    ★</button>
                            </span>
            </div>
        </div>
        </div>
        <div class="col-md-1"></div> <!-- Espace entre le portrait et le bloc d'info -->
        <div class="col-md-7 mr-3">
            <div class="blocinfo" style="background-color: transparent;"> <!-- Le fond peut être ajusté pour améliorer la lisibilité -->
              
                <h1><?= ($info[0]['primarytitle'] ?? 'Inconnu'); ?>
                </h1>
                <?php if ($info[0]['titletype']=="tvEpisode" ) : ?>
                <h6>Série : <?= ($nomserie['seriesname'] ?? 'Inconnu'); ?></h6>
                
                <?php endif ; ?>
                <p>Durée : <?= (!empty($info[0]['runtimeminutes']) ? $info[0]['runtimeminutes'] . ' minutes' : 'Inconnu'); ?> &nbsp;&nbsp;&nbsp; <span class="middot">&middot;</span> &nbsp;&nbsp;&nbsp;  Année : <?= ($info[0]['startyear'] ?? 'Inconnu'); ?> &nbsp;&nbsp;&nbsp;<span class="middot">&middot;</span> &nbsp;&nbsp;&nbsp;  Genres : <?= ($info[0]['genres'] ?? 'Inconnu'); ?> &nbsp;&nbsp;&nbsp; <?php if ($info[0]['titletype'] == "movie" || $info[0]['titletype'] == "tvSeries"  || $info[0]['titletype'] == "tvMiniSeries") : ?><span class="middot">&middot;</span> &nbsp;&nbsp;&nbsp;  <a href="#" class="openModal" data-tconst=" <?php echo $_GET['id'] ?>"> <img src="./Images/playwhite.png" alt="Icône Bande-annonce" style="height: 20px; margin-right: 5px; vertical-align: middle;">Bande-annonce </a><?php endif; ?></p>
                

<h6  style="margin-top: 50px;">Synopsis</h6>
                <p class="synopsie"></p>
                <div class="row" style="margin-top: 50px;margin-bottom: 50px;">
                    <div class="col-md-4">
                        <h6>Note sur 10</h6>
                        <p><?= ($info[0]['averagerating'] ?? 'Inconnu'); ?></p>
                    </div>
                    <div class="col-md-4">
                        <h6>Réalisateur</h6>
                        <p><?= ($realisateur['realisateur'] ?? 'Inconnu'); ?></p>
                    </div>
                    <div class="col-md-4 ">
                        <h6>Type</h6>
                        <p><?= ($info[0]['titletype'] ?? 'Inconnu'); ?></p>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-4">
                <button id="buttonCommentaire" type="button" class=" btncommentaire" data-toggle="modal" data-target=".bd-example-modal-lg">Commentaire</button>
                </div>
                <?php if ($info[0]['titletype']=="tvEpisode" ) : ?>
                <div class="col-md-4">
                <h6>Episode</h6>
                <p><?= ($saisonactuel['episodenumber'] ?? 'Inconnu'); ?></p>
                </div>
                <?php elseif($info[0]['titletype']=="tvSeries" || $info[0]['titletype']=="tvMiniSeries" ) : ?>
                <div class="col-md-4">
                <h6>Nombre d'épisode</h6>
                <p><?= ($nbepisode['count'] ?? 'Inconnu'); ?></p>
                </div>
                <?php else : ?>
                <div class="col-md-4"></div>
                <?php endif ; ?>

                <?php if ($info[0]['titletype']=="tvSeries" || $info[0]['titletype']=="tvMiniSeries" ) : ?>
                <div class="col-md-4">
                <h6>Nombre de saison</h6>
                <p><?= ($nbsaison['max'] ?? 'Inconnu'); ?></p>
                </div>
                <?php endif ; ?>
                <?php if ($info[0]['titletype']=="tvEpisode" ) : ?>
                <div class="col-md-4">
                <h6>Saison</h6>
                <p><?= ($saisonactuel['seasonnumber'] ?? 'Inconnu'); ?></p>
                </div>
                <?php endif ; ?>
                
            </div>        
            </div>
        </div>
    </div>
</div>

                

<!-- La modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
            <!-- En-tête de la modal -->
            <div class="modal-header">
                <h5 class="modal-title titre" style="color: #FFCC00; margin-top: 5px">Commentaires <img style="transform: scale(0.9);"src="./images/icons8-message-48.png" alt="Star" class="star"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #FFCC00;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Corps de la modal -->
            <div class="modal-body">
                <!-- Affichage des commentaires -->
                <!-- Exemple de données commentaires -->
                <?php
                if (!empty($commentaires)) {
                    $m = Model::getModel();
                    foreach ($commentaires as $commentaire) {
                        if($commentaire['anonyme']){
                            $author = $m->getUsername($commentaire['userid'])['username'];
                        }
                        else{
                            $author = 'Anonyme';
                        }
                        
                        $title = $commentaire['titrecom'];
                        $content = $commentaire['commentary'];
                        $rating = $commentaire['rating'];
                ?>
                        <div class="comment-bubble">
                            <div class="comment-author">Par <?php echo $author; ?></div>
                            <div class="comment-title">
                                <p style="border-left:2px solid black;padding-left: 6px;"><?php echo $title; ?></p>
                            </div>
                        <div class="star-container">
                            <?php 
                                for($i = 0; $i<$rating; $i++){
                                    echo "
                                    <span class='star'>★</span>
                                    ";
                                }
                            ?>
                            <!-- Ajoutez plus d'étoiles ici si nécessaire -->
                        </div>
                        <div class="comment-rating">
                            <?php echo $content; ?>
                        </div>
                    </div>
                <?php
                    }
                } else {
                ?>
                    <div class="no-comments">Aucun commentaire</div>
                <?php
                }
                ?>
            </div>

            <!-- Pied de la modal -->
            <div style="padding-right: 50px;"class="modal-form col-12">
            <hr style="margin-left: 20px; border: none; height: 2px; background-color: #999;">
                <div class="container formulaire">
                    <div class="row">

                        <div class="col-12">
                <!-- Formulaire pour ajouter un commentaire -->
                                <form id="commentForm" action="?controller=home&action=ajoutComMovie&id=<?php echo $id_imdb;?>" method="post">
                                    <div class="form-group">
                                        
                                        <label class="custom-form-label" style="padding-left: 10px; margin-top: 20px; color: white;">Anonyme :</label>
                                        <div class="form-check">
                                        <select class="custom-select" name="anonymous" id="anonymous" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                                                <option value="0">Oui</option>
                                                                                <option value="1" selected>Non</option>
                                                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="commentTitle" class="custom-form-label" style="margin-top: 20px; color: white;">Titre du commentaire :</label>
                                        <input type="text" class="form-control" id="commentTitle" name="commentTitle" placeholder="Titre">
                                        <div id="commentTitle-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>
                                    </div>
                                    <div class="form-group">
                                        <label for="commentNote" class="custom-form-label" style="margin-top: 20px; color: white;">Note :</label>
                                        <!-- Fil des notes -->
                                        <div class="form-check">
                                        <select class="custom-select" name="commentNote" id="commentNote" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                                                <option value="0" selected>0</option>
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                                <option value="6">6</option>
                                                                                <option value="7">7</option>
                                                                                <option value="8">8</option>
                                                                                <option value="9">9</option>
                                                                                <option value="10">10</option>
                                                                            </select>
                                    </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="commentInput" class="custom-form-label" style="margin-top: 20px; color: white;">Ajouter un commentaire :</label>
                                        <textarea class="form-control" id="commentInput" name="commentInput" rows="3" style="color: black;" placeholder="Commentaire"></textarea>
                                        <div id="commentInput-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>
                                    </div>
                                    

                                    <button type="submit" id="buttontrouver" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block; margin-bottom: 10px;" >Envoyer</button>
                                    <div id="submit-error" style="display: none; color: red; margin-left: 225px; margin-bottom: 10px;">Veuillez vous connectez à un compte.</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($info[0]['titletype']=="tvSeries" || $info[0]['titletype']=="tvMiniSeries" ) : ?>
<div class="container mt-4">
    <h3 style="border-left:2px solid #FFCC00;padding-left: 6px;">Episodes</h3>
<div class="row">
<div class="col-md-2 m-5">
    <div id="season-selector-container">
        <label for="season-selector" style="border-left:2px solid #FFCC00; padding-left: 6px;">Saison</label>
        <select id="season-selector" class="form-control" onchange="filterEpisodesBySeason()">
            <?php for($i = 1; $i <= $nbsaison['max']; $i++): ?>
                <option value="<?= $i ?>">Saison <?= $i ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>


</div>
<div class = "col-md-9 mx-auto" id="movie-list"></div>
</div>
<?php endif ; ?>

<div class="container mt-4">
    <h3 style="border-left:2px solid #FFCC00;padding-left: 6px;">Participants</h3>
    <div class="row" id="listeParticipants">
        
    </div>
</div>

<div id="videoModal" style="display:none;">
    <span id="closeModal">&times;</span>
    <div id="modalContent">
        <iframe id="videoFrame" width="660" height="415" src="" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="display:none;"></iframe>
        <p id="videoUnavailable"  style="display:none; text-align:center;">Vidéo indisponible</p>
    </div>
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




document.querySelector('#buttonCommentaire').addEventListener('click', ()=>{
    handleFormValidation();
})


    function handleFormValidation() {
    $('form').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire

        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var searchInput = $('#commentTitle').val().trim();
        var commentInput = $('#commentInput').val().trim();



        // Valide chaque champ selon les critères spécifiques
        if (!searchInput) {
            $('#commentTitle').addClass('is-invalid');
            $('#commentTitle-error').show();
            isValid = false; // Formulaire invalide
        }

        if (!commentInput) {
            $('#commentInput').addClass('is-invalid');
            $('#commentInput-error').show();
            isValid = false; // Formulaire invalide
        }

        if(!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>){
            $("#submit-error").show();
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#commentTitle, #commentInput').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
    });
}


document.querySelector('#favori-button').addEventListener('click', function (event) {
    // Empêcher la propagation de l'événement de clic
    event.stopPropagation();

    var filmId = this.getAttribute('data-film-id');
    if (!<?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>) {
        // Rediriger vers la page souhaitée
        window.location.href = '?controller=connect';
        return; // Arrêter l'exécution du reste du code si la redirection est effectuée
    }

    const xhr = new XMLHttpRequest();

    // Configurez la requête
    xhr.open('GET', `?controller=home&action=favorie_movie&filmId=${filmId}`, true);

    // Utilisez une fonction fléchée pour conserver le contexte de 'this'
    xhr.onreadystatechange = () => {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Traitez la réponse ici
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                // L'ajout aux favoris a réussi
                this.style.color = 'gold'; // Utilisez 'this' pour faire référence au bouton actuel
            } else {
                // L'ajout aux favoris a échoué
                this.style.color = 'white'; // Utilisez 'this' pour faire référence au bouton actuel
            }
        }
    };

    // Envoyez la requête
    xhr.send();
});


        let titleType = <?php echo json_encode($info[0]['titletype']); ?>;
    let episodes = <?php echo json_encode($saison_episode); ?>;

function filterEpisodesBySeason() {
    const selectedSeason = document.getElementById("season-selector").value;
    const filteredEpisodes = episodes.filter(episode => episode.seasonnumber == selectedSeason);
    displayMovies(filteredEpisodes);
}


    async function displayMovies(episode) {
        showLoadingOverlay();
    const list = document.getElementById("movie-list");
    list.innerHTML = ""; 

    for (const item of episode) {
        let posterPath = await getFilmPhoto(item.tconst);
        let hrefValue = `?controller=home&action=information_movie&id=${item.tconst}`;
        let cardContent = `<a href="${hrefValue}" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
            <div class="cardrecherche" style="cursor: pointer;">
                <img src="${posterPath}" alt="${item.tconst}">
                <div class="card-bodyrecherche">`;


            cardContent += `
                <h2 class="card-1recherche">Episode ${displayValue(item.episodenumber, 'Aucune information')}</h2>
                <p class="card-2recherche">Titre : ${displayValue(item.primarytitle, 'Aucune information')}</p>
                <p class="card-3recherche">Date : ${displayValue(item.startyear, 'Aucune information')}</p>
                </div>
                    </div>
                </a>`;



        list.innerHTML += cardContent;
    }

    hideLoadingOverlay();
}

function loadMovieDetails(id_imdb) {
    const api_key = "9e1d1a23472226616cfee404c0fd33c1";
    const url = `https://api.themoviedb.org/3/find/${id_imdb}?api_key=${api_key}&external_source=imdb_id&language=fr`;

    fetch(url)
        .then(response => response.json())
        .then(data => {
            let couverture = "./Images/cinemadepannage.jpg";
            let portrait = "./Images/depannage.jpg";
            let overview = 'Inconnu';
            let tmdbId = null; // Stocker l'ID TMDB ici

            const results = [...data.movie_results, ...data.tv_results, ...data.tv_episode_results, ...data.tv_season_results];

            for (let result of results) {
                if (result.backdrop_path || result.still_path) {
                    couverture = `https://image.tmdb.org/t/p/w1280${result.backdrop_path || result.still_path}`;
                }
                if (result.poster_path || result.still_path) {
                    portrait = `https://image.tmdb.org/t/p/w400${result.poster_path || result.still_path}`;
                }
                if (result.overview) {
                    overview = result.overview;
                }
                if (result.id) { // Vérifier et stocker l'ID TMDB
                    tmdbId = result.id;
                }
            }

            document.querySelector('.img-fluid').src = couverture;
            document.querySelectorAll('.img-fluid.w-100').forEach(img => img.src = portrait);
            document.querySelector('.synopsie').textContent = overview;

            // Stockez l'ID TMDB dans un attribut de l'élément pour une utilisation ultérieure
            document.querySelectorAll('.openModal').forEach(element => {
                element.setAttribute('data-tmdb-id', tmdbId);
            });
        });
}
            




       document.addEventListener('DOMContentLoaded', function() {

if (titleType === 'tvSeries' || titleType === 'tvMiniSeries') {
filterEpisodesBySeason();
}



const acteurs = <?php echo json_encode($acteur); ?>;
const apiUrlBase = 'https://api.themoviedb.org/3/find/';
const apiKey = '9e1d1a23472226616cfee404c0fd33c1';
const id_imdb = "<?php echo $_GET['id'] ?>"; // Mettez l'ID IMDb ici
loadMovieDetails(id_imdb);


if (acteurs.length === 0) {
document.getElementById('listeParticipants').innerHTML = '<p class="aucunparticipant">Aucun participant connu.</p>';
} else {
document.getElementById('listeParticipants').innerHTML = ''; // Vider la section pour le contenu dynamique
acteurs.forEach(function(acteur) {
    fetch(`${apiUrlBase}${acteur.nconst}?api_key=${apiKey}&external_source=imdb_id`)
        .then(response => response.json())
        .then(data => {
            const profilePath = data.person_results[0]?.profile_path;
            const imageSrc = profilePath ? `https://image.tmdb.org/t/p/w500${profilePath}` : "./Images/depannage.jpg";

            const cardHTML = `
                <div class="col-md-3 custom-card d-flex align-items-stretch">
                    <a href="?controller=home&action=information_acteur&id=${acteur.nconst}" class="card composent-card" style="width: 200px;">
                        <img src="${imageSrc}" alt="Poster" class="card-img-top">
                        <div class="card-body">
                            <h2 class="card-title">${acteur.nomacteur}</h2>
                            <h3 class="card-title">${acteur.dateacteur}</h3>
                            <h4 class="card-title">${acteur.nomdescene}</h4>
                        </div>
                    </a>
                </div>
            `;
            document.getElementById('listeParticipants').insertAdjacentHTML('beforeend', cardHTML);
        })
        .catch(error => console.error('Erreur lors de la récupération des données:', error));
    })}
});


document.addEventListener("DOMContentLoaded", function() {
    // Configuration initiale
    const apiKey = '9e1d1a23472226616cfee404c0fd33c1';
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoFrame');
    const videoUnavailable = document.getElementById('videoUnavailable');
    const titleType = "<?php echo $info[0]['titletype']; ?>"; // Récupère le type du contenu depuis PHP

    // Fermeture de la modal quand on clique en dehors
    document.addEventListener('click', function(event) {
        if (!modal.contains(event.target) && modal.style.display === 'block') {
            closeModal();
        }
    });

    // Ouverture de la modal et récupération de la bande-annonce
    document.querySelectorAll('.openModal').forEach(link => {
    link.addEventListener('click', function(event) {
        event.preventDefault();
        const tmdbId = this.getAttribute('data-tmdb-id'); // Récupérer l'ID TMDB stocké
        let titleType = "<?php echo $info[0]['titletype']; ?>"; // Le type de titre (movie, tvSeries, etc.)
        let url;

        if (titleType === "movie") {
            url = `https://api.themoviedb.org/3/movie/${tmdbId}/videos?api_key=9e1d1a23472226616cfee404c0fd33c1&language=fr`;
        } else if (titleType === "tvSeries" || titleType === "tvMiniSeries") {
            url = `https://api.themoviedb.org/3/tv/${tmdbId}/videos?api_key=9e1d1a23472226616cfee404c0fd33c1&language=fr`;
        } else {
            console.log("Type non supporté pour la bande-annonce.");
            return;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                showTrailer(data);
            })
            .catch(error => {
                console.log(error);
                showUnavailableMessage();
            });
    });
});

    function showTrailer(data) {
        if (data.results.length > 0) {
            let trailer = data.results.find(video => video.type.toLowerCase() === "trailer" && video.site.toLowerCase() === "youtube");
            if (trailer) {
                iframe.src = `https://www.youtube.com/embed/${trailer.key}?autoplay=1`;
                iframe.style.display = 'block';
                videoUnavailable.style.display = 'none';
            } else {
                showUnavailableMessage();
            }
        } else {
            showUnavailableMessage();
        }
        modal.style.display = 'block';
    }

    function showUnavailableMessage() {
        iframe.style.display = 'none';
        videoUnavailable.style.display = 'block';
        modal.style.display = 'block';
    }

    function closeModal() {
        modal.style.display = 'none';
        iframe.src = '';
        videoUnavailable.style.display = 'none';
    }

    document.getElementById('closeModal').addEventListener('click', closeModal);
});

        var alertElement = document.getElementById('myAlert');
  var initialOpacity = 1; // Opacité initiale (complètement visible)
  var fadeDuration = 5000; // Durée du fondu en millisecondes (2 secondes)

// Fonction pour réduire l'opacité progressivement

    alertElement.style.opacity = 1; // Afficher l'alerte

    // Faire disparaître l'alerte après 2 secondes avec un effet de fondu et un flou
    setTimeout(function() {
        fadeOutAndBlur();
    }, 2000);

    // Fonction pour réduire l'opacité progressivement et augmenter le flou
    function fadeOutAndBlur() {
        var currentTime = 0;
        var interval = 50; // Intervalle de mise à jour (50 ms)
        var fadeDuration = 500; // Durée du fondu en millisecondes (0.5 seconde)
        var maxBlur = 5; // Niveau maximal de flou

        var fadeInterval = setInterval(function() {
            currentTime += interval;
            var opacity = 1 - (currentTime / fadeDuration); // Calcul de l'opacité
            var blurAmount = (currentTime / fadeDuration) * maxBlur; // Calcul du niveau de flou

            alertElement.style.opacity = Math.max(opacity, 0); // Assurez-vous que l'opacité ne devienne pas négative
            alertElement.style.filter = `blur(${blurAmount}px)`; // Appliquer le flou

            if (currentTime >= fadeDuration) {
                clearInterval(fadeInterval); // Arrêtez l'intervalle lorsque l'opacité atteint 0
                alertElement.setAttribute('hidden', true); // Masquez complètement l'alerte
            }
        }, interval);
    }
       
       
    

    </script>

        <?php require "Views/view_footer.php"; ?>
