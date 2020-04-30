<?php
 require_once "db.php";

 if($_SERVER['REQUEST_METHOD'] === "POST"){
        if(empty($_REQUEST['email']) || empty($_REQUEST['password'])){

            
            // if empty
            header('location: register.php?error=empty');

        }else{
            $email = mysqli_real_escape_string($con, $_REQUEST['email']);
            $password = mysqli_real_escape_string($con, $_REQUEST['password']);
            $hash_password = $email.$password;

            // check if user already exist
            $sql = "SELECT id From users WHERE email = ? ";

            if($query = $con->prepare($sql)){
                $query->bind_param("s", $param_email);
                $param_email = $email;
                if($query->execute()){
                    $query->store_result();

                    if($query->num_rows == 1){
                        // if user already exists
                        header('location: register.php?register=taken');
                    } else{
                        // Insert to DB
                        $password_hash = password_hash($hash_password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO users (email, user_password) VALUES (?, ?)";

                        if($query = $con->prepare($sql)){
                            $query->bind_param("ss", $param_email, $param_password);

                            $param_email = $email;
                            $param_password = $password_hash;

                            if($query->execute()){

                                // redirect to login page. I kept is as index page
                                header('location: index.php?user=created');

                            } else{
                                echo "Ooops Something went wrong please try again!";
                            }

                            $query->close();

                        }
                    }
                    $con->close();
                } else{
                    echo "Ooooops! Something went wrong. Please try again later.";
                }

            } else {
                echo "Ooooops! Something went wrong. Please try again later.";
            }

            $query->close();
        }
    }else{
    //  err if method is not post
            header('location: register.php?error=Forbidden');
 }





?>