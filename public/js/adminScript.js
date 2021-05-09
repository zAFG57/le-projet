function acceptPrestation() {
    form = document.getElementById('aceptServicesForm')
    form.innerHTML += '<input type="hidden" value="true" name="accept"></input>'
    request('../controller/serviceManager.php', '#aceptServicesForm', setloader = true, function(data) {
        document.getElementById('err').innerHTML = data;
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        data = JSON.parse(data)

        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}

function rejectPrestation() {
    form = document.getElementById('aceptServicesForm')
    form.innerHTML += '<input type="hidden" value="false" name="accept"></input>'
    request('../controller/serviceManager.php', "#aceptServicesForm", setloader = true, function(data) {
        document.getElementById('err').innerHTML = data;
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        data = JSON.parse(data)

        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}