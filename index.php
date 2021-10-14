<?php

include 'parts/header.php';

include 'classes/Form.php';
if(!empty($_SESSION['id'])){
    header('Location:manage.php');
}
$logIn = new FormData;
$logIn -> openForm('post', 'index.php' );

$logIn -> dataForm('email', 'email','email', 'Write your email', '','' );
$logIn -> dataForm('password', 'password','password', 'Write your password', '','' );
$logIn -> closeForm('submit', 'Log In', 'btn-primary');

if(!empty($_POST)){
    include 'classes/Crud.php';
    $check = new Crud;
    $check->readData();
}

?>

    <div class="container"><a href="signUp.php">Sign up here <a></div>

<?php
include 'parts/footer.html';