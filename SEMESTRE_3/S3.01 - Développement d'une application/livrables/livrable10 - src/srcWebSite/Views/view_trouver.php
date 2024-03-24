<?php require "Views/view_navbar.php"; ?>
<style>
 #imageLien{
    width : 50px;
    margin-right: -37px;
 }

#fonctionalite{
    margin-top: 150px;
    padding-bottom: 100px;
 }

 .titreTrouver{
    margin-top:100px
 }

 .paragrapheTrouver{
    padding-top: 20px;
    margin-bottom: 50px
 }
 
 #carousel{
    margin-top: 150px;
    padding-bottom: 100px;
 }

 .bouton-favori{
    border-radius: 10px 5%;
    background-color: #FFCC00;
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

 .images{
    opacity: 0.3;
 }

 .carousel-textLabel{
    margin-left: 50px;
 }

 .boutonFonctionnalite{
    margin-top: -10px;
    margin-bottom: 20px
 }

 .label{
    margin-bottom: 20px;
 }

 .messageInfoText{
    padding-left: 10px;
 }
 
 #messageInfo{
    margin-top: -40px;
    margin-bottom: 40px;
  }

  .trouver{
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
  }
</style>

<div id="liens" class="container">
    <div class="row align-items-center">   
            <h1 class="titreTrouver">Liens</h1>
            
            <p class="paragrapheTrouver" style="padding-left: 6px; padding-bottom : 20px;font-size:20px;">
            Découvrez les connexions inattendues entre vos personnalités et œuvres cinématographiques préférées. Que vous souhaitiez dénicher les projets partagés entre deux acteurs, ou identifier les films et séries où ils ont collaboré, "Liens" est votre outil idéal pour explorer ces intersections fascinantes.</p>
            
        </div>    
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
<div class="formulaire mx-auto col-md trouver">
        <div class="d-flex align-items-center">

        <img src="./Images/lienjaune.png" alt="Filtre" style="margin-right: -37px;">

        <h3 class="m-5">Liens</h3>
        </div>
        <form action="?controller=trouver&action=trouver" method="post" class="m-5">

                                <label class="labelfiltre orm-label label" for="typeselection">Trouver les liens par rapport au :</label>
                                <div class="mb-5">
                                    <select class="form-select" id="typeselection" name="typeselection" style="border-radius: 10px 10px 10px 10px; width: 146px;height: 40px;text-align: center;">
                                        <option value="titre">Titre</option>
                                        <option value="personne">Personne</option>
                                    </select>
                                </div>

                                
                                <div id="messageInfo" class="formulaire" style="display: none;">
                                <img style="transform: scale(0.7);" src="./images/icons8-warning-48.png">
                                <p style id="monParagraphe" class="messageInfoText"><img style="transform: scale(0.7);" src="./images/icons8-warning-48.png"></p>
                                </div>


                                <div id="filter-box-titre" style="display: none;">
                                                <div class="row">
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label label"  for="titre1">Titre n°1 : </label>
                                                                    <div class=" d-flex align-items-start">
                                                                    <select id="selectOption1" class="custom-select" name="categorytitre1" id="categorytitre1" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                                                <option value="all">Tout</option>
                                                                                <option value="movie">Movie</option>
                                                                                <option value="tvSeries">TV Series</option>
                                                                                <option value="tvEpisode">TV Episode</option>
                                                                                <option value="video">Video</option>
                                                                                <option value="tvSpecial">TV Special</option>
                                                                                <option value="tvPilot">TV Pilot</option>
                                                                                <option value="short">Short</option>
                                                                                <option value="videoGame">Video Game</option>
                                                                                <option value="tvMiniSeries">TV Mini-Series</option>
                                                                                <option value="tvMovie">TV Movie</option>
                                                                                <option value="tvShort">TV Short</option>
                                                                            </select>
                                                                            <input type="text" class="mb-1 form-control filter-input" style = "border-top-left-radius: 0; border-bottom-left-radius: 0;" id="titre1" name="titre1" placeholder="Titre n°1">
                                                                            

                                                                    </div>
                                                                    <div id="titre1-error" style="display: none; color: red;">Veuillez sélectionner un titre. </div>
                                                                     
                                                            </div> 
                                                            <div class="col-md-2"></div>
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label label"  for="titre2">Titre n°2 : </label>
                                                                    <div class="d-flex align-items-start">
                                                                            <select id="selectOption2" class="custom-select" name="categorytitre2" id="categorytitre2" style="max-width: 120px; border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                                                                <option value="all">Tout</option>
                                                                                <option value="movie">Movie</option>
                                                                                <option value="tvSeries">TV Series</option>
                                                                                <option value="tvEpisode">TV Episode</option>
                                                                                <option value="video">Video</option>
                                                                                <option value="tvSpecial">TV Special</option>
                                                                                <option value="tvPilot">TV Pilot</option>
                                                                                <option value="short">Short</option>
                                                                                <option value="videoGame">Video Game</option>
                                                                                <option value="tvMiniSeries">TV Mini-Series</option>
                                                                                <option value="tvMovie">TV Movie</option>
                                                                                <option value="tvShort">TV Short</option>
                                                                            </select>
                                                                            <input type="text" class="mb-1 form-control filter-input" style = "border-top-left-radius: 0; border-bottom-left-radius: 0;" id="titre2" name="titre2" placeholder="Titre n°2">

                                                                    </div>
                                                                    <div id="titre2-error" style="display: none; color: red;">Veuillez sélectionner un titre. </div>

                                                            </div> 
                                                </div>  
                                </div><!-- filtre titre -->
                                <div id="filter-box-personne" style="display: none;">

                                                <div class="row">
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label label"  for="personne">Personne n°1 : </label>
                                                                    <div class="d-flex align-items-start">
                                                                            <input type="text" class="mb-1 form-control filter-input" id="personne1" name="personne1" placeholder="Personne n°1">
                                                                    </div>
                                                                    <div id="personne1-error" style="display: none; color: red;">Veuillez sélectionner une personne. </div>

                                                            </div> 
                                                            <div class="col-md-2"></div>
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label label"  for="personne2">Personne n°2 : </label>
                                                                    <div class="d-flex align-items-start">
                                                                            <input type="text" class="mb-1 form-control filter-input" id="personne2" name="personne2" placeholder="Personne n°2">
                                                                    </div>
                                                                    <div id="personne2-error" style="display: none; color: red;">Veuillez sélectionner une personne. </div>

                                                            </div> 
                                                </div> 

                                </div><!-- filtre personne -->

                <button type="submit" id="buttontrouver" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block;" >Trouver</button>
                                            
        </form>
       </div>
    </div>
</div>
    <div id="fonctionalite" class="container">
        <div class="row">
            <div class="col-md-4">
                <h1 class="carousel-text">Fonctionnalité</h1>
                <p  style="border-left:2px solid #FFCC00;padding-left: 6px;" class="carousel-textLabel">Découvrez toutes nos fonctionnalités, telles que la recherche et le rapprochement.
                </p>
            </div>
                <div class="mx-auto col-md-7">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block w-100" src="Images/recherche.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h2>Recherche</h2>
                                <a href='?controller=recherche' style="text-decoration: none;">
                                    <button type="submit" id="favoriButton" class="btn btn-warning mx-auto" style ="color: black ;display: block; margin-top: 10px;" >
                                        Decouvrir Recherche
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
    handleFormValidation();
    toggleFiltersOnSelection();

});
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
    $('#titre1').val('');
    $('#titre2').val('');
    $('#personne1').val('');
    $('#personne2').val('');
  
   
    $('.error').hide();
}



function handleFormValidation() {
    $('form').submit(function(e) {
        var isValid = true;
        var typeSelection = $('#typeselection').val();
        $('.error').hide(); // Cache tous les messages d'erreur
        
        if (typeSelection === 'titre') {
            var titre1 = $('#titre1').val().trim();
            var titre2 = $('#titre2').val().trim();
            if (!titre1) {
                $('#titre1-error').show();
                isValid = false;
            }
            if (!titre2) {
                $('#titre2-error').show();
                isValid = false;
            }
        } else if (typeSelection === 'personne') {
            var personne1 = $('#personne1').val().trim();
            var personne2 = $('#personne2').val().trim();
            if (!personne1) {
                $('#personne1-error').show();
                isValid = false;
            }
            if (!personne2) {
                $('#personne2-error').show();
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#titre1, #titre2, #personne1, #personne2').on('input', function() {
        var errorId = '#' + $(this).attr('id') + '-error';
        $(errorId).hide();
    });
}


</script>






<?php require "Views/view_footer.php"; ?>