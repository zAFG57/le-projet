function sendMessage() {
    connToken = document.querySelector('meta[name="CONNECTION_TOKEN"]').getAttribute('content');
    console.log(connToken);
    JSON.stringify
    conn.send(JSON.stringify([connToken, "SEND MESSAGE", ['message', 124872]]))
}