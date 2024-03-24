<?php require "Views/view_navbar.php"; ?>
<style>
  .item{
    margin-top:40px;
    margin-left: 10px;
    margin-right: 10px;
  }

  .relation{
    justify-items: center;
    margin-bottom: 50px;
    margin-top: 10px;
    color: #FFCC00;
  }

  .result{
    margin-top: 20px;
  }


.bouton-favori{
    border-radius: 10px 5%;
    background-color: #FFCC00;
    padding: 5px 10px;
 }

.notFoundDiv{
  margin-left: 450px;
  padding-bottom: 100px
}

.notFoundParagraphe{
  font-size: 16px;
  font-weight: bold;
  color: #888; /* Couleur du texte pour le cas où il n'y a pas de commentaires */
  text-align: center;
  margin-top: 20px; /* Espace entre le message et le reste du contenu */
}

</style>
<div class="row" style="margin-top: 120px;">
    <div class="col-md-8 m-5">
        <h1>Résultats entre "<?php echo $result[0]["search1"]?>" et "<?php echo $result[0]["search2"] ?>" :</h1>
        <p><?php if(round($result["time"], 1) < 60): ?>
          <?php echo "Voici la reslation entre ".$result[0]['search1']." et ".$result[0]["search2"]." en ". round($result["time"], 3) ?> s
          <?php elseif (round($result['data']['time']) > 60): ?>
          <?php echo "Voici la reslation entre ".$result[0]['search1']." et ".$result[0]["search2"]." en ". round($result["time"], 3) ?>  m
          <?php else: ?>
          <?php echo "Voici la reslation entre ".$result[0]['search1']." et ".$result[0]["search2"]." en ". round($result["time"], 3) ?>  h
          <?php endif; ?>
          <p>
          <a href="?controller=trouver" style="text-decoration: none;">
          <button type="submit" id="favoriButton" class="btn btn-warning boutonFonctionnalite" style =" color: white;display: block;" >
              &#8592; Realiser une nouvelle recherche
          </button>
        </a>
        </p>  
        </p>

    </div>
</div>

<div class="container result">
<?php if ($result['Message'] === 'KO') : ?>
    <div class='container'>
        <div class='row mx-auto'>
            <div class='notFoundDiv'>
                <p class='notFoundParagraphe'>Aucun chemin trouvé</p>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class='row align-items-center'>
        <div class='mx-auto'>
        <?php
          $m = Model::getModel();
          $index = 0;
          foreach ($result['result'] as $item) {
              if ($item[0] == "n") {
                  $infoItem = $m->getInfoActeur($item);
                  $primaryName = isset($infoItem['primaryname']) ? $infoItem['primaryname'] : 'Aucune information';
                  $birthDay = isset($infoItem['birthyear']) ?  $infoItem['birthyear'] : 'Aucune information';
                  $primaryProfession = isset($infoItem['primaryprofession']) ? $infoItem['primaryprofession'] : 'Aucune information';
                  $posterPath = $m->getPersonnePhoto($item); 
                  $hrefValue = "?controller=home&action=information_acteur&id=" . $item;
                  $cardContent = '<a href="' . $hrefValue . '" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
                        <div class="cardrecherche item" style="cursor: pointer;">
                            <img src="' . $posterPath . '" alt="' . $item . '">
                              <div class="card-bodyrecherche">
                              <h2 class="card-1recherche">'.$primaryName.'</h2>
                              <p class="card-2recherche">Type : '.$primaryProfession.'</p>
                              <p class="card-3recherche">Date : '.$birthDay.'</p>


                            </div>
                            </div> 
                            </a>';
                  echo $cardContent;

              }  else {
                $infoItem = $m->getInfoFilm($item);
                $primaryTitle = isset($infoItem['primarytitle']) ? $infoItem['primarytitle'] : 'Aucune information';
                $titleType = isset($infoItem['titletype']) ? $infoItem['titletype'] : 'Aucune information';
                $startYear = isset($infoItem['startyear']) ? $infoItem['startyear'] : 'Aucune information';
                $genres = isset($infoItem['genres']) ? $infoItem['genres'] : 'Aucune information';
                $posterPath = $m->getFilmPhoto($item);
                $hrefValue = "?controller=home&action=information_movie&id=" . $item;
                $cardContent = '<a href="' . $hrefValue . '" class="card-linkrecherche" style="text-decoration: none; color: inherit;">
                      <div class="cardrecherche item" style="cursor: pointer;">
                          <img src="' . $posterPath . '" alt="' . $item . '">
                          <div class="card-bodyrecherche">
                          <h2 class="card-1recherche">'.$primaryTitle.'</h2>
                          <p class="card-2recherche">Type : '.$titleType.'</p>
                          <p class="card-3recherche">Date : '.$startYear.'</p>
                          <p class="card-4recherche">Genres : '.$genres.'</p>
                          </div>
                          </div> 
                          </a>';
                  echo $cardContent;
                }
                $index++;
              
          }

        ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

<div class ="m-5" style ="border-left:2px solid #FFCC00; padding-left: 6px;" id="count">
<p>Résultat : <?php echo sizeof($result['result'])?></p>
</div>

        
               
 <script src="Js/function.js"></script>


<?php require "Views/view_footer.php"; ?>