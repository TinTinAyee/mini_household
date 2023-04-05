<?php 

require("../database.php");

  if (isset($_SESSION['user'])) {
    
    $user_id = $_SESSION['user']['id'];
    
    $id = $_GET['id'];
    $query = "DELETE FROM household WHERE id = $id AND user_id=$user_id";

    if(mysqli_query($conn,$query)){
        header('location:/transaction');
    }else{
        echo "delete fail !!!";
    }
}

?>