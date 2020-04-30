<?php 

session_start();

require_once "db.php";

if($_SERVER['REQUEST_METHOD'] === "POST"){
    // do something
    if(empty($_REQUEST['email']) || empty($_REQUEST['password'])){
        header('location: login.html?blank=true');
    }else{
        $email = mysqli_real_escape_string($con, $_REQUEST['email']);
        $password = mysqli_real_escape_string($con, $_REQUEST['password']);

        // strong encryption
        $hash_password = $email.$password;
        $sql = "SELECT id, email, user_password FROM users WHERE email = ?";

        $query = $con->prepare($sql);
        $query->bind_param("s", $param_email);
        $param_email = $email;

        // execute
        if($query->execute()){
            $query->store_result();
            if($query->num_rows === 1){
                
                $query->bind_result($id, $user_email, $user_password);
                if($query->fetch()){
                    if(password_verify($hash_password, $user_password)){
                        $_SESSION['user_id'] = $id;
                        $_SESSION['email'] = $user_email;
                        header('location: profile.php?loggedin=true');
                    }else{
                        echo "USER NAME OR PASSWORD IS INCORRECT";
                        
                       
                    }
                }
                else{
                    echo "SOMETHING WENT WRONG";
                }
            }else{
                echo "NO ACCOUNT FOUND";
            }

            $query->close();
        }
        // do something
    }
    $con->close();

} else{
    // do something
    echo " Direct access is Forbidden";
}



?>
