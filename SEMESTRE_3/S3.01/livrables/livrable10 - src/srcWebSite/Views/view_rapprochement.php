<?php require "Views/view_navbar.php"; ?>
<style>


 #imageRapprochement{
    width : 50px;
    margin-right: -37px;
 }

#fonctionalite{
    margin-top: 150px;
    padding-bottom: 100px;
 }

 .titreRapprochement{
    margin-top:100px
 }

 .paragrapheRapprochement{
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
 .carousel-textLabel{
    margin-left: 50px;
 }

 .images{
    opacity: 0.3;
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

  .rapprochement{
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
  }
</style>

<!-- <div id="rapprochement" class="container">
    <div class="row align-items-center">   
            <h1 class="titreRapprochement">Rapprochement</h1>
            
            <p class="paragrapheRapprochement">Bienvenue sur Findercine, où chaque recherche est une porte ouverte vers un univers 
            riche et varié de divertissement...</p>   
    </div>
</div> -->
<div id="rapprochement" class="container">
    <div class="row align-items-center">   
            <h1 class="titreRapprochement">Chemin le plus court</h1>
            
            <p  style="padding-left: 6px; padding-bottom : 20px;font-size:20px;" class="paragrapheRapprochement">Découvrez "Chemin le plus court" sur Findercine et parcourez les réseaux d'interactions du monde du divertissement. Cet outil astucieux vous permet de dévoiler les connexions les moins évidentes entre vos artistes et œuvres de prédilection. Que ce soit pour identifier les collaborations entre deux acteurs ou tracer les itinéraires croisés de différents projets cinématographiques, "Chemin le plus court" est votre allié pour révéler les chemins les plus courts et les plus surprenants qui unissent le septième art.
</p>
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
<div class="formulaire mx-auto col-md rapprochement">
        <div class="d-flex align-items-center">
        <img id="imageRapprochement" src="./Images/networkjaune.png" alt="Filtre">
        <h3 class="m-5">Chemin le plus court</h3>
        </div>
        <form action="?controller=rapprochement&action=rapprochement" method="post" class="m-5">

                                <label class="labelfiltre form-label label" for="typeselection">Trouver un rapprochement par rapport au :</label>
                                <div class="mb-5">
                                    <select class="form-select" id="typeselection" name="typeselection" style="border-radius: 10px 10px 10px 10px; width: 146px;height: 40px;text-align: center;">
                                        <option value="titre">Titre</option>
                                        <option value="personne">Personne</option>
                                    </select>
                                </div>

                                <label  class="labelfiltre form-label label" for="typeselectionRapo">Type de Rapprochement</label>
                                <div class="mb-5">
                                    <select class="form-select" id="typeselectionRapo" name="typeselectionRapo" style="border-radius: 10px 10px 10px 10px; width: 146px;height: 40px;text-align: center;">
                                        <option value="soft">Relatif</option>
                                        <option value="hard">Approfondi</option>
                                    </select>
                                </div>
                                
                                <div id="messageInfo" class="formulaire" style="display: none;">
                                <img style="transform: scale(0.7);" src="./images/icons8-warning-48.png">
                                <p id="monParagraphe" class="messageInfoText"></p>
                                </div>
                                


                                <div id="filter-box-titre" style="display: none;">
                                                <div class="row">
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label label"  for="titre1">Titre n°1 : </label>
                                                                    <div class=" d-flex align-items-start">
                                                                            <input type="text" class="mb-1 form-control filter-input" style = "border-top-left-radius: 0; border-bottom-left-radius: 0;" id="titre1" name="titre1" placeholder="Titre n°1">
                                                                            

                                                                    </div>
                                                                    <div id="titre1-error" style="display: none; color: red;">Veuillez sélectionner un titre. </div>
                                                                     
                                                            </div> 
                                                            <div class="col-md-2"></div>
                                                            <div class ="col-md-5 mx-auto">
                                                                    <label class="labelfiltre form-label label"  for="titre2">Titre n°2 : </label>
                                                                    <div class="d-flex align-items-start">
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
                <p style="border-left:2px solid #FFCC00;padding-left: 6px;" class="carousel-textLabel">Découvrez toutes nos fonctionnalités, telles que la Recherche et le Lien.
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
    document.getElementById("typeselectionRapo").addEventListener("change", function() {
    var selectedOption = this.value;
    var messageInfoDiv = document.getElementById("messageInfo");
    var monParagraphe = document.getElementById("monParagraphe");
    var selectOption = document.getElementById("typeselection").value;
    

    if (selectedOption === "hard") {
        messageInfoDiv.style.display = "block"; 
        monParagraphe.textContent = "Attention avec se mode nous allons approfondir le rapprochement le rendant plus précis et plus couteux";
    }
    else {
     messageInfoDiv.style.display = "none";   
    }        
});

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