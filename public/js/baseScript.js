var conn = new WebSocket('ws://127.0.0.2:8080/vendor/Server.php');
// var connected = false;
conn.onopen = function(e) {
    console.log("connected");
    console.log(document.getElementById('data'));
    conn.send(JSON.stringify([
        [document.getElementById('userID').getAttribute('value'), document.getElementById('userToken').getAttribute('value')], 'Connection', [null]
    ]))
};

function sendMessage() {
    conn.send(JSON.stringify([
        [document.getElementById('userID').value, document.getElementById('userToken').value], 'SendMessage', [document.getElementById('userIDTo').value, document.getElementById('chatin').value]
    ]))
}

conn.onmessage = function(e) {
    var res = JSON.parse(e.data);
    // console.log('test');
    console.log(res);
    // if (res[0] == 'CONNECTION_TOKEN') {
    //     document.querySelector('head').innerHTML += '<meta name="' + 'CONNECTION_TOKEN' + '" content="' + res[1] + '">';
    //     connected = true;

    // }
};