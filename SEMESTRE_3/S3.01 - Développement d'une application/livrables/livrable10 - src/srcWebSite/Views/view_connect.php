<style>
    /* Import Google font - Poppins */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body{
  min-height: 100vh;
  width: 100%;
  background-color: black;
}
.container{
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%,-50%);
  max-width: 430px;
  width: 100%;
  background: #fff;
  border-radius: 7px;
  box-shadow: 0 5px 10px rgba(0,0,0,0.3);
}
.container .registration{
  display: none;
}
#check:checked ~ .registration{
  display: block;
}
#check:checked ~ .login{
  display: none;
}
#check{
  display: none;
}
.container .form{
  padding: 2rem;
}
.form header{
  font-size: 2rem;
  font-weight: 500;
  text-align: center;
  margin-bottom: 1.5rem;
}
 .form input{
   height: 60px;
   width: 100%;
   padding: 0 15px;
   font-size: 17px;
   margin-bottom: 1.3rem;
   border: 1px solid #ddd;
   border-radius: 6px;
   outline: none;
 }
 .form input:focus{
   box-shadow: 0 1px 0 rgba(0,0,0,0.2);
 }
.form a{
  font-size: 16px;
  color: #FFCC00;
  text-decoration: none;
}
.form a:hover{
  text-decoration: underline;
}
a{
  text-decoration: none;
}
.form input.button{
  color: #fff;
  background: #009579;
  font-size: 1.2rem;
  font-weight: 500;
  letter-spacing: 1px;
  margin-top: 1.7rem;
  cursor: pointer;
  transition: 0.4s;
}
.form input.button:hover{
  background: #006653;
}
.signup{
  font-size: 17px;
  text-align: center;
  margin-right: 500px;
}
.signup label{
  color: #FFCC00;
  cursor: pointer;
}
.signup label:hover{
  text-decoration: underline;
}

.submit-btn {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    transition-duration: 0.4s;
}

.submit-btn:hover {
    background-color: white; 
    color: black; 
    border: 2px solid #4CAF50;
}
.mdp{
  margin-bottom: 20px;
}
.connect{
  background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
}

  
</style>

  <?php
    require "Views/view_navbar.php";
    // Récupérer la variable 'retour' de l'URL
    if(isset($_GET['retour'])){
        $retour = trim(e($_GET['retour']));
        switch ($retour) {
            case 0:
                $message = "Cet utilisateur n'existe pas";
                $alertClass = "alert-danger";
                break;
            case -1:
                $message = "Aucun Champ saisie veuillez saisir un champs";
                $alertClass = "alert-danger";
                break;
            case -2:
                $message = "Le mot de passe saisie ne correspond pas au premier mot de passe saisie";
                $alertClass = "alert-danger";
                break;
            case -3:
                $message = "Une erreur est survenue dans la création du compte";
                $alertClass = "alert-danger";
                break;
            case -4:
                $message = "Une erreur est survenue lors de la connection à votre compte";
                $alertClass = "alert-danger";
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
                    <p style='border-left:2px solid black ;padding-left: 5px;'>
                      <img style='transform: scale(0.7); padding-bottom: 2px;' src='Images/icons8-warning-50.png' alt='warning'>$message
                    </p>
                </div>
              </div>";
        }
    }
    ?> 
<div class="container formulaire connect">
    <input type="checkbox" id="check">
    <div class="login form">
        <h1 style="padding-bottom: 10px;">Connection</h1>
        <form id="loginForm" action="?controller=connect&action=login" method="post">
          <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
            <input id="userNameLogin"type="text" placeholder="Entrer votre nom d'utilisateur" name="userName" class="form-control">
            <div id="userNameLogin-error"class="invalid-feedback" style="display: none; color: red; padding-bottom: 10px;">Veuillez entrer un nom d'utilisateur.</div>
            <input id="passWordLogin"type="password" placeholder="Entrer votre mot de passe" name="passWord" class="form-control">
            <div id="passWordLogin-error" class="invalid-feedback" style="display: none; color: red; padding-bottom: 10px;">Veuillez entrer votre mot de passe.</div>
            <div class="mdp">
            <a href="?controller=resetPassWord">Mot de passe oublier ?</a>
            </div>
            <button type="submit" id="buttontrouver" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block;" >Connexion</button>
        </form>
        <div class="signup">
            <span class="signup">
             <label for="check">Creer un compte</label>
            </span>
        </div>
        <div style="margin-top: 10px">
            <span class="signup">
             <label for="check"><a href="?controller=contact">Contactez nous</a></label>
            </span>
        </div>
    </div>
    <div class="registration form">
        <h1 style="padding-bottom: 10px;">Creer un compte</h1>
        <form id="signupForm" action="?controller=connect&action=signup" method="post">
          <div class="invalid-feedback">Veuillez entrer votre nom d'utilisateur.</div>
            <input id="userNameLogin2" type="text" placeholder="Entrer votre nom d'utilisateur" name="userName" class="form-control">
            <div id="userNameLogin2-error"class="invalid-feedback" style="display: none; color: red; padding-bottom: 10px;">Veuillez saisir un mot de passe.</div>
            <input id="passWordLogin2" type="password" id="signupPassword" placeholder="Créer un mot de passe" name="passWord" class="form-control">
            <div id="passWordLogin2-error"class="invalid-feedback" style="display: none; color: red; padding-bottom: 10px;">Veuillez confirmer votre mot de passe.</div>
            <input id="passWordLoginConfirm" type="password" id="confirmPassword" placeholder="Confirmer votre mot de passe" class="form-control" name="secondPassword">
            <div id="passWordLoginConfirm-error"class="invalid-feedback" style="display: none; color: red; padding-bottom: 10px;">Veuillez confirmer votre mot de passe.</div>
            <div id="passWordLoginConfirm-error2"class="invalid-feedback" style="display: none; color: red; padding-bottom: 10px;">Ce mot de passe ne correspond pas</div>
            <button type="submit" id="buttontrouver" class="btn btn-warning mt-3 mx-auto" style =" color: white;display: block;" >Créer un compte</button>
        </form>
            <div class ="signup">
            <span class="signup">
             <label for="check">Connection</label>
            </span>
          </div>
        <div style="margin-top: 10px">
            <span class="signup">
             <label for="check"><a href="?controller=contact">Contactez nous</a></label>
            </span>
        </div>
    </div>
        
      </div>
    </div>
</div>



<script>
   $(document).ready(function() {
    handleFormValidationFomLogin();
    handleFormValidationFomLogin2();
});


    function handleFormValidationFomLogin() {
    $('#loginForm').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire

        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var userNameLoginInput = $('#userNameLogin').val().trim();
        var passWordLoginInput = $('#passWordLogin').val().trim();
        
        var isEmptyRegex = /^\s*$/;


        // Valide chaque champ selon les critères spécifiques
        if (isEmptyRegex.test(userNameLoginInput)) {
            $('#userNameLogin').addClass('is-invalid');
            $('#userNameLogin-error').show();
            isValid = false; // Formulaire invalide
        }

        if (isEmptyRegex.test(passWordLoginInput)) {
            $('#passWordLogin').addClass('is-invalid');
            $('#passWordLogin-error').show();
            isValid = false; // Formulaire invalide
        }

        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#userNameLogin, #passWordLogin').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
    });
}


function handleFormValidationFomLogin2() {
    $('#signupForm').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire

        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var userNameLogin2Input = $('#userNameLogin2').val().trim();
        var passWordLogin2Input = $('#passWordLogin2').val().trim();
        var passWordLoginConfirmInput = $('#passWordLoginConfirm').val().trim();
        
        var isEmptyRegex = /^\s*$/;


        // Valide chaque champ selon les critères spécifiques
        if (isEmptyRegex.test(userNameLogin2Input)) {
            $('#userNameLogin2').addClass('is-invalid');
            $('#userNameLogin2-error').show();
            isValid = false; // Formulaire invalide
        }

        if (isEmptyRegex.test(passWordLogin2Input)) {
            $('#passWordLogin2').addClass('is-invalid');
            $('#passWordLogin2-error').show();
            isValid = false; // Formulaire invalide
        }

        if (isEmptyRegex.test(passWordLoginConfirmInput)) {
            $('#passWordLoginConfirm').addClass('is-invalid');
            $('#passWordLoginConfirm-error').show();
            isValid = false; // Formulaire invalide
        }
        if (passWordLogin2Input !== passWordLoginConfirmInput) {
            $('#passWordLoginConfirm').addClass('is-invalid');
            $('#passWordLoginConfirm-error2').show();
            isValid = false; // Formulaire invalide
        } 

        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#userNameLogin2, #passWordLogin2, #passWordLoginConfirm').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $('#passWordLogin2-error2').hide();
        $(errorId).hide();
    });
}
// JavaScript pour valider le formulaire
   // Supposons que l'ID de votre alerte est 'myAlert'
   var alertElement = document.getElementById('myAlert');
  var initialOpacity = 1; // Opacité initiale (complètement visible)
  var fadeDuration = 5000; // Durée du fondu en millisecondes (2 secondes)

// Fonction pour réduire l'opacité progressivement
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
