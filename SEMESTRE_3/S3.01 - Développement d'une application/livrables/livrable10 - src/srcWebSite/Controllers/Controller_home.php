<?php

Class Controller_home extends Controller{

    public function __contruct(){}
    
    public function action_home(){
        $m = Model::getModel();
        if (isset($_POST["suggestion"]) && isset($_POST["category"]) ) {
           
            $suggestions = $m->suggestion($_POST["suggestion"],$_POST["category"]);
            
            // Renvoyer les suggestions sous forme de JSON.
            echo json_encode($suggestions);
            return; // Important pour éviter le rendu d'une vue après une réponse AJAX.
        }
        
        $caroussel = $m->filmpopulaire();
        $filmnote = $m->filmmieuxnote();
    
        // Préparer les films par genre
        $filmsParGenre = [
            'Action' => $m->listhome('Action'),
            'Science-Fiction' => $m->listhome('Sci-Fi'),
            'Drame' => $m->listhome('Drama'),
            'Jeunesse' => $m->listhome('Animation'),
            'Crime'=>$m->listhome('Crime'),
            'Horreur'=>$m->listhome('Horror'),
        ];
    
        // Passer les films populaires et les films par genre à la vue
        $this->render("home", ['caroussel' => $caroussel, 'filmsParGenre' => $filmsParGenre, 'filmnote' => $filmnote]);
    }
    
    public function action_voirtousresultat() {
        $m = Model::getModel();
        $searchInput = $_POST["search-input"] ?? $_GET["mot"];
        $type= $_POST["category"] ?? $_GET["category"];
        $tab = [
            'recherche' => $m->voirtousresultat($searchInput,$type),
            'titre' => $searchInput,
            'category'=>$type,
            
        ];
        $this->render("voirtousresultat", $tab);
    }
    
    
    public function action_information_movie(){
        $m = Model::getModel();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else if(isset($_GET['filmId'])){
            $id = $_GET['filmId'];
        }
        else{
            $id = $_SESSION['id'];
        }
        $tab = $m->getCommentaryMovie(trim(e($id)));
        if(isset($_SESSION['username'])){
            $userId = $m->getUserId($_SESSION['username'])["userid"];
            
            if(empty($m->favorieExistFilm($userId, trim(e($id))))){
                $_SESSION['favori'] = 'false';
            }
            else{
                $_SESSION['favori'] = 'true';
            }
        }
        $tab = [ 'info' => $m->getInformationsMovie(trim(e($id))),
                  'realisateur'=>$m->getInformationsDirector(trim(e($id))),
                  'acteur'=>$m->getInformationsActeurParticipant(trim(e($id))),
                  'commentaires'=>$tab,
                  'saison_episode'=> $m->getEpisode(trim(e($id))),
                  'nbsaison'=> $m->getNbSaison(trim(e($id))),
                  'saisonactuel'=> $m->getSaison(trim(e($id))),
                  'nbepisode'=> $m->getNbEpisode(trim(e($id))),
                  'nomserie'=> $m->getNameSerie(trim(e($id))),
                  
            
            ];
            
            $this->render("informations", $tab);


    }
    public function action_information_acteur(){
        $m = Model::getModel();
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else if(isset($_GET['acteurId'])){
            $id = $_GET['acteurId'];
        }
        else{
            $id = $_SESSION['id'];
        }
        $tab = $m->getCommentaryActor(trim(e($id)));
        if(isset($_SESSION['username'])){
            $userId = $m->getUserId($_SESSION['username'])["userid"];
            if(empty($m->favorieExistActeur($userId, trim(e($id))))){
                $_SESSION['favoriActeur'] = 'false';
            }
            else{
                $_SESSION['favoriActeur'] = 'true';
            }
        }

        
        $tab = [ 'titre'=>$m->getInformationsFilmParticipant(trim(e($id))),
                  'info'=>$m->getInformationsActeur(trim(e($id))),
                  'commentaires'=>$tab
            ];
        $this->render("acteur", $tab);


    }

    public function action_ajoutComMovie(){
        $id = '';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else if(isset($_GET['filmId'])){
            $id = $_GET['filmId'];
        }
        
        if(isset($_POST['anonymous']) && isset($_POST['commentTitle']) && 
            isset($_POST['commentNote']) && isset($_POST['commentInput']) && isset($_SESSION['username'])){
            
                $m = Model::getModel();
                $data = [
                    "userId" => $m->getUserId($_SESSION['username'])["userid"],
                    "movieId" => trim(e($id)),
                    "TitreCom" => $_POST['commentTitle'],
                    "commentary" => $_POST['commentInput'],
                    "anonyme" => $_POST['anonymous'],
                    "rating" => $_POST['commentNote']
                ];
                try{
                    $m->addCommentaryMovie($data);
                    $_GET['retour'] = '1';
                    $this->action_information_movie();
                }
                catch(PDOException $e){
                    $_GET['retour'] = '-1';
                    $this->action_information_movie();
                }
        }
        else{
            $_GET['retour'] = '-1';
            $this->action_information_movie();
        }
    }

    public function action_ajoutComActeur(){
        $id = '';
        if(isset($_GET['id'])){
            $id = $_GET['id'];
        }
        else if(isset($_GET['acteurId'])){
            $id = $_GET['acteurId'];
        }
        
        if(isset($_POST['anonymous']) && isset($_POST['commentTitle'])&& 
            isset($_POST['commentNote']) && isset($_POST['commentInput']) && isset($_SESSION['username'])){
                $m = Model::getModel();
                $data = [
                    "userId" => $m->getUserId($_SESSION['username'])["userid"],
                    "ActorID" => trim(e($id)),
                    "TitreCom" => $_POST['commentTitle'],
                    "commentary" => $_POST['commentInput'],
                    "anonyme" => $_POST['anonymous'],
                    "rating" => $_POST['commentNote']
                ];
                
                    $m->addCommentaryActor($data);
                    $_GET['retour'] = '1';
                    
                    $this->action_information_acteur();
                /* }
                    $_GET['retour'] = '-1';
                    $this->action_information_acteur();
                } */
        }
        else{
            $_GET['retour'] = '-1';
            $this->action_information_acteur();
        }
    }


    public function action_contact(){
        $m = Model::getModel();
        $tab = [ 
                  
            
            ];
        $this->render("contact", $tab);


    }

    public function action_favorie_movie() {
        if(!isset($_SESSION['username'])){
            $this->render("connect", []);
        }
        else {
            $m = Model::getModel();
            if (isset($_GET['filmId'])) {
                $userId = $m->getUserId($_SESSION['username'])["userid"];
                if (empty($m->favorieExistFilm($userId, trim(e($_GET['filmId']))))) {
                    $m->AddFavorieFilm($userId, trim(e($_GET['filmId'])));
                    echo json_encode(['success' => true]);
                } else {
                    $m->RemoveFavorieFilm($userId, trim(e($_GET['filmId'])));
                    echo json_encode(['success' => false]);
                    
                }
            }
        }
    }

    public function action_favorie_movie_home() {
        $m = Model::getModel();
        if (isset($_GET['filmId'])) {
            $userId = $m->getUserId($_SESSION['username'])["userid"];
            if (empty($m->favorieExistFilm($userId, trim(e($_GET['filmId']))))) {
                $m->AddFavorieFilm($userId, trim(e($_GET['filmId'])));
                echo json_encode(['success' => true]);
            } else {
                $m->RemoveFavorieFilm($userId, trim(e($_GET['filmId'])));
                echo json_encode(['success' => false]);
            }
        }
    }
    

    public function action_favorie_acteur(){
        if(!isset($_SESSION['username'])){
            $this->render("connect", []);
        }
        else {
            $m = Model::getModel();
            if(isset($_GET['acteurId'])){
                $userId = $m->getUserId($_SESSION['username'])["userid"];
                if(empty($m->favorieExistActeur($userId, trim(e($_GET['acteurId']))))){
                    $m->AddFavorieActeur($userId, trim(e($_GET['acteurId'])));
                    echo json_encode(['success' => true]);
                    

                }
                else{
                    $m->RemoveFavorieActeur($userId, trim(e($_GET['acteurId'])));
                    echo json_encode(['success' => false]);
                }
            }
        }
    }

    public function action_politique(){

        $tab = [
            
            
        ];
        $this->render("politique", $tab);

    }
    public function action_sommesnous(){

        $tab = [
            
            
        ];
        $this->render("sommesnous", $tab);

    }
    public function action_default(){

        $this->action_home();

    }

}