<?php

 include 'DatabaseConfig.php';
 // Creating MySQL Connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
    if( isset($_POST['email']) && isset($_POST['password']) ) //check is token is sent by the user
        {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users where username = '$email'";
        $result = $con->query($sql);
        
        if ($result->num_rows > 0) {

            while ($row[] = $result->fetch_assoc()) {

                $tem = $row;
            }

            $dbPWD = $tem[0]['password'];

            if (password_verify($password, $dbPWD)) {
                $userid = $tem[0]['id'];
                    tokenGenerate($userid);
            } else {

                $data=['success'=>false, 'message'=>'Password you entered was incorrect.'];
                echo json_encode($data);
            }

        } else {

            $data=['success'=>false, 'message'=>'The user is not registered.'];
            echo json_encode($data);
        }
    }else{
        $data=['success'=>false, 'message'=>'Email and Password are required.'];

        echo json_encode($data);
    }

    function tokenGenerate($userid){

        global $con;
        global $email;
        $length = 78;
        $token = bin2hex(random_bytes($length));
        $insert = "INSERT INTO user_sessions (uid,token)VALUES('$userid','$token')";
        $query = mysqli_query($con, $insert);
    

        if ($query) {
            //after the query is sucessfully executed!
            $data=[
                'email'=>$email,
                'token'=>$token,
                'success'=>true,
                'user_id'=>$userid,
                'message'=>'Login Successful'
            ];
            echo json_encode($data);

        } else {

            $data=['success'=>false, 'message'=>'Failed to login.'];

            echo json_encode($data);
        }
    }
?>
