<?php
require "Views/view_navbar.php";

// Récupérer la variable 'retour' de l'URL
if(isset($_GET['retour'])){
    $retour = trim(e($_GET['retour']));
    switch ($retour) {
        case 1:
            $message = "Modification pris en compte";
            $alertClass = "alert-success";
            $image='icons8-check-50.png';
            break;
        case 0:
            $message = "Aucune modification";
            $alertClass = "alert-secondary";
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
?>

<style>
    .connect{
        margin-top: 250px;
    }

    .buttonLarge{
        height: 80px;
        background-color: #FFCC00 !important;
        border:2px solid #FFCC00;
    }
    .buttonLarge:hover{
        background: #b69202;
        border:2px solid #FFCC00;
    }

    .images{
        width: 90%;
        opacity: 0.3;
    }

    .item{
    margin-top:10px;
    margin-left: 10px;
    margin-right: 10px;
  }

  .collapsBody{
    background-color: black;
  }

  .bouton-favori{
    border-radius: 5px 5px 5px 5px;
    background-color: #FFCC00;
    padding: 10px 20px;
    font-size: 15px;
    color:white;
    border:1px solid #FFCC00;
 }
 .bouton-favori:hover{
    
    background-color: #b69202;
   
 }
 .collaps-beetwen{
    margin-top: 50px;
 }

 .titreTrouver{
    margin-top:100px
 }

 .favoris{
    margin-top: 400px;
 }

 .historique{
    margin-top: 400px;
 }

 .colapsFavorie{
    margin-bottom: 500px;
 }
 .histo{
   
    color:white;
 }
 

</style>

    <div id="fonctionalite" class="container connect">
        <div class="row">
            <div class="col-md-4">
                <h1 class="titreTrouver">Salut <?php echo $_SESSION['username']?></h1>
                
                <div style ="border-left:2px solid #FFCC00; padding-left: 6px;" >
                    <p>La création de compte sur notre site est une fonctionnalité révolutionnaire, conçue pour rendre votre expérience véritablement enchantée.
                    </p>
                </div>
            </div>
                <div class="mx-auto col-md-7">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img class="d-block w-100" src="Images/_2f221533-58bb-497e-806d-5add2e522048.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <a href='#historique'>
                                    <button id='favoriButton' class='bouton-favori'>
                                        Decouvrir votre
                                        Historique
                                        </button>
                                </a>
                            </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Images/_2abaf182-b6a4-47a4-b32f-a33481c1f963.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <a href='?controller=connect&action=settings'>
                                    <button id='favoriButton' class='bouton-favori'>
                                    Acceder
                                    aux parametres
                                    </button>
                                </a>
                            </div>
                    </div>
                    
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Images/_5b4cbf0b-0827-4bc1-ba32-34f9096f70b2.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <a href='#favoris'>
                                    <button id='favoriButton' class='bouton-favori'>
                                    Decouvrir vos
                                    Favoris
                                    </button>
                                </a>
                            </div>
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="Images/_41d30475-6fbc-41b9-9e6d-2c1c2646dfdb.jpeg" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <a href='?controller=connect&action=logout'>
                                    <button id='favoriButton' class='bouton-favori'>
                                    Deconnexion
                                    </button>
                                </a>
                            </div>
                    </div>
                    
                    </div>
                </div>
             </div>
            </div>
        </div>
    </div>

<div id="historique" class="container-fluid historique">
    <div class="row align-items-center">   
            <div class="col">
            <h1 class="titreTrouver">Historique</h1>
            
            <div style ="border-left:2px solid #FFCC00; padding-left: 6px;" >
                <p>
Redécouvrez vos explorations grâce à l'historique de vos recherches.
                </p>
            </div>
        </div>
        </div>    
    </div>
</div>


<div class="container-fluid">
<div class="collaps-beetwen">
<p>
  <button class="btn btn-primary btn-lg btn-block buttonLarge" type="button" data-toggle="collapse" data-target="#collapseRecherche" aria-expanded="false" aria-controls="collapseExample">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p class="histo">Recherche Avancée
                </p>
            </div>
        </div>
    </div>
  </button>
</p>
</div>
<div class="collapse" id="collapseRecherche">
  <div class="card card-body collapsBody">
  <?php
        if(isset($tab[0]) && sizeof($tab[0]["Recherche"]) > 0){
            foreach($tab[0]["Recherche"] as $historique){

                $motClee = $historique['motcle'];
                $time = $historique['rehcerchetime'];
                // Date donnée
                $dateDonnee = new DateTime($time);

                // Date actuelle
                $dateActuelle = new DateTime();

                // Calcul de la différence
                $intervalle = $dateActuelle->diff($dateDonnee);

                // Construction du message
                $message = "Il y a ";
                if ($intervalle->y > 0) {
                    $message .= $intervalle->y . " an" . ($intervalle->y > 1 ? "s" : "");
                } elseif ($intervalle->m > 0) {
                    $message .= $intervalle->m . " mois";
                } elseif ($intervalle->d > 0) {
                    $message .= $intervalle->d . " jour" . ($intervalle->d > 1 ? "s" : "");
                } elseif ($intervalle->h > 0) {
                    $message .= $intervalle->h . " heure" . ($intervalle->h > 1 ? "s" : "");
                } elseif ($intervalle->i > 0) {
                    $message .= $intervalle->i . " minute" . ($intervalle->i > 1 ? "s" : "");
                } else {
                    $message .= "quelques secondes";
                }


                // Affichage du résultat

                echo"
                 <div class='cardrecherche item' style='cursor: pointer;'>
                <div class='card-bodyrecherche'>
                 <h2 class='card-1recherche'>$motClee</h2>
                <p class='card-2recherche'>$message</p>
                 </div>
                 </div>";
            }
        }
        else{
            echo"
                    <div class='mx-auto row'>
                        <p>
                        <a href='?controller=recherche'>
                        <button id='favoriButton' class='bouton-favori'>Realiser un votre première recherche </button>
                        </a>
                        </p>  
                </div>
            ";
        }
    ?>
  <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
    <p>Resultat : <?php echo sizeof($tab[0]["Recherche"]); ?></p>
  </div>

</div>
</div>
    



<div class="collaps-beetwen">
<p>
  <button class="btn btn-primary btn-lg btn-block buttonLarge" type="button" data-toggle="collapse" data-target="#collapseLiens" aria-expanded="false" aria-controls="collapseExample">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p>Liens
                </p>
            </div>
        </div>
    </div>
  </button>
</p>
</div>
<div class="collapse" id="collapseLiens">
  <div class="card card-body collapsBody">
  <?php
        if(isset($tab[1]) && sizeof($tab[1]["Trouver"]) > 0){
            foreach($tab[1]["Trouver"] as $historique){

                $motClee = $historique['motcle'];
                $time = $historique['rehcerchetime'];
                // Date donnée
                $dateDonnee = new DateTime($time);

                // Date actuelle
                $dateActuelle = new DateTime();

                // Calcul de la différence
                $intervalle = $dateActuelle->diff($dateDonnee);

                // Construction du message
                $message = "Il y a ";
                if ($intervalle->y > 0) {
                    $message .= $intervalle->y . " an" . ($intervalle->y > 1 ? "s" : "");
                } elseif ($intervalle->m > 0) {
                    $message .= $intervalle->m . " mois";
                } elseif ($intervalle->d > 0) {
                    $message .= $intervalle->d . " jour" . ($intervalle->d > 1 ? "s" : "");
                } elseif ($intervalle->h > 0) {
                    $message .= $intervalle->h . " heure" . ($intervalle->h > 1 ? "s" : "");
                } elseif ($intervalle->i > 0) {
                    $message .= $intervalle->i . " minute" . ($intervalle->i > 1 ? "s" : "");
                } else {
                    $message .= "quelques secondes";
                }


                // Affichage du résultat

                echo"
                 <div class='cardrecherche item' style='cursor: pointer;'>
                <div class='card-bodyrecherche'>
                 <h2 class='card-1recherche'>$motClee</h2>
                    <p class='card-2recherche'>$message</p>
                 </div>
                 </div>";
            }
        }
        else{
            echo "
                    <div class='mx-auto row'>
                        <p>
                        <a href='?controller=trouver'>
                        <button id='favoriButton' class='bouton-favori'>Realiser un votre premier lien</button>
                        </a>
                        </p>  
                </div>";

        }
    ?>
  <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
    <p>Resultat : <?php echo sizeof($tab[1]["Trouver"]); ?></p>
  </div>

</div>
    
  </div>



<div class="collaps-beetwen">
<p>
  <button class="btn btn-primary btn-lg btn-block buttonLarge" type="button" data-toggle="collapse" data-target="#collapseRapprochement" aria-expanded="false" aria-controls="collapseExample">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p>Chemin le plus court
                </p>
            </div>
        </div>
    </div>
  </button>
</p>
</div>
<div class="collapse" id="collapseRapprochement">
  <div class="card card-body collapsBody">
  <?php
        if(isset($tab[2]) && sizeof($tab[2]["Rapprochement"]) > 0){
            foreach($tab[2]["Rapprochement"] as $historique){

                $motClee = $historique['motcle'];
                $time = $historique['rehcerchetime'];
                // Date donnée
                $dateDonnee = new DateTime($time);

                // Date actuelle
                $dateActuelle = new DateTime();

                // Calcul de la différence
                $intervalle = $dateActuelle->diff($dateDonnee);

                // Construction du message
                $message = "Il y a ";
                if ($intervalle->y > 0) {
                    $message .= $intervalle->y . " an" . ($intervalle->y > 1 ? "s" : "");
                } elseif ($intervalle->m > 0) {
                    $message .= $intervalle->m . " mois";
                } elseif ($intervalle->d > 0) {
                    $message .= $intervalle->d . " jour" . ($intervalle->d > 1 ? "s" : "");
                } elseif ($intervalle->h > 0) {
                    $message .= $intervalle->h . " heure" . ($intervalle->h > 1 ? "s" : "");
                } elseif ($intervalle->i > 0) {
                    $message .= $intervalle->i . " minute" . ($intervalle->i > 1 ? "s" : "");
                } else {
                    $message .= "quelques secondes";
                }


                // Affichage du résultat

                echo"
                 <div class='cardrecherche item' style='cursor: pointer;'>
                <div class='card-bodyrecherche'>
                 <h2 class='card-1recherche'>$motClee</h2>
                    <p class='card-2recherche'>$message</p>
                 </div>
                 </div>";
            }
        }
        else{
            echo "
                    <div class='mx-auto row'>
                        <p>
                        <a href='?controller=rapprochement'>
                        <button id='favoriButton' class='bouton-favori'>Realiser un votre premier rapprochement </button>
                        </a>
                        </p>  
                        
                </div>";

        }
    ?>
  <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
    <p>Resultat : <?php echo sizeof($tab[2]["Rapprochement"]); ?></p>
  </div>

</div>
    
  </div>
</div>

</div>

<div id="favoris" class="container-fluid favoris ">
    <div class="row align-items-center">   
            <div class="col">
            <h1 class="titreTrouver">Favoris</h1>
            
            <div style ="border-left:2px solid #FFCC00; padding-left: 6px;" >
                <p>Retrouvez facilement vos coups de cœur grâce à l'enregistrement de vos recherches favorites.
                </p>
            </div>
        </div>
        </div>    
    </div>
</div>
<div class="container-fluid colapsFavorie ">
<div class="collaps-beetwen">
<p>
  <button class="btn btn-primary btn-lg btn-block buttonLarge" type="button" data-toggle="collapse" data-target="#collapseRecherche" aria-expanded="false" aria-controls="collapseExample">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p>Favorie Acteur
                </p>
            </div>
        </div>
    </div>
  </button>
</p>
</div>
<div class="collapse" id="collapseRecherche">
  <div class="card card-body collapsBody">
  <?php
        $m = Model::getModel();
        if(isset($tab[3]) && sizeof($tab[3]["FavorieActeur"]) > 0){
            foreach($tab[3]["FavorieActeur"] as $historique){

                $id = $historique['acteurid'];
                $data = $m->getInfoActeur($id);
                $primaryName = isset($data['primaryname']) && $data['primaryname'] !== '' ? $data['primaryname'] : "Aucune Information";
                $type = isset($data['primaryprofession']) && $data['primaryprofession'] !== '' ? $data['primaryprofession'] : "Aucune Information";
                $date = isset($data['birthyear']) && $data['birthyear'] !== '' ? $data['birthyear'] : "Aucune Information";
            
                
                

                echo"
                <a href='?controller=home&action=information_acteur&id=$id' class='card-linkrecherche' style='text-decoration: none; color: inherit;'>
                <div class='cardrecherche item' style='cursor: pointer;'>
                <div class='card-bodyrecherche'>
                 <h2 class='card-1recherche'>$primaryName</h2>
                 <p class='card-2recherche'>Type : $type</p>
                 <p class='card-3recherche'>Date : $date</p>
                 </div>
                 </div>
                 </a>";
            }
        }
        else{
            echo"
                    <div class='mx-auto row'>
                        <p>
                        <a href='?controller=recherche'>
                        <button id='favoriButton' class='bouton-favori'>Decouvrez vos favoris</button>
                        </a>
                        </p>  
                </div>
            ";
        }
    ?>
  <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
    <p>Resultat : <?php echo sizeof($tab[3]["FavorieActeur"]); ?></p>
  </div>

</div>
</div>
    



<div class="collaps-beetwen">
<p>
  <button class="btn btn-primary btn-lg btn-block buttonLarge" type="button" data-toggle="collapse" data-target="#collapseLiens" aria-expanded="false" aria-controls="collapseExample">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p>Favorie Film
                </p>
            </div>
        </div>
    </div>
  </button>
</p>
</div>
<div class="collapse" id="collapseLiens">
  <div class="card card-body collapsBody">
  <?php
        $m = Model::getModel();
        if(isset($tab[4]) && sizeof($tab[4]["FavorieFilm"]) > 0){
            foreach($tab[4]["FavorieFilm"] as $historique){

                $id = $historique['filmid'];
                $data = $m->getInfoFilm($id);
                $primaryTitle = isset($data['primarytitle']) && $data['primarytitle'] !== '' ? $data['primarytitle'] : "Aucune Information";
                $type = isset($data['titletype']) && $data['titletype'] !== '' ? $data['titletype'] : "Aucune Information";
                $date = isset($data['startyear']) && $data['startyear'] !== '' ? $data['startyear'] : "Aucune Information";
                $genres = isset($data['genres']) && $data['genres'] !== '' ? $data['genres'] : "Aucune Information";
                

                echo"
                <a href='?controller=home&action=information_movie&id=$id' class='card-linkrecherche' style='text-decoration: none; color: inherit;'>
                <div class='cardrecherche item' style='cursor: pointer;'>
                <div class='card-bodyrecherche'>
                 <h2 class='card-1recherche'>$primaryTitle</h2>
                 <p class='card-2recherche'>Type : $type</p>
                 <p class='card-3recherche'>Date : $date</p>
                 <p class='card-4recherche'>Genres : $genres</p>
                 </div>
                 </div>
                 </a>";
            }
        }
        else{
            echo "
                    <div class='mx-auto row'>
                        <p>
                        <a href='?controller=recherche'>
                        <button id='favoriButton' class='bouton-favori'>Decouvrez vos favoris</button>
                        </a>
                        </p>  
                </div>";

        }
    ?>
  <div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
    <p>Resultat : <?php echo sizeof($tab[4]["FavorieFilm"]); ?></p>
  </div>

</div>
    
  </div>
  </div>

</div>

<script>

   // Supposons que l'ID de votre alerte est 'myAlert'
   var alertElement = document.getElementById('myAlert');
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

    