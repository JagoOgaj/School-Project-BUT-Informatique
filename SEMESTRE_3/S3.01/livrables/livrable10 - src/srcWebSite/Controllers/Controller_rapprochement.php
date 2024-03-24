<?php
ini_set('max_execution_time', 1000); 
Class Controller_rapprochement extends Controller{
    public function action_fom_rapprochement()
    {
        $m = Model::getModel();
        $tab = [ 'caroussel' => $m->filmpopulaire()]; 
        $this->render("rapprochement", $tab);
    }
    
    public function action_rapprochement()
    {
        if(isset($_POST['typeselection']) && $_POST['typeselection'] !== "" 
            && isset($_POST['typeselectionRapo']) && $_POST['typeselectionRapo'] !== ""){

            $m = Model::getModel();
            $debut = '';
            $fin = '';
            $search1 = '';
            $search2 = '';
            $_SESSION['mode'] = $_POST['typeselectionRapo'];
            $typeSelection = $_POST['typeselection'];
            if($typeSelection == "titre" && isset($_POST['titre1']) 
                && isset($_POST['titre2'])){
                $debut = 'tconst1';
                $fin = 'tconst2';
                
                $isMultipleTitle1 = $m->doublonFilm($_POST['titre1']);
                $isMultipleTitle2 = $m->doublonFilm($_POST['titre2']);
                $search1 = $_POST['titre1'];
                $search2 = $_POST['titre2'];
                if(isset($_SESSION['username'])) {
                    $data = [
                        "UserName" => $_SESSION['username'],
                        "TypeRecherche" => "Rapprochement",
                        "MotsCles" => [
                            $_POST['titre1'],
                            $_POST['titre2']
                        ]
                    ];
                    $result = $m->addUserRecherche($data);
                }
                
                if ($isMultipleTitle1 == 1 && $isMultipleTitle2 == 1) {
                    $val1 = $m->getTconst(e($_POST['titre1']))[0];
                    $val2 = $m->getTconst(e($_POST['titre2']))[0];
                }
                else{
                    $tab = [
                        "result1" => $m->listeDoublon($_POST['titre1']),
                        "result2" => $m->listeDoublon($_POST['titre2']),
                        "titre1" => $_POST['titre1'],
                        "titre2" => $_POST['titre2'],
                    ];
                    $this->render("selectiondoublonRappro", $tab);
                }
            }
            else if($typeSelection == "personne" 
                    && isset($_POST['personne1']) && isset($_POST['personne2'])) {
                $debut = 'nconst1';
                $fin = 'nconst2';
                $isMultipleActor1 = $m->doublonActeur($_POST['personne1']);
                $isMultipleActor2 = $m->doublonActeur($_POST['personne2']);
                $search1 = $_POST['personne1'];  
                $search2 = $_POST['personne2'];  
                if(isset($_SESSION['username'])) {
                    $data = [
                        "UserName" => $_SESSION['username'],
                        "TypeRecherche" => "Rapprochement",
                        "MotsCles" => [
                            $_POST['personne1'],
                            $_POST['personne2']
                        ]
                    ];
                    $result = $m->addUserRecherche($data);
                }
                
                if ($isMultipleActor1 == 1 && $isMultipleActor2 == 1) {
                    $val1 = $m->getNcont(e($_POST['personne1']))[0];
                    $val2 = $m->getNcont(e($_POST['personne2']))[0];


                    }
                    else{
                        $tab = [
                            "result1" => $m->listeDoublonActeur($_POST['personne1']),
                            "result2" => $m->listeDoublonActeur($_POST['personne2']),
                            "personne1" => $_POST['personne1'],
                            "personne2" => $_POST['personne2'],
                        ];
                        $this->render("selectiondoublonacteurRappro", $tab);
                    }        
                }
                
            $postData = array(
                $debut => $val1,
                $fin => $val2,
                "mode" => $_SESSION['mode']
            );
            $arraySearch = array(
                "search1" => $search1,
                "search2" => $search2
            );
            $this->apiCall($postData, $arraySearch);
        }         
        else{
            $tab = ["tab" => "Champ manquant"];
            $this->render("error", $tab);
        }
    }

    public function action_rapprochementFilm(){
        $m = Model::getModel();
        $debut = 'tconst1';
        $fin = 'tconst2';
        if(isset($_POST['selectedTconst1']) && isset($_POST['selectedTconst2'])){
            $postData = array(
                $debut => $_POST['selectedTconst1'],
                $fin => $_POST['selectedTconst2'],
                "mode" => $_SESSION['mode']
            );
            $arraySearch = array(
                "search1" =>$_POST['titre1'],
                "search2" =>$_POST['titre2']
            );
            $this->apiCall($postData, $arraySearch);   
        }
        else{
            $tab = ["tab" => "Une Erreur est survenu"];
            $this->render("error", $tab);
        }
    }

    public function action_rapprochementActeur(){
        $m = Model::getModel();
        $debut = 'nconst1';
        $fin = 'nconst2';
        if(isset($_POST['selectednconst1']) && isset($_POST['selectednconst2'])){
           
            
            $postData = array(
                $debut => $_POST['selectednconst1'],
                $fin => $_POST['selectednconst2'],
                "mode" => $_SESSION['mode']
            );
            $arraySearch = array(
                "search1" =>$_POST['personne1'],
                "search2" =>$_POST['personne2']
            );
            $this->apiCall($postData, $arraySearch);
        }
        else{
            $tab = ["tab" => "Une Erreur est survenu"];
            $this->render("error", $tab);
        }
    }

    public function apiCall($array, $arraySearch){
        $jsonData = json_encode($array);
        
        // URL de l'API
        $apiUrl = 'http://127.0.0.1:5001/result';
        
        // Initialiser cURL
        $ch = curl_init($apiUrl);
    
        // Configuration des options pour la requête HTTP POST
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $jsonData,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
            CURLOPT_TIMEOUT => 10000, // Temps d'attente en secondes
        );
    
        // Appliquer les options à cURL
        curl_setopt_array($ch, $options);
    
       
    
        // Exécuter la requête HTTP POST et récupérer la réponse
        $apiResponse = curl_exec($ch);
    

    
        // Vérifier s'il y a des erreurs
        if (curl_errno($ch)) {

            $tab = ["tab" => "Une Erreur est survenue"];
            $this->render("error", $tab);
        } else {
            // Traiter la réponse de l'API (la réponse est généralement en format JSON)
            $result = json_decode($apiResponse, true);
    
            // Faire quelque chose avec le résultat
            $result[] = $arraySearch;
            $tab = ["result" => $result];
            $this->render("rapprochement_result", $tab);
        }
    
        // Fermer la session cURL
        curl_close($ch);
    }
    

    public function action_default()
    {
        $this->action_fom_rapprochement();
    }
}