<?php
echo($_POST['username']);
echo("<p>");
echo($_POST['password']);
echo("<p>");
echo($_POST['passwordVerify']);
echo('<p>');
echo($_POST['email']);

if( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['passwordVerify']) && isset($_POST['email'])){
    echo("oeoeoe"); 
}