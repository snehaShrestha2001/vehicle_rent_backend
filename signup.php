<?php

 include 'DatabaseConfig.php';
 // Creating MySQL Connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 if(isset($_POST['email']) && $_POST('password')){

 }else{
    echo json_encode(
        [
            'message'=>'Please fill all the fields.',
            'success'=>false
        ]
    )
 }
 
 $email = $_POST['email'];
 
 // Getting Password from JSON $obj array and store into $password.
 $password = $_POST['password'];


 
 //Applying User Login query with email and password.
 
    $userQuery = "SELECT * FROM users WHERE username ='$email'";
    $sendingQuery = mysqli_query($con, $userQuery);
    $checkQuery = mysqli_num_rows($sendingQuery);

    if ($checkQuery > 0) {
        // if Username is already registered
        $data=[
            'email'=>$email,
            'success'=>false,
            'message'=>'User Already Exists.'
        ];
        echo json_encode($data);
    } else {

            trySignup();
    }

function trySignup()
{
    global $con;
    global $email;
    global $password;

    $hashPwd = password_hash($password, PASSWORD_DEFAULT);

    $insert = "INSERT INTO users (username,password)VALUES('$email','$hashPwd')";
    $query = mysqli_query($con, $insert);

    if ($query) {
        //after the query is sucessfully executed!
        $data=[
            'email'=>$email,
            'success'=>true,
            'message'=>'Signup Successful'
        ];
        echo json_encode($data);

    } else {

        $data=[
            'email'=>$email,
            'success'=>false,
            'message'=>'SignUp Failed.'
        ];
        echo json_encode($data);
    }
}

?>
