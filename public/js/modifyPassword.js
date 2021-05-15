function modifyPassword() {
    request('../controller/user.php', '#modifPassword', setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        if (data === 0) {
            document.getElementById('err').innerHTML += '<div>Votre mot de passe a bien été modifier</div>';
            document.getElementById('modifprofile').reset();
        } else {
            fetch('../public/js/error.json')
                .then(res => res.json())
                .then(res => document.getElementById('err').innerHTML += res['modifyPassword'][data]);
        }

        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}