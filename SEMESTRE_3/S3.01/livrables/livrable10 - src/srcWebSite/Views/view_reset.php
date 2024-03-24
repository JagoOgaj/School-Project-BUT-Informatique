<?php require "Views/view_navbar.php";?>

<style>
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

</style>

<div class="container reset">
    <div class="row mx-auto align-items-center">
        <div class="col">
            <h1 class="titleError">Reinitilisation du mot de passe</h1>
            <p class="errorParagraphe">Ici vous pouvez réinitiliser votre mot de passe</p>
        </div>
    </div>
    <div class="container resetForm">
        <div class="row align-items-center">
            <div class="formulaire mx-auto col-md">
                <form id='form' action='?controller=resetFinal&action=resetFinal&token=<?php echo $_GET['token']; ?>' method='post'> 
                    <div class='form-group'>
                            <label for='token' class="labelReset">Réinitialiser votre mot de passe</label>
                                <div class="inputReset">
                                    <input id="passWord" type='text' class='form-control' name='passWord'>
                                    <div id="passWord-error" style="display: none; color: red;">Veuillez saisir un nouveau mot de passe</div>
                                </div>
                                
                                <div class="inputReset">
                                    <input type='submit' class='btn btn-primary submit-btn' value='Reinitialiser mot de passe'>
                                </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
    handleFormValidation();
});


    function handleFormValidation() {
    $('#form').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire
        console.log(isValid);
        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var searchInput = $('#passWord').val().trim();

        // Valide chaque champ selon les critères spécifiques
        if (!searchInput) {
            $('#passWord').addClass('is-invalid');
            $('#passWord-error').show();
            isValid = false; // Formulaire invalide
        }

        // Validation des années de sortie
        
        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#passWord').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
    });
}
</script>

