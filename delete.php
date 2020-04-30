<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header('location: index.php?isloggedin=false');
    exit;
} else if(!isset($_GET['id'] )|| $_GET['id'] === ""){
    header('location: profile.php');
}
require_once "db.php";
$sql = "SELECT * FROM person WHERE id=".$_GET['id']. " AND users_id=".$_SESSION['user_id'];

if($query = $con->query($sql)){
    if($query->num_rows > 0){

        $del_sql = "DELETE FROM person WHERE id= ?";
        if($del = $con->prepare($del_sql)){
            $del->bind_param('s', $id);
            $id = $_GET['id'];
            if($del->execute()){
                header('location: profile.php?record=deleted');
            } else{
                header('location: profile.php?record=404');
            }
        }

    }else{
       echo "no record found";
    }
    $query->close();
} else{
    // err
    echo "ERROR IN DELETING RECORD";
}
$con->close();
?>