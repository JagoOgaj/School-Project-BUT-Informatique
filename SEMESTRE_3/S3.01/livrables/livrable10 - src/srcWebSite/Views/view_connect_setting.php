<?php
require "Views/view_navbar.php";
$connectionTime = $tab["connectiontime"];
$formattedDateTime = date("d/m/Y H:i", strtotime($connectionTime));
?>


<style>
.settings{
    background: linear-gradient(to bottom, #0c0c0c, #1f1f1f);
    margin-bottom: 300px;
}

.settingsTitle{
    margin-top: 100px;
}

.buttonValid{
        background-color: #FFCC00 !important;
        border-color: #FFCC00 !important;
        color : black !important
    }

.buttonCancel{
    color: #FFCC00 !important;
}

.buttonSettings {
    margin-left: 5px;
    margin-bottom: 5px;
    color: gold !important;
    border-color: gold !important;
}

.ui-w-80 {
    width : 80px !important;
    height: auto;
}

.btn-default {
    border-color: rgba(24, 28, 33, 0.1);
    background  : rgba(0, 0, 0, 0);
    color       : #4E5155;
}

label.btn {
    margin-bottom: 0;
}

.btn-outline-primary {
    border-color: #26B4FF;
    background  : transparent;
    color       : #26B4FF;
}

.btn {
    cursor: pointer;
}

.text-light {
    color: #babbbc !important;
}

.btn-facebook {
    border-color: rgba(0, 0, 0, 0);
    background  : #3B5998;
    color       : #fff;
}

.btn-instagram {
    border-color: rgba(0, 0, 0, 0);
    background  : #000;
    color       : #fff;
}

.card {
    background-clip: padding-box;
    box-shadow     : 0 1px 4px rgba(24, 28, 33, 0.012);
}

.row-bordered {
    overflow: hidden;
}

.account-settings-fileinput {
    position  : absolute;
    visibility: hidden;
    width     : 1px;
    height    : 1px;
    opacity   : 0;
}

.account-settings-links .list-group-item.active {
    font-weight: bold !important;
}

html:not(.dark-style) .account-settings-links .list-group-item.active {
    /* background: transparent !important; */
    background: gold !important;
}

.account-settings-multiselect~.select2-container {
    width: 100% !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}

.light-style .account-settings-links .list-group-item.active {
   /*  color: #4e5155 !important; */
   color: gold !important;
}

.material-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
    color: #4e5155 !important;
}

.material-style .account-settings-links .list-group-item.active {
    color: gold !important;
}

.dark-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(255, 255, 255, 0.03) !important;
}

.dark-style .account-settings-links .list-group-item.active {
    color: #fff !important;
}

.light-style .account-settings-links .list-group-item.active {
    color: #4E5155 !important;
}

.light-style .account-settings-links .list-group-item {
    padding     : 0.85rem 1.5rem;
    border-color: rgba(24, 28, 33, 0.03) !important;
}
    </style>


    <div class="container light-style flex-grow-1 container-p-y settingsTitle">
        <h1 class="font-weight-bold py-3 mb-4">
            Paramètre du compte
        </h1>

        <div class="card overflow-hidden settings formulaire">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">Général</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Changer le mot de passe</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-info">Information supplémentaire</a>
                    </div>
                </div>

                <div class="col-md-9">
                    <form id="account-settings-form" action="?controller=connect&action=updateSettings" method="post">

                        <div class="tab-content">
                            <!-- General Tab -->
                            <div class="tab-pane fade active show" id="account-general">
                                <div class="card-body">
                                    <!-- Username -->
                                    <div class="form-group">
                                        <label class="form-label">Nom d'utilisateur</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mb-1" value="<?php echo $_SESSION['username']; ?>" id="username" name="username" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary buttonSettings" id="edit-username">Edit</button>
                                            </div>
                                        </div>
                                        <div id="username-error" style="display: none; color: red;">Veuillez saisir un username correcte </div>
                                    </div>
                                    <!-- Name -->
                                    <div class="form-group">
                                        <label class="form-label">Nom</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $tab["name"]; ?>" id="Name" name="Name" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary buttonSettings" id="edit-name">Edit</button>
                                            </div>
                                        </div>
                                        <div id="Name-error" style="display: none; color: red;">Veuillez saisir un nom correcte </div>
                                    </div>
                                    <!-- E-mail -->
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control mb-1" value="<?php echo $tab["email"]; ?>" id="email" name="email" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary buttonSettings" id="edit-email">Edit</button>
                                            </div>
                                        </div>
                                        <div id="email-error" style="display: none; color: red;">Veuillez saisir une adresse mail correcte</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Change Password Tab -->
                            <div class="tab-pane fade" id="account-change-password">
                                <div class="card-body pb-2">
                                    <!-- Current Password -->
                                    <div class="form-group">
                                        <label class="form-label">Mot de passe actuel</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $_SESSION['password']; ?>" id="password" disabled>
                                        </div>
                                    </div>
                                    <!-- New Password -->
                                    <div class="form-group">
                                        <label class="form-label">Nouveau mot de passe</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="newPassword" id="newPassword" name="newPassword" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary buttonSettings" id="edit-new-password">Edit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Account Info Tab -->
                            <div class="tab-pane fade" id="account-info">
                                <div class="card-body pb-2">
                                    <!-- Country -->
                                    <div class="form-group">
                                        <label class="form-label">Pays</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $tab["country"] ?>" id="country" name="country" disabled>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-outline-secondary buttonSettings" id="edit-country">Edit</button>
                                            </div>
                                        </div>
                                        <div id="country-error" style="display: none; color: red;">Veuillez saisir un pays correcte</div>
                                    </div>
                                    <!-- Last Connection -->
                                    <div class="form-group">
                                        <label class="form-label">Derniére connection</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" value="<?php echo $formattedDateTime; ?>" id="last-connection" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div style="margin-bottom: 10px"class="text-right mt-3">
                            <button type="submit" class="btn btn-primary buttonValid" id="save-changes">Sauvegarder</button>&nbsp;
                            <a href="?controller=connect" class="btn btn-default buttonCancel" id="cancel-changes">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php require "Views/view_footer.php"; ?>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function toggleFieldAndHideButton(editBtn, inputField) {
                inputField.disabled = !inputField.disabled;
                editBtn.style.display = inputField.disabled ? 'inline-block' : 'none';
            }

            var editUsernameBtn = document.getElementById("edit-username");
            var editNameBtn = document.getElementById("edit-name");
            var editEmailBtn = document.getElementById("edit-email");
            var editNewPasswordBtn = document.getElementById("edit-new-password");
            var editCountryBtn = document.getElementById("edit-country");

            var usernameInput = document.getElementById("username");
            var nameInput = document.getElementById("Name");
            var emailInput = document.getElementById("email");
            var newPasswordInput = document.getElementById("newPassword");
            var countryInput = document.getElementById("country");

            editUsernameBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editUsernameBtn, usernameInput);
            });

            editNameBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editNameBtn, nameInput);
            });

            editEmailBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editEmailBtn, emailInput);
            });

            editNewPasswordBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editNewPasswordBtn, newPasswordInput);
            });

            editCountryBtn.addEventListener("click", function () {
                toggleFieldAndHideButton(editCountryBtn, countryInput);
            });
        });

        $(document).ready(function(){
            handleFormValidation();
        });

        function handleFormValidation() {
    $('form').submit(function (e) {
        var isValid = true;

        // Check only enabled input fields
        $('input:enabled').each(function () {
            var field = $(this);
            var value = field.val().trim();

            // Add your validation logic here
            // Example validation: check if email is valid
            if (field.attr('id') === 'email' && !/^[\w.-]+@[a-zA-Z\d.-]+\.[a-zA-Z]{2,}$/.test(value)) {
                field.addClass('is-invalid');
                $('#email-error').show();
                isValid = false;
            }

            if(field.attr('id') === 'username' && !/^[a-zA-Z]+$/.test(value)){
                field.addClass('is-invalid');
                $('#username-error').show();
                isValid = false;
            }

            if(field.attr('id') === 'Name' && !/^[a-zA-Z]+$/.test(value)){
                field.addClass('is-invalid');
                $('#Name-error').show();
                isValid = false;
            }

            if(field.attr('id') === 'country' && !/^[a-zA-Z]+$/.test(value)){
                field.addClass('is-invalid');
                $('#country-error').show();
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault(); // Prevent form submission if invalid
        }
    });

    $('input').on('input', function () {
        var elementId = '#' + $(this).attr('id');
        var errorId = '#' + $(this).attr('id') + '-error';
        $(elementId).removeClass('is-invalid');
        $(errorId).hide();
    });
}



    </script>
