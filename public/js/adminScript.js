function acceptPrestation(serviceID) {
    var service = document.querySelector("#" + serviceID)
    service.innerHTML += '<input type="hidden" value="true" name="accept"></input>'
        // return;
    request('../controller/serviceManager.php', "#" + serviceID, setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        console.log(data);
        data = JSON.parse(data)
        console.log(data);



        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}

function rejectPrestation(serviceID) {
    var service = document.querySelector("#" + serviceID)
    service.innerHTML += '<input type="hidden" value="true" name="accept"></input>'
        // return;
    request('../controller/serviceManager.php', "#" + serviceID, setloader = true, function(data) {
        document.getElementById('err').innerHTML = "";
        var transition = document.getElementById('err').style.transition;
        document.getElementById('err').style.transition = "none";
        document.getElementById('err').style.opacity = 0;

        console.log(data);
        data = JSON.parse(data)
        console.log(data);



        setTimeout(function() {
            document.getElementById('err').style.transition = transition;
            document.getElementById('err').style.opacity = 1;
        }, 10);

    })
}