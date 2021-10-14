<?php

include 'parts/header.php';
include 'classes/Crud.php';
$manageData = new Crud;

if($_SESSION['role'] == 'admin'){

    $manageData -> manageAdmin();
    if(!empty($_GET['id'])){
        $manageData -> updateData($_GET['id']);
    }else{
        $manageData -> createData();
        
    }
    $deleteData=new FormData;
        echo '<div class="col-2"><div>';
        $deleteData -> openForm('post', 'manage.php');
        $deleteData -> dataForm('number','id','id','Id', '','');
        $deleteData -> closeForm('submit','Delete', 'btn-danger');
        echo '</div></div></div></div>';
        if(!empty($_POST['id'])){
            $manageData->deleteData($_POST['id']);

        }

    
    

}else{

    if(!empty($_POST)){
        $manageData -> updateData($_SESSION['id']);
    }
    $manageData -> manageUser();

}

include 'parts/footer.html';
