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
                        document.getElementById('errs').innerHTML += '<div>Your account has been created!</div><div>Please validate your email by checking your inbox for a validation link before logging in.</div>';
                        document.getElementById('registerForm').reset();
                        break;
                    case 1:
                        document.getElementById('errs').innerHTML += '<div class="err">Invalid name entered. (only use letters, spaces, and hyphens)</div>';
                        break;
                    case 2:
                        document.getElementById('errs').innerHTML += '<div class="err">Invalid email entered.</div>';
                        break;
                    case 3:
                        document.getElementById('errs').innerHTML += '<div class="err">Email does not exist. (This domain does not have a mail server)</div>';
                        break;
                    case 4:
                        document.getElementById('errs').innerHTML += '<div class="err">Password must contain: <ul><li>At least 8 characters</li><li>At least one lower case letter</li><li>At least one upper case letter</li><li>At least one number</li><li>At least one special character (~?!@#$%^&*)</li></ul></div>';
                        break;
                    case 5:
                        document.getElementById('errs').innerHTML += '<div class="err">Passwords do not match. Please re-enter your confirmed password.</div>';
                        break;
                    case 6:
                        document.getElementById('errs').innerHTML += '<div class="err">Failed to add account to database. Please try again later.</div>';
                        break;
                    case 7:
                        document.getElementById('errs').innerHTML += '<div class="err">An account with this email already exists</div>';
                        break;
                    case 8:
                        document.getElementById('errs').innerHTML += '<div class="err">Failed to connect to the database. Please try again later.</div>';
                        break;
                    case 9:
                        document.getElementById('errs').innerHTML += '<div class="err">Invalid CSRF Token. Please try again later.</div>';
                        break;
                    case 10:
                        document.getElementById('errs').innerHTML += '<div class="err">Failed to send email. Please try again later.</div>';
                        break;
                    case 11:
                        document.getElementById('errs').innerHTML += '<div class="err">Failed to insert request into database. Please try again later.</div>';
                        break;
                    case 12:
                        document.getElementById('errs').innerHTML += '<div class="err">You have excedded your number of allowed validation requests per day</div>';
                        break;
                    case 13:
                        document.getElementById('errs').innerHTML += '<div class="err">The user with this email is already validated</div>';
                        break;
                    case 14:
                        document.getElementById('errs').innerHTML += '<div class="err">A user with this email does not exist</div>';
                        break;
                    case 15:
                        document.getElementById('errs').innerHTML += '<div class="err">Failed to connect to database. Please try again later.</div>';
                        break;
                    default:
                        document.getElementById('errs').innerHTML += '<div class="err">An unknown error occured. Please try again later.</div>';
                }
            }
        } catch (e) {
            document.getElementById('errs').innerHTML = '<div class="err">An unknown error occured. Please try again later.</div>';
        }
        setTimeout(function() {
            document.getElementById('errs').style.transition = transition;
            document.getElementById('errs').style.opacity = 1;
        }, 10);
    });
}