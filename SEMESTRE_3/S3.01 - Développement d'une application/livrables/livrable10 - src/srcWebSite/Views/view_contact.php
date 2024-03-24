<?php require "Views/view_navbar.php"; ?>
<style>
    .titleContact{
    margin-top:200px
 }
 .paragrapheTrouver{
    padding-top: 20px;
    margin-bottom: 50px
 }

 .top{
    margin-top: 20px;
 }

 .left{
    margin-left: 300px;
 }

 .bottom{
    margin-bottom: 50px;
 }

 .bottom-form{
    margin-bottom: 200px;
 }
 
</style>    
   <div class="container bottom-form titleContact"> 
        <div class="row">
            <div class="mx-auto col-md formulaire">
                <div class="d-flex align-items-center">
                <h1 style=""class="titleContact m-5">Contactez-nous</h1>    
                    <form action="?controller=contact&action=send" method="post" class="m-5">
                        <?php
                            if(isset($tab)){
                                $email = $tab[0];
                                $name = $tab[1];
                            }
                        ?>
                        <div class="container top bottom">
                            <div class="row mx-auto">
                                <div class="mx-auto col">
                                    <label for="nom">Nom :</label>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col">
                                    <input type="text" id="nom" name="nom" value="<?php echo $name[0] ?? ''; ?>" class="form-control">
                                    <div id="nom-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>
                                </div>
                            </div>
                        </div>
            
                        <div class="container bottom">
                            <div class="row mx-auto">
                                <div class="mx-auto col">
                                    <label for="Email">Email :</label>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col">
                                    <input type="text" id="email" name="email" value="<?php echo $email[0] ?? ''; ?>" class="form-control">
                                    <div id="email-error" style="display: none; color: red;">Veuillez saisir une adresse mail correcte</div>
                                </div>
                            </div>
                        </div>
                        <div class="container bottom">
                            <div class="row mx-auto">
                                <div class="mx-auto col">
                                    <label for="message">Message :</label>
                                </div>
                            </div>
                            <div class="row mx-auto">
                                <div class="col">
                                <textarea id="message" name="message" rows="4" class="form-control"></textarea>
                                <div id="message-error" style="display: none; color: red;">Veuillez entrer au moins un caractère.</div>
                                </div>
                            </div>
                        </div>

                        

                        <button type="submit" class="btn btn-warning mt-2 mx-auto" style =" color: white;display: block; margin-bottom:10px;" >Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
</div>
    
</div></div>


<script>
    $(document).ready(function() {
    handleFormValidation();
});


    function handleFormValidation() {
    $('form').submit(function(e) {
        var isValid = true; // Initialise un indicateur de validité du formulaire

        // Cache tous les messages d'erreur
        $('.error').hide();

        // Récupère et nettoie les valeurs des champs
        var searchInput = $('#nom').val().trim();
        var emailInput = $('#email').val().trim();
        var comInput = $('#message').val().trim();



        // Valide chaque champ selon les critères spécifiques
        if (!searchInput) {
            $('#nom').addClass('is-invalid');
            $('#nom-error').show();
            isValid = false; // Formulaire invalide
        }

        // Validation des années de sortie
        if (!emailInput || !/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/.test(emailInput)) {
            $('#email').addClass('is-invalid');
            $('#email-error').show();
            isValid = false;
        }

        if (!comInput) {
            $('#message').addClass('is-invalid');
            $('#message-error').show();
            isValid = false; // Formulaire invalide
        }
        
        if (!isValid) {
            e.preventDefault(); // Empêche la soumission du formulaire si invalide
        }
    });

    // Cache les messages d'erreur lors de la correction des champs
    $('#nom, #email, #message').on('input', function() {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
    });
}
</script>



<?php require "Views/view_footer.php"; ?>