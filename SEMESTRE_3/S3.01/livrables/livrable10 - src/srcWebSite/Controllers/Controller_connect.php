<?php

Class Controller_connect extends Controller{
    public function action_form(){
        $this->render("connect", []);
    }
    
    public function action_render_user($username){
        $m = Model::getModel();
        $result = $m->getUserData($username);
        $typeRecherche = ["Recherche", "Trouver", "Rapprochement"];
        foreach($typeRecherche as $type){
            $typeData = [
                "username" => $_SESSION['username'],
                "type" => $type
            ];
            $r = $m->getRechercherData($typeData);
            $result[] = [$type =>$r];
        }
        $favoActeur = $m->getFavorieActeur($_SESSION['username']);
        $favoFilm = $m->getFavorieFilm($_SESSION['username']);

        $result[] = ["FavorieActeur" => array_reverse($favoActeur)];
        $result[] = ["FavorieFilm" => array_reverse($favoFilm)];

        $tab = ["tab" => $result];
        $this->render("connect_user", $tab);
        
    }

    public function action_settings(){
        $m = Model::getModel();
        $tab =["tab" => $m->getUserDataSettings($_SESSION['username'])];
        $this->render("connect_setting", $tab);
    }


    public function action_login(){
        if(isset($_POST['userName']) && isset($_POST['passWord'])){
            $m = Model::getModel();
            if($m->userExist(trim(e($_POST['userName'])))["exists"] == false){
                $_GET['retour'] = 0;
                $this->action_form();
            }
            $result = $m->loginUser([
                "username" => trim(e($_POST['userName'])), 
                "password" => trim(e($_POST['passWord']))
            ]);
            if(isset($result['status']) && $result['status'] == "KO"){
                $_GET['retour'] = -4;
                $this->action_form();
                // $tab =["tab" => $result['message']];
                // $this->render("error", $tab);
            }
            else{
                $_SESSION['username'] = trim(e($_POST['userName']));
                $_SESSION['password'] = trim(e($_POST['passWord']));
                $this->action_render_user($_SESSION['username']);
                exit();
            }
        }
        else{
            $_GET['retour'] = -1;
            $this->action_form();
            // $tab = ["tab" =>"Champ Manquant"];
            // $this->render("error", $tab);
        }

    }

    public function action_updateSettings(){
            // Récupérez les données du formulaire
            $username = isset($_POST["username"]) ? $_POST["username"] : null;
            $name = isset($_POST["Name"]) ? $_POST["Name"] : null;
            $email = isset($_POST["email"]) ? $_POST["email"] : null;
            $newPassword = isset($_POST["newPassword"]) ? $_POST["newPassword"] : null;
            $country = isset($_POST["country"]) ? $_POST["country"] : null;
            $ancien_user = $_SESSION['username'];
            // Appelez la méthode du modèle pour mettre à jour les paramètres
            $model = Model::getModel();
            $result = $model->updateSettings($ancien_user, trim(e($username)), trim(e($name)), trim(e($email)), trim(e($newPassword)), trim(e($country)));
            if($result != false){
                $_GET['retour'] = 1;
                if($newPassword != null){
                    $_SESSION['password'] = trim(e($_POST['newPassword']));
                }
                
                if($username != null){
                    $_SESSION['username'] = trim(e($username));
                    $this->action_render_user($_SESSION['username']);
                }
                else{
                    $this->action_render_user($ancien_user);
                }
               
               
            }
            else{
                $_GET['retour'] = -1;
                $this->action_render_user($_SESSION['username']);
                // $tab = ["tab" =>"Error"];
                // $this->render("error", $tab);
            }
            
    }
    
    public function action_signup(){
        if(isset($_POST['userName']) && isset($_POST['passWord']) && isset($_POST['secondPassword'])){
            if($_POST['passWord'] != $_POST['secondPassword']){
                $_GET['retour'] = -2;
                $this->action_form();
            }
            $m = Model::getModel();
            $result = $m->addUser([
                "username" => trim(e($_POST['userName'])), 
                "password" => trim(e($_POST['passWord']))
            ]);
            if(isset($result['status']) && $result['status'] == "KO"){
                $_GET['retour'] = -3;
                $this->action_form();
                // $tab =["tab" => $result['message']];
                // $this->render("error", $tab);
            }
            else{
                $_SESSION['username'] = trim(e($_POST['userName']));
                $_SESSION['password'] = trim(e($_POST['passWord']));
                $this->action_render_user($_SESSION['username']);
                exit();
            }
        }
        else{
            $_GET['retour'] = -1;
            $this->action_form();
            // $tab = ["tab" =>"Champ Manquant"];
            // $this->render("error", $tab);
        }
    }
    
    public function action_logout(){
        session_unset(); 
        session_destroy(); 
        $this->action_form();
    }
    
    public function action_default(){
        if(isset($_SESSION['username'])){
            $this->action_render_user($_SESSION['username']);
        }
        else{
            $this->action_form();
        }
    }
}
