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
                        document.getElementById('errs').innerHTML += '<div>Compte crée</div>';
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
                        // case 10:
                        //     document.getElementById('errs').innerHTML += '<div class="err">Failed to send email. Please try again later.</div>';
                        //     break;
                        // case 11:
                        //     document.getElementById('errs').innerHTML += '<div class="err">Failed to insert request into database. Please try again later.</div>';
                        //     break;
                        // case 12:
                        //     document.getElementById('errs').innerHTML += '<div class="err">You have excedded your number of allowed validation requests per day</div>';
                        //     break;
                        // case 13:
                        //     document.getElementById('errs').innerHTML += '<div class="err">The user with this email is already validated</div>';
                        //     break;
                        // case 14:
                        //     document.getElementById('errs').innerHTML += '<div class="err">A user with this email does not exist</div>';
                        //     break;
                        // case 15:
                        //     document.getElementById('errs').innerHTML += '<div class="err">Failed to connect to database. Please try again later.</div>';
                        //     break;
                    default:
                        document.getElementById('errs').innerHTML += '<div class="err">une erreur s\'est produite. veuillez réessayer plus tard.</div>';
                }
            }
        } catch (e) {
            console.log(e)
            document.getElementById('errs').innerHTML = '<div class="err">une erreur s\'est produite. Veuillez ressayez plus tard.</div>';
        }
        setTimeout(function() {
            document.getElementById('errs').style.transition = transition;
            document.getElementById('errs').style.opacity = 1;
        }, 10);
    });
}