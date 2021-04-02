function request(url, data, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    var loader = document.createElement('div');
    loader.className = 'loader';
    document.body.appendChild(loader);
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4) {
            if (callback) {
                callback(xhr.response);
            }
            loader.remove();
        }
    });

    var formdata = data ? (data instanceof FormData ? data : new FormData(document.querySelector(data))) : new FormData();

    var csrfMetaTag = document.querySelector('meta[name="csrf_token"]');
    if (csrfMetaTag) {
        formdata.append('csrf_token', csrfMetaTag.getAttribute('content'));
    }

    xhr.send(formdata);
}

function register() {
    request('../model/create_account.php', '#registerForm', function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        try {
            data = JSON.parse(data);
            if (!(data instanceof Array)) { throw Exception('bad data'); }

            //Show errors to user
            for (var i = 0; i < data.length; ++i) {

                switch (data[i]) {
                    case 0:
                        document.getElementById('errs').innerHTML += '<div>Votre compte a bien été crée,</br> un Email de vérification vous a été envoyé </div>';
                        document.getElementById('registerForm').reset();
                        break;
                    case 1:
                        document.getElementById('errs').innerHTML += '<div class="err">Nom invalide. (les lettres, les espaces ou les traits-d\'union sont acceptés)</div>';
                        break;
                    case 2:
                        document.getElementById('errs').innerHTML += '<div class="err">Email invalide</div>';
                        break;
                    case 3:
                        document.getElementById('errs').innerHTML += '<div class="err">Email non-existant (ce nom de domain n\'a pas de serveur mail)</div>';
                        break;
                    case 4:
                        document.getElementById('errs').innerHTML += '<div class="err">le mot de passe doit contennir: <ul><li>au moins 8 caractères</li><li>au moins une lettre en minuscule</li><li>au moins une lettre en majuscule</li><li>au moins 1 nombre</li><li>au moins 1 caractere special (~?!@#$%^&*)</li></ul></div>';
                        break;
                    case 5:
                        document.getElementById('errs').innerHTML += '<div class="err">les mot de passe ne correspondent pas. veuillez le re-entrer.</div>';
                        break;
                    case 6:
                        document.getElementById('errs').innerHTML += '<div class="err">le compte n\'a pas pu être crée. veuillez ressayez plus tard.</div>';
                        break;
                    case 7:
                        document.getElementById('errs').innerHTML += '<div class="err">Cet email est deja utiliser pour un autre compte</div>';
                        break;
                    case 8:
                        document.getElementById('errs').innerHTML += '<div class="err">le client n\'a pas pu se connecter a la base de donnée. Veuillez ressayez plus tard.</div>';
                        break;
                    case 9:
                        document.getElementById('errs').innerHTML += '<div class="err">jeton CSRF invalide </div>';
                        break;
                    case 10:
                        document.getElementById('errs').innerHTML += '<div class="err">l\'email n\'a pas pu être envoyé, veuillez réessayez plus tard</div>';
                        break;
                    case 11:
                        document.getElementById('errs').innerHTML += '<div class="err">La requète a la base de données a échoué, veuillez réessayez plus tard</div>';
                        break;
                    case 12:
                        document.getElementById('errs').innerHTML += '<div class="err">Vous avez déjà fait toute les demandes de vérification autorisés par jour< /div>';
                        break;
                    case 13:
                        document.getElementById('errs').innerHTML += '<div class="err">Votre email est déjà vérifié</div>';
                        break;
                    case 14:
                        document.getElementById('errs').innerHTML += '<div class="err">Email incorrect</div>';
                        break;
                    case 15:
                        document.getElementById('errs').innerHTML += '<div class="err">Le server n\'a pas pu se connecter avec la base de données < /div>';
                        break;
                    default:
                        document.getElementById('errs').innerHTML += '<div class="err">une erreur s\'est produite. veuillez réessayer plus tard.</div>';
                }
            }
        } catch (e) {
            document.getElementById('errs').innerHTML = '<div class="err">une erreur s\'est produite. Veuillez ressayez plus tard.</div>';
        }
        setTimeout(function() {
            document.getElementById('errs').style.transition = transition;
            document.getElementById('errs').style.opacity = 1;
        }, 10);
    });
}

function login() {
    request('../model/login.php', '#loginform', function(data) {

        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        switch (data) {
            case '0':
                window.location = '../';
                break;
            case '1':
                document.getElementById('errs').innerHTML += '<div class="err">email ou mot de passe incorrect.</div>';
                break;
            case '2':
                document.getElementById('errs').innerHTML += '<div class="err">Le serveur n\'a pas pu se connecter a la base de donnée.< /div>';
                break;
            case '3':
                document.getElementById('errs').innerHTML += '<div class="err">Vous avez dépasser le nombre limite d\'essay en une heure. réessayez plus tard</div>';
                break;
            case '4':
                document.getElementById('errs').innerHTML += '<div class="err">Votre compte n\'a toujours pas été validé. Regardez vos mail pour obtennir le lien de vérification ou <a href="../view/email_verification">réenvoyez un email de vérification</a></div>';
                break;
            default:
                document.getElementById('errs').innerHTML += '<div class="err">Une erreur est survenu, Réessayez plus tard</div>';
        }
        setTimeout(function() {
            document.getElementById('errs').style.transition = transition;
            document.getElementById('errs').style.opacity = 1;
        }, 10);
    });

    document.getElementById('loginform').reset();
}

function logout() {
    request('../model/logout.php', false, function(data) {
        if (data === '0') {
            window.location = '../view/log_in';
        }
    });
}

function sendValidateEmailRequest() {
    request('../model/email_verification.php', '#verificationForm', function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;


        //Show errors to user
        switch (data) {
            case '0':
                document.getElementById('errs').innerHTML += '<div>Email envoyé, reagrdez dans votre boite mail et cliquez sur le lien</div>';
                document.getElementById('verificationForm').reset();
                break;
            case '1':
                document.getElementById('errs').innerHTML += '<div class="err">l\'email n\'a pas pu être envoyé, veuillez réessayez plus tard</div>';
                break;
            case '2':
                document.getElementById('errs').innerHTML += '<div class="err">La requète a la base de données a échoué, veuillez réessayez plus tard</div>';
                break;
            case '3':
                document.getElementById('errs').innerHTML += '<div class="err">Vous avez déjà fait toute les demandes de vérification autorisés par jour< /div>';
                break;
            case '4':
                document.getElementById('errs').innerHTML += '<div class="err">Votre email est déjà vérifié</div>';
                break;
            case '5':
                document.getElementById('errs').innerHTML += '<div class="err">Email incorrect</div>';
                break;
            case '6':
                document.getElementById('errs').innerHTML += '<div class="err">Le server n\'a pas pu se connecter avec la base de données < /div>';
                break;
            default:
                document.getElementById('errs').innerHTML += '<div class="err">une erreur s\'est produite. veuillez réessayer plus tard.</div>';
        }
        setTimeout(function() {
            document.getElementById('errs').style.transition = transition;
            document.getElementById('errs').style.opacity = 1;
        }, 10);
    })
}