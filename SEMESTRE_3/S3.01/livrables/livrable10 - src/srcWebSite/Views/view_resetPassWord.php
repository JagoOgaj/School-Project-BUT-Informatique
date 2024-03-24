<style>
    .bouton{
        margin-top: 20px;
    }

    .top{
        margin-top: 100px;
    }
    .left{
        margin-left: 100px;
    }
    .buttonAnuler{
        color: white !important;
    }

    .button{
        background-color: #FFCC00 !important;
        border-color: #FFCC00 !important;
        color: black !important;

    }

    .reset{
        margin-top: 100px;
    }

    .inputReset{
        margin-top: 20px;
    }

    .labelReset{
        margin-top:10px;
    }

    .resetForm{
        margin-left: 10px;
    }

    .reset3{
        background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
    }
</style>
<body>
<?php
require "Views/view_navbar.php";
if(isset($_GET['retour'])){
        $retour = trim(e($_GET['retour']));
        switch ($retour) {
            case 1:
                $message = "Mail Eenvoyer";
                $alertClass = "alert alert-success";
                $image='icons8-check-50.png';
            case -1:
                $message = "Utilisateur inconnu";
                $alertClass = "alert-danger";
                $image='icons8-warning-50.png';
                break;
            case -2:
                $message = "Une erreur est surnvenu";
                $alertClass = "alert-danger";
                $image='icons8-warning-50.png';
                break;    
            case 2:
                $message = "Email inconnu";
                $alertClass = "alert-danger";
                $image='icons8-warning-50.png';
                break;
            case 3:
                $message = "Mail envoyer regardez votre boite mail";
                $alertClass = "alert-success";
                $image='icons8-check-50.png';
            case -3 :
                $message = "Token inconnu";
                $alertClass = "alert-danger";
                $image='icons8-warning-50.png';
            case -4 :
                $message = "Le token a expiré";
                $alertClass = "alert-danger";
                $image='icons8-warning-50.png';

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
    
if(isset($tab)){
    $message = $tab['Message'] ?? ''; // Si 'Message' n'est pas défini dans le tableau, $message sera une chaîne vide.
    $username = $tab['username'] ?? ''; // Si 'username' n'est pas défini dans le tableau, $username sera une chaîne vide.
    $type = $tab['type'] ?? ''; // Si 'type' n'est pas défini dans le tableau, $type sera une chaîne vide.
    $email = $tab['email'] ?? ''; // Si 'email' n'est pas défini dans le tableau, $email sera une chaîne vide.

}else{
    $message = "";
    $username = "";
    $type = "";
    $email = "";
}

?>

<?php
if (isset($_GET['etape'])) :
    if ($_GET['etape'] == 1) :
?>
        <div class="container reset">
    <div class="row mx-auto align-items-center">
        <div class="col">
            <h1 class="titleError">Reinitilisation du mot de passe</h1>
        </div>
    </div>
    <div class="container resetForm">
        <div class="row align-items-center">
            <div class="formulaire mx-auto col-md reset3">
                <form id='formEtape1' action='?controller=resetPassWord&action=resetEtape1' method='post'> 
                    <div class='form-group'>
                            <label for='username' class="labelReset">Saisir nom d'utilisateur</label>
                                <div class="inputReset">
                                    <input id="username" type='text' class='form-control' name='username'>
                                    <div id="username-error" style="display: none; color: red;">Veuillez saisir un nom d'utilisateur</div>
                                </div>
                                
                                <div class="inputReset">
                    
                                    <input id="annuler" type='submit' class='btn btn-primary submit-btn button' name='cancel' value='Annuler'>
                                    <input id="submitEtape1" type='submit'style='margin-left: 10px' class='btn btn-primary submit-btn button' value='Etape suivante'>
                                </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
<?php
    elseif ($_GET['etape'] == 2) :
?>
 <div class="container reset">
    <div class="row mx-auto align-items-center">
        <div class="col">
            <h1 class="titleError">Reinitilisation du mot de passe</h1>
        </div>
    </div>
    <div class="container resetForm">
        <div class="row align-items-center">
            <div class="formulaire mx-auto col-md reset3">
                <form id='formEtape2' action='?controller=resetPassWord&action=resetEtape2' method='post'> 
                    <div class='form-group'>
                            <label for='token' class="labelReset"><?= $message . ' ' .$username ?></label>
                                <div class="inputReset">
                                    <?php if($type == 1) : ?>
                                    <input id="email" name="email" type='text' class='form-control'>
                                    <?php else : ?>
                                    <input type='email' class='form-control' id='email' name='email' value='<?= $email ?>' disabled>
                                    <?php endif; ?>
                                    <div id="email-error" style="display: none; color: red;">Veuillez une adresse mail</div>
                                    <div id="email-error2" style="display: none; color: red;">Veuillez une adresse mail valide</div>
                                </div>
                                
                                <div class="inputReset">
                                    <input id="roleBack" type='submit' class='btn btn-primary submit-btn button' name='roleBack' value='&#8592; Revenir Etape 1'>
                                    <input id="Etape2" type='submit' style='margin-left: 10px' class='btn btn-primary submit-btn button' value='Etape suivante'>
                                </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>

<?php
    endif;
endif;
?>
</div>
</div>
</div>
</div>

    <script>

    if(<?php echo ($_GET['etape'] == 1) ? 'true' : 'false'; ?>){
        document.querySelector("#submitEtape1").addEventListener('click', ()=>{
            handleFormValidationEtape1();
        });

        document.querySelector("#annuler").addEventListener('click', ()=>{
            $('#username-error').hide();
            window.location.href = '?controller=home';
            return;
        });
    }
    else {
        document.querySelector("#Etape2").addEventListener('click', ()=>{
            handleFormValidationEtape2();
        });

        document.querySelector("#roleBack").addEventListener('click', ()=>{
            $('#email-error').hide();
            $('#email-error2').hide();
            window.location.href = '?controller=resetPassWord';
            return;
        });
    }

    function handleFormValidationEtape1() {
    $('#formEtape1').submit(function(e) {

        
        var isValid = true; // Initialise un indicateur de validité du formulaire
        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var searchInput = $('#username').val().trim();

        // Valide chaque champ selon les critères spécifiques
        if (!searchInput) {
            $('#username').addClass('is-invalid');
            $('#username-error').show();
            isValid = false; // Formulaire invalide
        }

        // Validation des années de sortie
        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#username').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
    });
}

function handleFormValidationEtape2() {
    $('#formEtape2').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire
        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var searchInput = $('#email').val().trim();

        // Valide chaque champ selon les critères spécifiques
        if (!searchInput) {
            $('#email').addClass('is-invalid');
            $('#email-error').show();
            isValid = false; // Formulaire invalide
        }

        if(searchInput && !/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/.test(searchInput)){
            $('#email').addClass('is-invalid');
            $('#email-error2').show();
            isValid = false; // Formulaire invalide
        }

        // Validation des années de sortie
        console.log(isValid);
        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#email').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        var errorId2 = '#' + $(this).attr('id') + '-error2';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
        $(errorId2).hide();
    });
}
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

    function toggleFieldAndHideButton(editBtn, inputField) {
                inputField.disabled = !inputField.disabled;
                editBtn.style.display = inputField.disabled ? 'inline-block' : 'none';
            }
    var editEmailBtn = document.getElementById("edit-email");
    var emailInput = document.getElementById("email");
    
    editEmailBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editEmailBtn, emailInput);
            });

    </script>
</body>
</html>
