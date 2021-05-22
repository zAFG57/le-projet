// document.addEventListener('DOMContentLoaded', () => {
var conn = new WebSocket('ws://127.0.0.2:8080/vendor/Server.php');
var connected = false;
conn.onopen = function(e) {
    console.log("connected");
};

conn.onmessage = function(e) {
    var res = JSON.parse(e.data);
    if (res[0] == 'CONNECTION_TOKEN') {
        document.querySelector('head').innerHTML += '<meta name="' + 'CONNECTION_TOKEN' + '" content="' + res[1] + '">';
        connected = true;

    }
};



// });