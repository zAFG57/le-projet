function request(url, data, setloader = true, callback) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    if (setloader) {
        var loader = document.createElement('div');
        loader.className = 'loader';
        document.body.appendChild(loader);
        loaderdiv(loader);
    }

    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4) {
            if (callback) {
                callback(xhr.response);
            }
            if (setloader) {
                loader.remove();
            }
        }
    });

    var formdata = data ? (data instanceof FormData ? data : new FormData(document.querySelector(data))) : new FormData();

    var csrfMetaTag = document.querySelector('meta[name="csrf_token"]');
    if (csrfMetaTag) {
        formdata.append('csrf_token', csrfMetaTag.getAttribute('content'));
    }

    xhr.send(formdata);
}

function loaderdiv(loader) {
    var loadera = document.createElement('div');
    var loaderb = document.createElement('div');
    var loaderc = document.createElement('div');
    loadera.className = 'loadera';
    loaderb.className = 'loaderb';
    loaderc.className = 'loaderc';
    loader.appendChild(loadera);
    loader.appendChild(loaderb);
    loader.appendChild(loaderc);

}

function register() {
    request('../controller/create_account.php', '#registerForm', setloader = true, function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        // console.log(data);
        try {
            data = JSON.parse(data);


            if (data === 0) {
                document.getElementById('errs').innerHTML += '<div>Votre compte a bien été crée,</br> un Email de vérification vous a été envoyé </div>';
                document.getElementById('registerForm').reset();
            } else {
                fetch('../public/js/error.json')
                    .then(res => res.json())
                    .then(res => document.getElementById('errs').innerHTML += res['register'][data]);
            }

            setTimeout(function() {
                document.getElementById('errs').style.transition = transition;
                document.getElementById('errs').style.opacity = 1;
            }, 10);
        } catch (e) {

        }
    });
}

///////////////////////////////////////////////////////////test début//////////////////////
function registerpro() {
    request('../controller/create_professional_account.php', '#registerForm', setloader = true, function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;

        try {
            data = JSON.parse(data);

            if (data === 0) {
                document.getElementById('errs').innerHTML += '<div>Votre compte a bien été crée,</br> un Email de vérification vous a été envoyé </div>';
                document.getElementById('registerForm').reset();
            } else {
                fetch('../public/js/error.json')
                    .then(res => res.json())
                    .then(res => document.getElementById('errs').innerHTML += res['register'][data]);
            }

            setTimeout(function() {
                document.getElementById('errs').style.transition = transition;
                document.getElementById('errs').style.opacity = 1;
            }, 10);
        } catch (e) {

        }
    });
}
///////////////////////////////////////////////////////////test fin///////////////////////



function login() {
    request('../controller/login.php', '#loginform', setloader = true, function(data) {

        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        // console.log(data);
        try {
            data = JSON.parse(data);

            if (data == 0) {
                window.location = '../';
            } else {
                fetch('../public/js/error.json')
                    .then(res => res.json())
                    .then(res => document.getElementById('errs').innerHTML += res['login'][data]);
            }

            setTimeout(function() {
                document.getElementById('errs').style.transition = transition;
                document.getElementById('errs').style.opacity = 1;
            }, 10);
        } catch (e) {

        }
    });

    document.getElementById('loginform').reset();
}

function logout() {
    request('../controller/logout.php', false, setloader = true, function(data) {
        // console.log(data)
        try {
            data = JSON.parse(data);
            if (data === 0) {
                window.location = '../view/log_in';
            }
        } catch (e) {

        }
    });
}

function sendValidateEmailRequest() {
    request('../controller/email_verification.php', '#verificationForm', setloader = true, function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;

        // console.log(data);
        try {
            data = JSON.parse(data);

            //Show errors to user
            if (data === 0) {
                document.getElementById('errs').innerHTML += '<div>Email envoyé, reagrdez dans votre boite mail et cliquez sur le lien</div>';
                document.getElementById('verificationForm').reset();
            } else {
                fetch('../public/js/error.json')
                    .then(res => res.json())
                    .then(res => document.getElementById('errs').innerHTML += res['validEmail'][data]);
            }

            setTimeout(function() {
                document.getElementById('errs').style.transition = transition;
                document.getElementById('errs').style.opacity = 1;
            }, 10);
        } catch (e) {

        }
    })
}



function searchf() {
    request('../controller/search.php', '#search', setloader = true, function(data) {
        document.getElementById('resSearch').innerHTML = "";
        var transition = document.getElementById('resSearch').style.transition;
        document.getElementById('resSearch').style.transition = "none";
        document.getElementById('resSearch').style.opacity = 0;
        document.getElementsByClassName('maindiv')[0].style.display = 'none';

        console.log(data);
        try {
            data = JSON.parse(data);
            // console.log(data);

            const createGrid = (data) => {
                res = '<div class="grid">'
                data.forEach(element => {
                    res += `<div class="card">
                    <div class="cardgauche">
                        <div class="cardimg">   <img src="${element['imgUsr'] || 'https://images.assetsdelivery.com/compings_v2/thesomeday123/thesomeday1231712/thesomeday123171200009.jpg'}"/>  </div>
                    </div>
                    <div class="carddroit">
                        <div class="cardnom"><h1>${element['username']}</h1></div>
                        <div class="cardétoile">${createStar(element['note'])}</div>
                        <div class="carddescription"><h3>${element['bio'] || 'coucou je suis un pro qui sait réparer plein de truques'}</h3></div>
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
                    document.getElementById('resSearch').innerHTML += createGrid(data);
                    break;
            }


            setTimeout(function() {
                document.getElementById('resSearch').style.transition = transition;
                document.getElementById('resSearch').style.opacity = 1;
            }, 10);
            document.getElementById('search').reset();

        } catch (e) {

        }
    })
}




function sendMessage() {
    request('../controller/chatProUser.php', '#message', setloader = false, function(data) {

        data = JSON.parse(data)
    })
    document.getElementById('message').reset();

}

function getMessage() {
    request('../controller/chatProUser.php', '#getMessage', setloader = false, function(data) {
        try {

            data = JSON.parse(data)

            const displayMessage = (data) => {
                res = "";
                data.forEach(element => {
                    res += `<div class="${element['isMe'] === true ? "me" : "you"}"><span>${element['message_content']}</span></div>`

                });
                return res;
            }

            const changeEncoding = (data) => {
                return data.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, "\"");
            }

            if (data instanceof Array) {
                if (changeEncoding(displayMessage(data)) != changeEncoding(document.getElementById('chat').innerHTML)) {
                    document.getElementById('chat').innerHTML = displayMessage(data);
                    getToBot();
                }
            }
            getMessage()
        } catch (e) {

        }

    })

}

function getConv() {
    request('../controller/chatProUser.php', '#getConv', setloader = false, function(data) {


        try {

            data = JSON.parse(data)

            const displayMessage = (data) => {
                res = "<div class=\"mesDiscussions\">Mes discussions</div>";
                data.forEach(element => {
                    res += `<a href="./chat?chatID=${element['chat_id']}" class="discutionlien">
                                <div>
                                    <h1 class="discutionnom">${element['username']}</h1>
                                    <h2 class="discutionmessage"><span>${element['isMe'] === true ? "Moi" : element['username']} : </span>${element['message_content']}</h2>
                                </div>
                            </a>`
                });
                return res;
            }

            const changeEncoding = (data) => {
                return data.replace(/&amp;/g, "&").replace(/&gt;/g, ">").replace(/&lt;/g, "<").replace(/&quot;/g, "\"");
            }

            if (data instanceof Array) {
                if (changeEncoding(displayMessage(data)) != changeEncoding(document.getElementById('scroll').innerHTML)) {
                    document.getElementById('scroll').innerHTML = displayMessage(data);
                }
            }
            getConv()

        } catch (e) {

        }
    })
}


function modifyUser() {
    request('../controller/user.php', '#modifprofile', setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        console.log(data);
        if (data === 0) {
            document.getElementById('err').innerHTML += '<div>vos données on bien été enregistré</div>';
            document.getElementById('modifprofile').reset();
        } else {
            fetch('../public/js/error.json')
                .then(res => res.json())
                .then(res => document.getElementById('err').innerHTML += res['modifyUser'][data]);
        }

        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}

function modifyInputName() {
    document.getElementById('nameinputmodif').removeAttribute('readonly');
    document.getElementById('nameinputmodif').focus();
}

function modifyInputEmail() {
    document.getElementById('mailinputmodif').removeAttribute('readonly');
    document.getElementById('mailinputmodif').focus();
}

function modifyInputpassword() {
    document.getElementById('passwordinputmodif').removeAttribute('readonly');
    document.getElementById('passwordinputmodif').focus();
}

function anulermodif() {
    document.location = document.location;
}