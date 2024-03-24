<?php
class Controller_resetFinal extends Controller{
    
    public function action_final(){
        $this->render("reset", []);
    }
    
    public function action_resetFinal(){
        if(isset($_POST['passWord']) && isset($_GET['token'])){
            echo "ok";
            $m = Model::getModel();
            $result = $m->getUserIdWithToken(trim(e($_GET['token'])));
            $data = [
                "userId" => $result["userId"][0],
                "password" => trim(e($_POST['passWord']))
            ];
            $stock = $m->updatePassword($data);
            $m->removeToken($result["userId"][0], trim(e($_GET['token'])));
            if($stock['status'] == "OK"){
                $tab = ["tab" => "Votre mot de passe à été reinitialiser"];
                $this->render("error", $tab);
            }
            else{
                $tab = ["tab" => "Erreur dans la modification du mot de passe"];
                $this->render("error", $tab);
            }
        }
        else{
                $tab = ["tab" => "Aucun champ saisie"];
                $this->render("error", $tab);
        }

    }
    
    public function action_default(){
        $this->action_final();
    }
}