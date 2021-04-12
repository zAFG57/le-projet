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

                if (data[i] === 0) {
                    document.getElementById('errs').innerHTML += '<div>Votre compte a bien été crée,</br> un Email de vérification vous a été envoyé </div>';
                    document.getElementById('registerForm').reset();
                    break;
                } else {
                    fetch('../public/js/error.json')
                        .then(res => res.json())
                        .then(res =>
                            document.getElementById('errs').innerHTML += res['register'][data[i]]
                        );
                    break
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

function registerpro() {
    request('../model/create_professional_account.php', '#registerForm', function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        try {
            data = JSON.parse(data);
            // console.log(data)
            if (!(data instanceof Array)) { throw Exception('bad data'); }

            //Show errors to user
            for (var i = 0; i < data.length; ++i) {

                if (data[i] === 0) {
                    document.getElementById('errs').innerHTML += '<div>Votre compte a bien été crée,</br> un Email de vérification vous a été envoyé </div>';
                    document.getElementById('registerForm').reset();
                    break;
                } else {
                    fetch('../public/js/error.json')
                        .then(res => res.json())
                        .then(res =>
                            document.getElementById('errs').innerHTML += res['register'][data[i]]
                        );
                    break
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

function login() {
    request('../model/login.php', '#loginform', function(data) {

        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;

        if (data === '0') {
            window.location = '../';
        } else {
            fetch('../public/js/error.json')
                .then(res => res.json())
                .then(res =>
                    document.getElementById('errs').innerHTML += res['login'][data]
                );
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
        if (data === '0') {
            document.getElementById('errs').innerHTML += '<div>Email envoyé, reagrdez dans votre boite mail et cliquez sur le lien</div>';
            document.getElementById('verificationForm').reset();
        } else {
            fetch('../public/js/error.json')
                .then(res => res.json())
                .then(res =>
                    document.getElementById('errs').innerHTML += res['validEmail'][data]
                );
        }

        setTimeout(function() {
            document.getElementById('errs').style.transition = transition;
            document.getElementById('errs').style.opacity = 1;
        }, 10);
    })
}



function searchf() {
    request('../model/search.php', '#search', function(data) {
        document.getElementById('resSearch').innerHTML = "";
        var transition = document.getElementById('resSearch').style.transition;
        document.getElementById('resSearch').style.transition = "none";
        document.getElementById('resSearch').style.opacity = 0;
        document.getElementsByClassName('maindiv')[0].style.display = 'none';
        console.log(data)
        data = JSON.parse(data);


        const createGrid = (data) => {
            res = '<div class="grid">'
            res = `votre recherche : ${search}`
            data.forEach(element => {
                res += `<div class="card">
                    <div class="cardgauche">
                        <div class="cardimg">   <img src="${element['imgUsr'] || 'https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg'}"/>  </div>
                    </div>
                    <div class="carddroit">
                        <div class="cardnom"><h1>${element['username']}</h1></div>
                        <div class="cardétoile">${createStar(element['note'])}</div>
                        <div class="carddescription"><h3>${element['descUsr'] || 'coucou je suis un pro qui sait réparer plein de truques'}</h3></div>
                    </div>
                </div>`

            });
            res += '</div>'
            return res;
        }

        const createStar = (nbStars) => {
            res = "";
            while (nbStars > 0) {
                res += '★';
                nbStars--;
            }
            return res;
        }

        switch (data) {
            case -1:
                document.getElementById('resSearch').innerHTML += '<div class="noResFound">Trois lettres minimum sont requises</div>';
                break;
            case -2:
                document.getElementById('resSearch').innerHTML += '<div class="noResFound">Aucun resultat trouvé</div>';
                break;

            default:
                var search = data.pop(-1);
                document.getElementById('resSearch').innerHTML += createGrid(data);
                break;
        }


        setTimeout(function() {
            document.getElementById('resSearch').style.transition = transition;
            document.getElementById('resSearch').style.opacity = 1;
        }, 10);
        document.getElementById('search').reset();
    })
}