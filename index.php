<?php 
session_start();
  if(isset($_GET['logout'])&& $_GET['logout'] == "true"){
      session_destroy();
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

    // Form Validation

        function validate(){
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var alert = document.getElementById("alert");
            
            if(email === ""){
               
                alert.innerHTML = "Please Enter your Email";
                alert.style.display = "block"
                return false
            }else if(password === ""){

                alert.innerHTML = "Please Enter your Password";
                alert.style.display = "block"
                return false
            } else{
                return true
            }
           
        }

        
    </script>
</head>
<body>
    <div style="margin-top:5%; padding:15px;" class="col-3 mx-auto shadow p-3 mb-5 bg-white rounded">
 <!-- logout message -->
    <?php
    if(isset($_GET['logout']) && $_GET['logout'] === "true"){
      ?>
       <div class="alert alert-success" role="alert">
         You are logged out successfully!
       </div>
       <?php
  }
  ?>
  <!-- user created message -->
  <?php
    if(isset($_GET['user']) && $_GET['user'] === "created"){
      ?>
       <div class="alert alert-success" role="alert">
        User created Successfully!
        <br>
        Please Login to continue!
       </div>
       <?php
  }
  ?>
<h3>Please Login</h3>
    <div id="alert" style="display:none;" class="alert alert-danger" role="alert">

    
    </div>
    <form onsubmit="return validate()" action="login.php" method="POST">
        <div class="form-group ">
          <label for="exampleInputEmail1">Email address</label>
          <input id="email" type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input id="password" type="password" name="password" class="form-control" id="exampleInputPassword1">
        </div>
    
        <button type="submit" class="btn btn-primary">Login</button>
      </form>
      <br>
      <a href="register.php" class="btn btn-info block">Register Now</a>
    </div>
</body>
</html>