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
    request('../requests/createAccount.php', '#registerForm', setloader = true, function(data) {
        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        console.log(data);
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

/**
 * @function registerpro
 * @param none
 */
function registerpro() {
    request('../requests/createProAccount.php', '#registerForm', setloader = true, function(data) {
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
    request('../requests/login.php', '#loginform', setloader = true, function(data) {

        document.getElementById('errs').innerHTML = "";
        var transition = document.getElementById('errs').style.transition;
        document.getElementById('errs').style.transition = "none";
        document.getElementById('errs').style.opacity = 0;
        try {
            console.log(data);
            data = JSON.parse(data);
            console.log(data);

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
    request('../requests/logout.php', false, setloader = true, function(data) {
        console.log(data);
        try {
            data = JSON.parse(data);
            if (data === 0) {
                window.location = '../';
            } else {
                window.location = window.location;
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
    if (document.getElementsByClassName('search__input')[0].value != "") {
        window.location.href = './home.php?query=' +
            document.getElementsByClassName('search__input')[0].value;
    }

}

function modifyUser() {
    request('../controller/user.php', '#modifprofile', setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        if (data === 0) {
            document.getElementById('err').innerHTML += '<div>vos données on bien été enregistrées</div>';
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

function newPrestation() {
    request('../controller/serviceManager.php', '#addFerviceForm', setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;
        data = JSON.parse(data)

        if (data === 0) {
            document.getElementById('err').innerHTML += '<div>Prestation enregistrée, elle sera utilisable quand un administrateur l\'aura approuvée</div>';
            document.getElementById('addFerviceForm').reset();
        } else {
            fetch('../public/js/error.json')
                .then(res => res.json())
                .then(res => document.getElementById('err').innerHTML += res['addPresta'][data]);
        }

        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}


function sendResetPasswordAttempt() {
    request('../controller/user.php', "#resetPasswordAttempt", setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;
        console.log(data);
        data = JSON.parse(data)

        if (data === 0) {
            document.getElementById('err').innerHTML += '<div>Un email vous a été envoyé il vous suffit de cliquer sur le lien</div>';
            document.getElementById('resetPasswordAttempt').reset();
        } else {
            fetch('../public/js/error.json')
                .then(res => res.json())
                .then(res => document.getElementById('err').innerHTML += res['resetPasswordSend'][data]);
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

async function changeComboBoxValues() {
    var addpréstationdomain = document.getElementById('catégory');

    async function createCB(cat) {
        var mainRes = "";

        await fetch('../public/js/domains.json')
            .then(async(res) => {
                await res.json()
                    .then(async(res) => {
                        await res[cat].forEach(subDomain => {
                            mainRes += ` <option value="${subDomain[0]}">${subDomain[1]}</option>` // a changer dans le json
                        });
                    })
            })
        return mainRes;
    }

    addpréstationdomain.addEventListener('change', async(event) => {
        if (event.target.value === 'telephone') {
            document.getElementById('souscatjs').innerHTML = `<select class="sous-cat" id="tel" name="subdomain"><option value="">--sous catégorie--</option>${await createCB('telephone')}</select>`;
        } else if (event.target.value === 'ordinateur') {
            document.getElementById('souscatjs').innerHTML = `<select class="sous-cat" id="ordi" name="subdomain" ><option value="">--sous catégorie--</option>${await createCB('ordinateur')}</select>`;
        } else if (event.target.value === 'electro menager') {
            document.getElementById('souscatjs').innerHTML = `<select class="sous-cat" id="élec" name="subdomain"> <option value="">--sous catégorie--</option>${await createCB('electro menager')}</select>`;
        }
    });
}


function remouvepresta(a) {
    console.log(a);
    //request('../../controller/serviceManager.php', arguments[0], setloader = true, function(data){
    //    console.log('coucou');
    //}
}

drapeau = document.getElementById('drapeau');
select = document.getElementById('selecterdedrapeu');

function pays() {
    drapeau.style.display = 'none';
    select.style.display = 'flex';
}

function fr() {
    // drapeau.style.display = 'block';
    // drapeau.style.background = 'url("../../assets/drapeaufrancais.png")';
    // drapeau.style.backgroundSize = 'cover';
    // select.style.display = 'none';
    // document.getElementById('langinput').value = 'fr';
    // request('../controller/lang.php', "#langform", setloader = true, function(data) { window.location = window.location; })

    // Construct URLSearchParams object instance from current URL querystring.
    var queryParams = new URLSearchParams(window.location.search);

    // Set new or modify existing parameter value. 
    queryParams.set("l", "fr");

    // Replace current querystring with the new one.
    history.replaceState(null, null, "?" + queryParams.toString());
    window.location = window.location;
}

function en() {
    // drapeau.style.display = 'block';
    // drapeau.style.background = 'url("../../assets/drapeauUS.png")';
    // drapeau.style.backgroundSize = 'cover';
    // select.style.display = 'none';
    // document.getElementById('langinput').value = 'en';
    // request('../controller/lang.php', "#langform", setloader = true, function(data) {
    //     window.location = window.location;
    // }) var queryParams = new URLSearchParams(window.location.search);

    var queryParams = new URLSearchParams(window.location.search);

    // Set new or modify existing parameter value. 
    queryParams.set("l", "en");

    // Replace current querystring with the new one.
    history.replaceState(null, null, "?" + queryParams.toString());
    window.location = window.location;
}
drapeaure = document.getElementById('drapeaure');
selectre = document.getElementById('selecterdedrapeure');

function paysre() {
    drapeaure.style.display = 'none';
    selectre.style.display = 'flex';
}
ouver = 0;
    function navresponsive() {
        burger();
        navi = document.getElementsByClassName('contentnav')[0];
        if (ouver === 1) {
            navi.style.top =  - 100 + 'vh';
            ouver = 0;
        } else if (ouver === 0) {
            navi.style.top = 10 + 'vh';
            ouver = 1;
        }
    }
    function burger() {
        burgerhaut = document.getElementsByClassName('burgerhaut')[0];
        burgermillieu = document.getElementsByClassName('burgermillieu')[0];
        burgerbas = document.getElementsByClassName('burgerbas')[0];
        bull = document.getElementsByClassName('lesbull')[0];
        ulnavresponsiv = document.getElementsByClassName('ulnavresponsiv')[0];
        if (ouver === 1) {
            burgerhaut.style.transform="translateY(0vh) rotate(0)";
            burgermillieu.style.opacity= 1;
            burgermillieu.style.transition= "0.5s 0.25s ease-in-out";
            burgerbas.style.transform="translateY(0vh) rotate(0)";
            bull.style.top = -100 + 'vh';
            ulnavresponsiv.style.top = -100 + 'vh ';
            document.getElementsByClassName('burgeur')[0].setAttribute('onclick','');
            setTimeout(function test(){document.getElementsByClassName('burgeur')[0].setAttribute('onclick','navresponsive()')},1000);
        } else if (ouver === 0) {
            burgerhaut.style.transform="translateY(2.5vh) rotate(45deg)";
            burgermillieu.style.opacity= 0;
            burgermillieu.style.transition= "0s";
            burgerbas.style.transform="translateY(-3.25vh) rotate(-45deg)";
            bull.style.top = 0 + 'px';
            ulnavresponsiv.style.top = 0 + 'px ';
            document.getElementsByClassName('burgeur')[0].setAttribute('onclick','');
            setTimeout(function test(){document.getElementsByClassName('burgeur')[0].setAttribute('onclick','navresponsive()')},1000);
        }
    }