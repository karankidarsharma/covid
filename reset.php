<?php


if($_SERVER['REQUEST_METHOD'] != 'POST' && isset($_GET['token']) && $_GET['token'] != ""){
    $token = $_GET['token']; 
    
} 

if($_SERVER['REQUEST_METHOD'] ==='POST'){
    require_once "db.php";
    $post_token = $_REQUEST['token'];
    $password = mysqli_real_escape_string($con, $_REQUEST['password']);

    // $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "SELECT email FROM users where reset_pass='".$post_token."'";
    if($query = $con->prepare($sql)){
        if($query->execute()){
            $query->store_result();
            if($query->num_rows === 1){
                $query->bind_result($email);
                if($query->fetch()){
                    $hash_password = $email.$password;
                    $password_hash = password_hash($hash_password, PASSWORD_DEFAULT);
                    // fetch email  and concatiante it with password to genrate a new password
                $sql = "UPDATE users SET user_password='".$password_hash."' WHERE reset_pass='".$post_token."'";
                if($query = $con->prepare($sql)){
                    if($query->execute()){
                        
                        // delete the token to avoid reuse
                        $sql = 'UPDATE users SET reset_pass= "" WHERE email="'.$email.'"';
                        if($query = $con->prepare($sql)){
                            if($query->execute()){
                                header("location:index.php?password=changed");
                            }
                            else{
                                echo "Password Not Changed";
                            }
                        }
                    }else{
                        echo "error";
                    }
                }
                
            
                }else{
                    echo "Ooops! somethong went wrong";
                }
            }else{
                echo "Something Went wrong!";
            }
        }
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
</head>
<body>
<div style="margin-top:5%; padding:15px;" class="col-3 mx-auto shadow p-3 mb-5 bg-white rounded">
   <!-- message -->
 
<h3>Enter new password</h3>
    <div id="alert" style="display:none;" class="alert alert-danger" role="alert">
    
    </div>
    <form onsubmit="return validate()" action="reset.php" method="POST">
        <div class="form-group ">
          <label for="password">Password</label>
          <input id="password" type="password" name="password" class="form-control" id="password" aria-describedby="emailHelp">
          <input  type="hidden" name="token" value="<?php echo $token ?>" class="form-control" id="password" aria-describedby="emailHelp">
        </div>    
        <button type="submit" class="btn btn-primary">Reset</button>
      </form>
    </div>
</body>
</html>