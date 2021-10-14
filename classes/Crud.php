<?php

class Crud {

    public function createData(){
        require('connection.php');

        $sql = 'INSERT INTO users(name, surname, email, password ) VALUES(:name, :surname, :email, :password)';

        $query = $db->prepare($sql);

        $query->bindParam(':name', $_POST['name'], PDO::PARAM_STR);
        $query->bindParam(':surname', $_POST['surname'], PDO::PARAM_STR);
        $query->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
        $query->bindParam(':password', $_POST['password'], PDO::PARAM_STR);


        if($query->execute()){
            echo '<span class="bg-success ">User added </span>';
        }else{
            
        }
    }

    public function readData(){

        require('connection.php');
        
        $sql = "SELECT * FROM users";
        $query = $db -> prepare($sql);
        
        if($query->execute()){

        }else{
            print_r($query->errorInfo());
        }

        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach($data as $user){
            if($_POST['email']==$user['email'] && $_POST['password']==$user['password']){
                $_SESSION['id']= $user['id'];
                $_SESSION['role']= $user['role'];
                $_SESSION['name']= $user['name'];

                header('Location:manage.php');
            }else{
                echo 'User not found, please sign up before trying to log in';
            }
        }

        
        }

    public function updateData($getId){

        require('connection.php');

        $sql='UPDATE users SET name=:name, surname=:surname, email=:email, password=:password, role=:role WHERE id= ' . $getId ;

        $query = $db->prepare($sql);
        $query->bindParam(':name',$_POST['name'],PDO::PARAM_STR);
        $query->bindParam(':surname',$_POST['surname'],PDO::PARAM_STR);
        $query->bindParam(':email',$_POST['email'],PDO::PARAM_STR);
        $query->bindParam(':password',$_POST['password'],PDO::PARAM_STR);
        $query->bindParam(':role',$_SESSION['role'],PDO::PARAM_STR);
        

        if($query ->execute()){
            header("Location:redirect.php");
        }else{
            ;
        }
    }

    public function deleteData($getId){
        require('connection.php');

        
        // $deleteData=new FormData;
        // echo '<div class="col-2"><div>';
        // $deleteData -> openForm('post', 'manage.php');
        // $deleteData -> dataForm('number','id','id','Please select id', '','');
        // $deleteData -> closeForm('submit','Delete', 'btn-danger');
        // echo '</div></div></div></div>';
        $sql="DELETE from users WHERE id = '".$getId."'  LIMIT 1";
        $query = $db->prepare($sql);
        $query->execute();
        $elDeleted = $query->rowCount();
        if($query->rowCount() == 1){
            header("Location:redirect.php");
        }else{
            ;
        }

    }

    public function manageUser(){
        
        require('connection.php');

        $sql = "SELECT * FROM users WHERE id=".$_SESSION['id'];

        $query = $db->prepare($sql);

        if($query->execute()){

        }else{
            print_r($query->errorInfo());
        }

        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        include ('Form.php');

       
        
            foreach($data as $user){
                $userData = new FormData;
                $userData -> openForm('post','manage.php');
                $userData -> dataForm('text', 'name','name', '', $user['name'],'' );
                $userData -> dataForm('text', 'surname','surname', '',$user['surname'],'' );
                $userData -> dataForm('email', 'email','email', '',$user['email'],'' );
                $userData -> dataForm('text', 'password','password', '',$user['password'],'' );
                

                $userData -> closeForm('submit', 'Update', 'btn-warning');
            }
        
    }

    public function manageAdmin(){
        
        require('connection.php');

        $per_page=5;
        $sql = 'SELECT id FROM users';
        $query = $db->query($sql);
        $tot_res = $query->rowCount();
        $tot_page = ceil($tot_res/$per_page);

        if(!isset($_GET['page'])){
            $page = 1;
        }else{
            $page = $_GET['page'];
        }

        $start = ($page - 1) * $per_page;

        $sql2 = "SELECT * FROM users LIMIT $start,$per_page ";
        

        $query2 = $db->prepare($sql2);

        if($query2->execute()){

        }else{
            print_r($query2->errorInfo());
        }

        $rows = $query2->fetchAll(PDO::FETCH_ASSOC);

        
        echo '<div class="container"><div class="row"><div class="col-6"><table class="table table-striped table-info mt-2 "><tr><th>ID</th><th>Name</th><th>Surname</th><th>Email</th><th>Password</th><th>Role</th></tr>';

        foreach($rows as $row){
            echo '<tr><td>'.$row['id'].'</td><td>'.$row['name'].'</td><td>'.$row['surname'].'</td><td>'.$row['email'].'</td><td>'.$row['password'].'</td><td>'.$row['role'].'</td><td><a href="manage.php?id='.$row['id'].'">Select user</a></td></tr>';
        }
        echo '</table>'; 

        for($page = 1; $page <= $tot_page; $page++){ ?>
    
            <a href="?page=<?=$page?>"><?=$page?></a>
        
        <?php }
        echo '</div>';
        include ('Form.php');

        if(!empty($_GET['id'])){
            
            $sql = "SELECT * FROM users WHERE id=".$_GET['id'];

                $query = $db->prepare($sql);

                if($query->execute()){

                }else{
                    print_r($query->errorInfo());
                }

                $data = $query->fetchAll(PDO::FETCH_ASSOC);

            echo '<div class="col-4"><div>';

            foreach($data as $user){

                $userData = new FormData;
                $userData -> openForm('post','manage.php?id='.$_GET['id']);
                $userData -> dataForm('text', 'id','id', '',$_GET['id'],'disabled' );
                $userData -> dataForm('text', 'name','name', '', $user['name'],''  );
                $userData -> dataForm('text', 'surname','surname', '',$user['surname'],'' );
                $userData -> dataForm('email', 'email','email', 'ciao',$user['email'],'' );
                $userData -> dataForm('text', 'password','password', '',$user['password'],'' );
                $userData -> dataForm('text', 'role','role', '',$user['role'],'' );
    
                $userData -> closeForm('submit', 'Update', 'btn-warning');
                
            }
                echo '</div></div>';
            
        }else{
            echo '<div class="col-4"><div>';

            $userData = new FormData;
            $userData -> openForm('post','manage.php');
            $userData -> dataForm('text', 'name','name', 'Select name','',''   );
            $userData -> dataForm('text', 'surname','surname', 'Select Surname','','' );
            $userData -> dataForm('email', 'email','email', 'Select email','','' );
            $userData -> dataForm('text', 'password','password', 'Select Password','','' );
            $userData -> dataForm('text', 'role','role', 'Select Role','','' );

            $userData -> closeForm('submit', 'Add User', 'btn-success');
            
            echo '</div></div>';
        }
       
    }

        
}
