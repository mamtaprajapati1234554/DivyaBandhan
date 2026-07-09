<?php

session_start();

require_once("../config/database.php");


if($_SERVER["REQUEST_METHOD"]=="POST"){


$profile_for = trim($_POST['profile_for']);
$firstname   = trim($_POST['firstname']);
$lastname    = trim($_POST['lastname']);
$gender      = trim($_POST['gender']);
$dob         = trim($_POST['dob']);
$email       = trim($_POST['email']);
$password    = $_POST['password'];
$confirm     = $_POST['confirm_password'];



// Validation

if(
empty($profile_for) ||
empty($firstname) ||
empty($lastname) ||
empty($gender) ||
empty($dob) ||
empty($email) ||
empty($password)
){

$_SESSION['error']="All fields are required";

header("Location: register.php");
exit;

}


// Password match

if($password != $confirm){

$_SESSION['error']="Password and Confirm Password do not match";

header("Location: register.php");
exit;

}



// Check email already exists

$check = $pdo->prepare(
"SELECT id FROM users WHERE email=?"
);

$check->execute([$email]);


if($check->rowCount()>0){


$_SESSION['error']="Email already registered";

header("Location: register.php");
exit;

}



try{


// Hash Password

$hashPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);



// Insert User

$sql="
INSERT INTO users
(
profile_for,
first_name,
last_name,
gender,
dob,
email,
password
)

VALUES
(?,?,?,?,?,?,?)

";


$stmt=$pdo->prepare($sql);


$stmt->execute([

$profile_for,
$firstname,
$lastname,
$gender,
$dob,
$email,
$hashPassword

]);



// Get New User ID

$user_id = $pdo->lastInsertId();


// Session

$_SESSION['user_id']=$user_id;

$_SESSION['user_name']=$firstname;



// Success Redirect

$_SESSION['success']="Registration Successful";


header("Location: ../profile/create_profile.php");
exit;



}
catch(PDOException $e){


$_SESSION['error']="Registration failed. Try again.";

header("Location: register.php");

exit;


}


}
