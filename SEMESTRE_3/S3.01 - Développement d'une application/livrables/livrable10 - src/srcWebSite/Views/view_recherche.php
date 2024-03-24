<?php require "Views/view_navbar.php"; ?>
<style>

#fonctionalite{
    margin-top: 150px;
    padding-bottom: 100px;
 }

 .boutonCarouselTitle{
    margin-bottom: 400px;
    margin-top: 5px;
 }
 .bouton-favori{
    border-radius: 10px 5%;
    background-color: #FFCC00;
    padding: 10px 20px;
    font-size: 15px;
 }

 .carousel-text{
    margin-top : 200px;
    margin-left: 50px;
 }
 
 .paragrapheRecherche{
    padding-top: 20px;
    margin-bottom: 50px
 }
 .titreRecherche{
    margin-top:100px
 }
 .images{
    opacity: 0.3;
 }
 .boutonFonctionnalite{
    margin-top: -20px;
    margin-bottom: 20px;
 }
 
 .label{
    margin-bottom: 20px;
 }

 .carousel-textLabel{
    margin-left: 50px;
 }

 .recherche{
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
 }

</style>

<div id="recherche" class="container">
    <div class="row align-items-center">   
        <h1 class="titreRecherche">Recherche Avancée</h1>
        <p  style="padding-left: 6px; padding-bottom : 20px;font-size:20px;" class="paragrapheRecherche">Bienvenue sur Findercine, où chaque recherche est une porte ouverte vers un univers 
            riche et varié de divertissement...</p>
    </div>
</div>

<div class="container">
<div class="row align-items-center">
    <a href='#fonctionalite' style="text-decoration: none;">
        <button type="submit" id="favoriButton" class="btn btn-warning mx-auto boutonFonctionnalite" style =" color: white;display: block;" >
            Fonctionnalite
        </button>
    </a>
    </div>
    </div>
</div>
    

<div class="container">
<div class="row">
<div class="formulaire mx-auto col-md recherche">
        <div class="d-flex align-items-center">
        <img src="./Images/searchjaune.png" alt="Filtre" style="margin-right: -37px;">
        <h3 class="m-5">Recherche Avancée</h3>
        </div>
        <form action="?controller=recherche&action=rechercher" method="post" class="m-5">
        <label class="labelfiltre form-label label" for="typeselection">Type de recherche</label>
                                
                                
                                <div class="mb-5">
                                    <select class="form-select" id="typeselection" name="typeselection" style="border-radius: 10px 10px 10px 10px; width: 146px;height: 40px;text-align: center;">
                                        <option value="titre">Titre</option>
                                        <option value="personne">Personne</option>
                                    </select>
                                </div>

        
        
                                <div class="mb-5">
                                    <label class="labelfiltre label" for="search" id="labelForSearch">Titre</label>
                                    <input type="text" class="form-control" id="search" name="search" placeholder="Entrez le titre">
                                    <div id="search-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>
                                </div>

                                <div class="form-group mb-5">
                                    <label class="label" for="modeRecherche">Mode de Recherche:</label>
                                    <select class="form-control" id="modeRecherche" name="modeRecherche">
                                        <option value="egal" selected>Recherche Précise</option>
                                        <option value="like">Recherche Composée</option>
                                        <option value="similarity">Recherche Approximative</option>
                                    </select>
                                </div>

                                <div id="filter-box-titre" style="display: none;">


                                                    <div class="mb-5">
                                                            <label  class="labelfiltre label"  for="types" class="form-label">Type du titre</label>
                                                            <select class="form-select filter-input" id="choices-multiple-remove-button1" name="types[]" placeholder="Choisir 3 genres MAX" multiple>
                                                                <option value="tvShort">tvShort</option>
                                                                <option value="tvMovie">tvMovie</option>
                                                                <option value="tvMiniSeries">tvMiniSeries</option>
                                                                <option value="videoGame">videoGame</option>
                                                                <option value="short">short</option>
                                                                <option value="tvSeries">tvSeries</option>
                                                                <option value="movie">movie</option>
                                                                <option value="tvEpisode">tvEpisode</option>
                                                                <option value="video">video</option>
                                                                <option value="tvSpecial">tvSpecial</option>
                                                                <option value="tvPilot">tvPilot</option>
                                                            </select>
                                                    </div>

                                                    <label class="labelfiltre form-label label"  for="dateSortieMin">L'année</label>
                                                    <div class="mb-5">
                                                            <input type="text" class="mb-1 form-control filter-input" id="dateSortieMin" name="dateSortieMin" placeholder="Année minimale">
                                                            <div   id="dateSortieMin-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1000 - max 2025) </div>
                                                            <input type="text" class="form-control  filter-input" id="dateSortieMax" name="dateSortieMax" placeholder="Année maximale">
                                                            <div id="dateSortieMax-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1000 - max 2025)</div>
                                                            <div id="dateSortieRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas être égaux.</div>
                                                    </div>

                                                    <label class="labelfiltre form-label label">Durée (en minutes)</label>
                                                    <div class="mb-5">
                                                            <input type="text" class="mb-1 form-control filter-input" id="dureeMin" name="dureeMin" placeholder="Durée minimale (en minute)">
                                                            <div id="dureeMin-error" style="display: none; color: red;">Veuillez entrer une durée valide (min 0 - max 100000)</div>
                                                            <input type="text" class="form-control filter-input" id="dureeMax" name="dureeMax" placeholder="Durée maximale (en minute)">
                                                            <div id="dureeMax-error" style="display: none; color: red;">Veuillez entrer une durée valide (min 0 - max 100000)</div>
                                                            <div id="dureeRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas être égaux.</div>
                                                    </div>

                                                    <label  class="labelfiltre label" class="form-label">Genres</label>
                                                    <div class="mb-5">
                                                                <select   class="labelfiltre" id="choices-multiple-remove-button2" name="genres[]" placeholder="Choisir 3 genres MAX" multiple>   
                                                                <option value="Game-Show">Game-Show</option>
                                                                <option value="Family">Family</option>
                                                                <option value="Music">Music</option>
                                                                <option value="Reality-TV">Reality-TV</option>
                                                                <option value="Comedy">Comedy</option>
                                                                <option value="Western">Western</option>
                                                                <option value="Short">Short</option>
                                                                <option value="Crime">Crime</option>
                                                                <option value="War">War</option>
                                                                <option value="Romance">Romance</option>
                                                                <option value="Biography">Biography</option>
                                                                <option value="Drama">Drama</option>
                                                                <option value="Mystery">Mystery</option>
                                                                <option value="Sci-Fi">Sci-Fi</option>
                                                                <option value="Fantasy">Fantasy</option>
                                                                <option value="Adventure">Adventure</option>
                                                                <option value="Documentary">Documentary</option>
                                                                <option value="Action">Action</option>
                                                                <option value="Animation">Animation</option>
                                                                <option value="Sport">Sport</option>
                                                                <option value="Horror">Horror</option>
                                                                <option value="Adult">Adult</option>
                                                                <option value="News">News</option>
                                                                <option value="Talk-Show">Talk-Show</option>
                                                                <option value="Film-Noir">Film-Noir</option>
                                                                <option value="Musical">Musical</option>
                                                                <option value="Thriller">Thriller</option>
                                                                <option value="History">History</option>
                                                            </select>
                                                    </div>

                                                    <label class="labelfiltre form-label label">Note</label>
                                                    <div class="mb-5">
                                                            <input type="text" class="mb-1 form-control filter-input" id="noteMin" name="noteMin" placeholder="Note minimale (sur 10)">
                                                            <div id="noteMin-error" style="display: none; color: red;">Veuillez entrer une note valide (min 0.0 - max 10.O)</div>
                                                            <input type="text" class="form-control filter-input" id="noteMax" name="noteMax" placeholder="Note maximale (sur 10)">
                                                            <div id="noteMax-error" style="display: none; color: red;">Veuillez entrer une note valide (min 0.0 - max 10.O)</div>
                                                            <div id="noteRange-error" style="display: none; color: red;">La note minimale doit être inférieure à la note maximale et ne pas être égaux.</div>
                                                    </div>



                                </div><!-- filtre titre -->
                                <div id="filter-box-personne" style="display: none;">

                                                    <label class="labelfiltre form-label label"  for="dateNaissanceMin">L'année de naissance</label>
                                                    <div class="mb-5">
                                                            <input type="text" class="mb-1 form-control filter-input" id="dateNaissanceMin" name="dateNaissanceMin" placeholder="Année minimale">
                                                            <div   id="dateNaissanceMin-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1- max 2025) </div>
                                                            <input type="text" class="form-control  filter-input" id="dateNaissanceMax" name="dateNaissanceMax" placeholder="Année maximale">
                                                            <div id="dateNaissanceMax-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1 - max 2025)</div>
                                                            <div id="dateNaissanceRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas être égaux.</div>
                                                    </div>
                                                     <label class="labelfiltre form-label label"  for="dateDecesMin">L'année de décès</label>
                                                    <div class="mb-5">
                                                            <input type="text" class="mb-1 form-control filter-input" id="dateDecesMin" name="dateDecesMin" placeholder="Année minimale">
                                                            <div   id="dateDecesMin-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1- max 2025) </div>
                                                            <input type="text" class="form-control  filter-input" id="dateDecesMax" name="dateDecesMax" placeholder="Année maximale">
                                                            <div id="dateDecesMax-error" style="display: none; color: red;">Veuillez entrer une année valide (min 1 - max 2025)</div>
                                                            <div id="dateDecesRange-error" style="display: none; color: red;">L'année minimale doit être inférieure à l'année maximale et ne pas être égaux.</div>
                                                    </div>
                            
                                                    <select id="choices-multiple-remove-button3" name="metier[]" placeholder="Choisir 3 professions MAX" multiple>
                                                        <option value="actor">Actor</option>
                                                        <option value="talent_agent">Talent Agent</option>
                                                        <option value="podcaster">Podcaster</option>
                                                        <option value="soundtrack">Soundtrack</option>
                                                        <option value="electrical_department">Electrical Department</option>
                                                        <option value="writer">Writer</option>
                                                        <option value="manager">Manager</option>
                                                        <option value="script_department">Script Department</option>
                                                        <option value="make_up_department">Make-Up Department</option>
                                                        <option value="art_department">Art Department</option>
                                                        <option value="director">Director</option>
                                                        <option value="art_director">Art Director</option>
                                                        <option value="music_department">Music Department</option>
                                                        <option value="production_department">Production Department</option>
                                                        <option value="publicist">Publicist</option>
                                                        <option value="location_management">Location Management</option>
                                                        <option value="visual_effects">Visual Effects</option>
                                                        <option value="cinematographer">Cinematographer</option>
                                                        <option value="special_effects">Special Effects</option>
                                                        <option value="costume_designer">Costume Designer</option>
                                                        <option value="casting_director">Casting Director</option>
                                                        <option value="music_artist">Music Artist</option>
                                                        <option value="transportation_department">Transportation Department</option>
                                                        <option value="production_designer">Production Designer</option>
                                                        <option value="editorial_department">Editorial Department</option>
                                                        <option value="casting_department">Casting Department</option>
                                                        <option value="executive">Executive</option>
                                                        <option value="legal">Legal</option>
                                                        <option value="composer">Composer</option>
                                                        <option value="actress">Actress</option>
                                                        <option value="sound_department">Sound Department</option>
                                                        <option value="editor">Editor</option>
                                                        <option value="costume_department">Costume Department</option>
                                                        <option value="assistant">Assistant</option>
                                                        <option value="stunts">Stunts</option>
                                                        <option value="animation_department">Animation Department</option>
                                                        <option value="camera_department">Camera Department</option>
                                                        <option value="set_decorator">Set Decorator</option>
                                                        <option value="producer">Producer</option>
                                                        <option value="production_manager">Production Manager</option>
                                                        <option value="choreographer">Choreographer</option>
                                                        <option value="assistant_director">Assistant Director</option>
                                                        <option value="miscellaneous">Miscellaneous</option>
                                                    </select>

                                </div><!-- filtre personne -->

                <button type="submit" id="buttonrechercher" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block;" >Rechercher</button>
                                            
        </form>
    </div>    
</div>
    </div>
    <div id="fonctionalite" class="container carousel">
        <div class="row">
            <div class="col-md-4">
                <h1 class="carousel-text">Fonctionnalité</h1>
                <p style="border-left:2px solid #FFCC00;padding-left: 6px;" class="carousel-textLabel">Découvrez toutes nos fonctionnalités, telles que le rapprochement et le lien
                </p>
            </div>
                <div class="mx-auto col-md-7">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="2000">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block w-100" src="Images/link.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h2>Liens</h2>
                                <a href='?controller=trouver' style="text-decoration: none;">
                                    <button type="submit" id="favoriButton" class="btn btn-warning mx-auto" style ="color: black ;display: block; margin-top: 10px;" >
                                        Decouvrir Liens
                                    </button>
                                </a>
                            </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Images/rapprochement.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h2>Rapprochement</h2>
                                <a href='?controller=rapprochement' style="text-decoration: none;">
                                    <button type="submit" id="favoriButton" class="btn btn-warning mx-auto" style ="color: black ;display: block; margin-top: 10px;" >
                                        Decouvrir Chemin le plus court
                                    </button>
                                </a>
                            </div>
                    </div>
                    
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon chapeau" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon chapeau" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
             </div>
            </div>
        </div>
    </div>
      
      


<script>
$(document).ready(function() {
    initChoices();
    handleFormValidation();
    toggleFiltersOnSelection();
    placeholderSearch() 
});

function initChoices() {
    new Choices('#choices-multiple-remove-button1', {
        removeItemButton: true,
        maxItemCount: 3,
        searchResultLimit: 5
    });
    new Choices('#choices-multiple-remove-button2', {
        removeItemButton: true,
        maxItemCount: 3,
        searchResultLimit: 5
    });
    new Choices('#choices-multiple-remove-button3', {
        removeItemButton: true,
        maxItemCount: 3,
        searchResultLimit: 5
    });
}
function placeholderSearch() {
    $('#typeselection').change(function(){
        var selection = $(this).val();
        if(selection == 'titre'){
            $('#search').attr('placeholder', 'Entrez le titre');
            $('#labelForSearch').text('Titre'); 
        } else if(selection == 'personne'){
            $('#search').attr('placeholder', 'Entrez le nom d\'une personne');
            $('#labelForSearch').text('Nom'); 
        }
    });
}

function toggleFiltersOnSelection() {
    $('#typeselection').change(function() {
        var typeSelection = $(this).val();
        if (typeSelection === 'titre') {
            $('#filter-box-titre').show();
            $('#filter-box-personne').hide();
        } else {
            $('#filter-box-personne').show();
            $('#filter-box-titre').hide();
        }
        resetFormFields();
    }).trigger('change');
}

function resetFormFields() {
    $('#search').val('');
    $('#dateSortieMin').val('');
    $('#dateSortieMax').val('');
    $('#dureeMin').val('');
    $('#dureeMax').val('');
    $('#noteMin').val('');
    $('#noteMax').val('');
    $('#votesMin').val('');
    $('#votesMax').val('');
    $('#dateNaissanceMin').val('');
    $('#dateNaissanceMax').val('');
    $('#dateDecesMin').val('');
    $('#dateDecesMax').val('');
   
    $('.error').hide();
}



function handleFormValidation() {
    $('form').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire

        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var searchInput = $('#search').val().trim();
        var dateSortieMinValue = $('#dateSortieMin').val().trim();
        var dateSortieMaxValue = $('#dateSortieMax').val().trim();
        var dureeMinValue = $('#dureeMin').val().trim();
        var dureeMaxValue = $('#dureeMax').val().trim();
        var noteMaxValue = $('#noteMax').val().trim();
        var noteMinValue = $('#noteMin').val().trim();
        var dateNaissanceMinValue = $('#dateNaissanceMin').val().trim();
        var dateNaissanceMaxValue = $('#dateNaissanceMax').val().trim();
        var dateDecesMinValue = $('#dateDecesMin').val().trim();
        var dateDecesMaxValue = $('#dateDecesMax').val().trim();




        debugger;


        // Valide chaque champ selon les critères spécifiques
        if (!searchInput) {
            $('#search-error').show();
            isValid = false; // Formulaire invalide
        }

        // Validation des années de sortie
        if (dateSortieMinValue && (!/^(1\d{3}|20[0-1]\d|202[0-5])$/.test(dateSortieMinValue))) {
            $('#dateSortieMin-error').show();
            isValid = false;
        } 
        if (dateSortieMaxValue && (!/^(1\d{3}|20[0-1]\d|202[0-5])$/.test(dateSortieMaxValue))) {
            $('#dateSortieMax-error').show();
            isValid = false;
        }
        if (dateSortieMinValue && dateSortieMaxValue && (parseInt(dateSortieMinValue) > parseInt(dateSortieMaxValue) || parseInt(dateSortieMinValue) == parseInt(dateSortieMaxValue))){
            $('#dateSortieRange-error').show();
            $('#dateSortieMax-error').hide();
            $('#dateSortieMin-error').hide();
            isValid = false;
        }

        // Validation des durées
        if (dureeMinValue && (!/^(?:[0-9]|[1-9]\d{1,4}|100000)$/.test(dureeMinValue))) {
            $('#dureeMin-error').show();
            isValid = false;
        }
        if (dureeMaxValue && (!/^(?:[0-9]|[1-9]\d{1,4}|100000)$/.test(dureeMaxValue))) {
            $('#dureeMax-error').show();
            isValid = false;
        }
        if (dureeMinValue && dureeMaxValue && (parseInt(dureeMinValue) > parseInt(dureeMaxValue) || parseInt(dureeMinValue) == parseInt(dureeMaxValue))) {
            $('#dureeRange-error').show();
            $('#dureeMax-error').hide();
            $('#dureeMin-error').hide();
            isValid = false;
        }
        if (noteMinValue && !/^(10(\.0)?|[0-9](\.\d)?)$/.test(noteMinValue)) {
            $('#noteMin-error').show();
            isValid = false;
        }

        if (noteMaxValue && !/^(10(\.0)?|[0-9](\.\d)?)$/.test(noteMaxValue)) {
            $('#noteMax-error').show();
            isValid = false;
        }
        if (noteMinValue && noteMaxValue && (parseInt(noteMinValue) > parseInt(noteMaxValue) || parseInt(noteMinValue) == parseInt(noteMaxValue))) {
            $('#noteRange-error').show();
            $('#noteMax-error').hide();
            $('#noteMin-error').hide();
            isValid = false;
        
        }
        if (dateNaissanceMinValue && (!/^([1-9]|[1-9]\d{1,2}|1\d{3}|20[0-2][0-5])$/.test(dateNaissanceMinValue))) {
            $('#dateNaissanceMin-error').show();
            isValid = false;
        } 
        if (dateNaissanceMaxValue && (!/^([1-9]|[1-9]\d{1,2}|1\d{3}|20[0-2][0-5])$/.test(dateNaissanceMaxValue))) {
            $('#dateNaissanceMax-error').show();
            isValid = false;
        }
        if (dateNaissanceMinValue && dateNaissanceMaxValue && (parseInt(dateNaissanceMinValue) > parseInt(dateNaissanceMaxValue) || parseInt(dateNaissanceMinValue) == parseInt(dateNaissanceMaxValue))){
            $('#dateNaissanceRange-error').show();
            $('#dateNaissanceMin-error').hide();
            $('#dateNaissanceMax-error').hide();
            isValid = false;
        }
        if (dateDecesMinValue && (!/^([1-9]|[1-9]\d{1,2}|1\d{3}|20[0-2][0-5])$/.test(dateDecesMinValue))) {
            $('#dateDecesMin-error').show();
            isValid = false;
        } 
        if (dateDecesMaxValue && (!/^([1-9]|[1-9]\d{1,2}|1\d{3}|20[0-2][0-5])$/.test(dateDecesMaxValue))) {
            $('#dateDecesMax-error').show();
            isValid = false;
        }
        if (dateDecesMinValue && dateDecesMaxValue && (parseInt(dateDecesMinValue) > parseInt(dateDecesMaxValue) || parseInt(dateDecesMinValue) == parseInt(dateDecesMaxValue))){
            $('#dateDecesRange-error').show();
            $('#dateDecesMin-error').hide();
            $('#dateDecesMax-error').hide();
            isValid = false;
        }
        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#search, #dateSortieMin, #dateSortieMax, #dureeMin, #dureeMax,#noteMin, #noteMax,#votesMin,#votesMax,#dateNaissanceMin,#dateNaissanceMax, #dateDecesMin,#dateDecesMax').on('input', function() {
        var errorId = '#' + $(this).attr('id') + '-error';
        $(errorId).hide();
    });
    $('#dateSortieMin, #dateSortieMax').on('input', function() {
        $('#dateSortieRange-error').hide();
    });
    $('#dureeMin, #dureeMax').on('input', function() {
        $('#dureeRange-error').hide();
    });
    $('#noteMin, #noteMax').on('input', function() {
        $('#noteRange-error').hide();
    });
    $('#dateNaissanceMax, #dateNaissanceMin').on('input', function() {
        $('#dateNaissanceRange-error').hide();
    });
    $('#dateDecesMax, #dateDecesMin').on('input', function() {
        $('#dateDecesRange-error').hide();
    });
}


</script>






<?php require "Views/view_footer.php"; ?>