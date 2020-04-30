<?php session_start();

if(!isset($_SESSION['user_id'])){
    header('location: index.php?isloggedin=false');
    exit;
}else{
    require_once "db.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $person = mysqli_real_escape_string($con, $_REQUEST['person']);
        // $date = date('Y-m-d H:i:s');
        $date = date('Y-m-d');

        $sql = "INSERT INTO person(users_id, person, date_time) VALUES (?, ?, ?) ";

        if($query = $con->prepare($sql)){
            $query->bind_param('sss', $params_uid, $param_person, $param_date);

            $params_uid = $_SESSION['user_id'];
            $param_person = $person;
            $param_date = $date;

            if($query->execute()){
                header('location: profile.php?person=added');
            }else{
                echo "Error! Please Try Again!";
            }

            $query->close();

        }else{
            header('location: profile.php?person=failed-2');

        }
        // $con->close();

    }else{
           
            // header('location: index.php?login=false');
    }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Karan</title>
    <script>
        function validate(){
        var option = document.getElementById('option').value;
        var alert = document.getElementById('alert');

        if(option === ""){
            console.log("ERROR");
            alert.innerHTML = "Please choose an option";
            alert.style.display = "block"
            return false;
        }else{
            return true
        }
        }
    </script>
</head>
<body>
<div class="jumbotron">
<a class="btn btn-primary btn-lg" href="index.php?logout=true" role="button">Logout</a>
  <h1 class="display-4">Hello,<?php echo $_SESSION['email'];?></h1>
  <p class="lead">COVID-19 CARE</p>
  <div id="alert" style="display:none;" class="alert alert-danger" role="alert"></div>


 

  <hr class="my-4">
  <p class="lead">Please enter the name of person you interacted with:</p>
        <form onsubmit="return validate()" method="post" action="profile.php">

                    <input type="text" name="person" id="option" class="form-control form-control-sm">

                    <br>
                    <button type="submit" class="btn btn-primary btn-lg">Submit</button>
        </form>
<br><br>
<?php

$sql = "SELECT * FROM person WHERE users_id =".$_SESSION['user_id']." ORDER BY id DESC";

if($result = $con->query($sql)){
    if($result->num_rows > 0){
        ?>


<!-- New Record  -->
<?php 
  if(isset($_GET['person']) && $_GET['person'] === "added"){
      ?>
       <div class="alert alert-success" role="alert">
         Record added Successfully!
       </div>
       <?php
  }
  ?>
  
        <!-- Record Deleted -->
  <?php 
  if(isset($_GET['record']) && $_GET['record'] === "deleted"){
      ?>
       <div class="alert alert-success" role="alert">
         Record deleted Successfully!
       </div>
       <?php
  }
  ?>
        <table class="table">
           <tr scope="row">
              <th>
              PERSON NAME
              </th>
              <th>
              DATE
              </th>
              <th>
              DELETE
              </th>
              <?php
                    while($data = $result->fetch_array()){
                        echo "<tr scope='row'>";
                          echo "<td>".$data['person']."</td>";
                          echo "<td>".$data['date_time']."</td>";
                          echo "<td><a href=delete.php?id=".$data['id']." class='btn btn-danger' style='color:#fff;'>DELETE</a></td>";
                          
                        echo "</tr>";

                    }
              ?>
           </tr>
        </table>

        <?php 
        $result->free();
    }else{
        echo "You Haven't Interacted with someone";
    }
    
} else{
    echo "ERROR: Could not able to execute $sql. " . $con->error;
}
$con->close();
?>
  
</div>    
</body>
</html>




