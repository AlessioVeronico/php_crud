<?php
if(!empty($_SESSION['id'])){
    header('Location:manage.php');
}
if(!empty($_POST)){
    
    include 'classes/Crud.php';
    $create = new Crud;
    $create -> createData();
    header('Location:index.php');
}

include 'parts/header.php';
include 'classes/Form.php';

$signUp = new FormData;
$signUp -> openForm('post','signUp.php');

$signUp -> dataForm('text', 'name','name', 'Write your name', '','' );
$signUp -> dataForm('text', 'surname','surname', 'Write your surname', '','' );
$signUp -> dataForm('email', 'email','email', 'Write your email', '','' );
$signUp -> dataForm('password', 'password','password', 'Choose your password', '','' );

$signUp -> closeForm('submit', 'Sign Up', 'btn-primary');





?>

    <div class="container"><a href="index.php">Already Sign Up? Log in here<a></div>

<?php
include 'parts/footer.html';