<?php
 
session_start();
 
require_once("../config/database.php");
 
// ==========================
// Login Check
// ==========================
 
if (!isset($_SESSION['user_id'])) {
 
    header("Location: ../auth/login.php");
    exit;
}
 
$user_id = $_SESSION['user_id'];
 
 
// ==========================
// Get Form Data
// ==========================
 
$religion             = trim($_POST['religion']);
$caste                = trim($_POST['caste']);
$education            = trim($_POST['education']);
$occupation           = trim($_POST['occupation']);
$salary               = trim($_POST['salary']);
$height               = trim($_POST['height']);
$weight               = trim($_POST['weight']);
$city                 = trim($_POST['city']);
$state                = trim($_POST['state']);
$about_me             = trim($_POST['about_me']);

$gender               = trim($_POST['gender']);
$dob                  = trim($_POST['dob']);
$country              = trim($_POST['country']);
 
$pref_age_min         = trim($_POST['pref_age_min']);
$pref_age_max         = trim($_POST['pref_age_max']);
 
$pref_religion        = trim($_POST['pref_religion']);
$pref_marital_status  = trim($_POST['pref_marital_status']);
 
$pref_country         = trim($_POST['pref_country']);
$pref_mother_tongue   = trim($_POST['pref_mother_tongue']);
 
$pref_education       = trim($_POST['pref_education']);
 
// IMPORTANT
// Preferred Caste dropdown ka name pref_caste hona chahiye
$pref_caste = isset($_POST['pref_caste'])
    ? trim($_POST['pref_caste'])
    : "";
 
 
// Database me columns hain lekin form me fields nahi hain
// Isliye filhal blank rakh rahe hain
 
 
 
 
 
// ==========================
// Validation
// ==========================
 
if (
    empty($religion) ||
    empty($caste) ||
    empty($education) ||
    empty($occupation) ||
    empty($gender) ||
    empty($dob) ||
    empty($country)
) {
 
    $_SESSION['error'] = "Please fill all required fields.";
 
    header("Location: create_profile.php");
 
    exit;
}
 
 
 
// ==========================
// Profile Photo Upload
// ==========================
 
$profile_photo = "";
 
if (
    isset($_FILES['profile_photo']) &&
    $_FILES['profile_photo']['error'] == 0
) {
 
    $folder = "../uploads/profiles/";
 
    if (!is_dir($folder)) {
 
        mkdir($folder, 0777, true);
    }
 
    $extension = pathinfo(
        $_FILES['profile_photo']['name'],
        PATHINFO_EXTENSION
    );
 
    $fileName = time() . "_" . rand(1000,9999) . "." . $extension;
 
    $target = $folder . $fileName;
 
    if (move_uploaded_file(
        $_FILES['profile_photo']['tmp_name'],
        $target
    )) {
 
        $profile_photo = "uploads/profiles/" . $fileName;
 
    }
 
}
 
 
 
// ==========================
// Check Existing Profile
// ==========================
 
$check = $pdo->prepare(
    "SELECT * FROM profiles WHERE user_id=?"
);
 
$check->execute([$user_id]);
 
$profile = $check->fetch(PDO::FETCH_ASSOC);
 
try{
// ==========================
// INSERT PROFILE
// ==========================
 
if (!$profile) {
 
    $sql = "INSERT INTO profiles (
 
        user_id,
        gender,
        dob,
        religion,
        caste,
        education,
        occupation,
        salary,
        height,
        weight,
        city,
        state,
        country,
        about_me,
        profile_photo,
 
       
        pref_age_min,
        pref_age_max,
        pref_marital_status,
        pref_religion,
        pref_caste,
        pref_mother_tongue,
        pref_country,
        pref_education
 
    )
 
    VALUES (
 
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?,?,?,?,?,?,?,?,
        ?,?,?
 
    )";
 
    $stmt = $pdo->prepare($sql);
 
    $stmt->execute([
 
        $user_id,
        $gender,
        $dob,
        $religion,
        $caste,
        $education,
        $occupation,
        $salary,
        $height,
        $weight,
        $city,
        $state,
        $country,
        $about_me,
        $profile_photo,
 
        
        $pref_age_min,
        $pref_age_max,
        $pref_marital_status,
        $pref_religion,
        $pref_caste,
        $pref_mother_tongue,
        $pref_country,
        $pref_education
 
    ]);
 
}
 
// ==========================
// UPDATE PROFILE
// ==========================
 
else {
 
    // Agar nayi photo upload nahi hui to purani photo use karo
    if (empty($profile_photo)) {
        $profile_photo = $profile['profile_photo'];
    }
 
    $sql = "UPDATE profiles SET
 
        gender=?,
        dob=?,
        religion=?,
        caste=?,
        education=?,
        occupation=?,
        salary=?,
        height=?,
        weight=?,
        city=?,
        state=?,
        country=?,
        about_me=?,
        profile_photo=?,
 
        
        pref_age_min=?,
        pref_age_max=?,
        pref_marital_status=?,
        pref_religion=?,
        pref_caste=?,
        pref_mother_tongue=?,
        pref_country=?,
        pref_education=?
 
        WHERE user_id=?";
 
    $stmt = $pdo->prepare($sql);
 
    $stmt->execute([
 
        $gender,
        $dob,
        $religion,
        $caste,
        $education,
        $occupation,
        $salary,
        $height,
        $weight,
        $city,
        $state,
        $country,
        $about_me,
        $profile_photo,
 
        
        $pref_age_min,
        $pref_age_max,
        $pref_marital_status,
        $pref_religion,
        $pref_caste,
        $pref_mother_tongue,
        $pref_country,
        $pref_education,
 
        $user_id
 
    ]);
 
}
 
 
// ==========================
// SUCCESS
// ==========================
 
$_SESSION['success'] = "Profile saved successfully.";
 
header("Location: ../dashboard/index.php");
exit;
 
}
catch(PDOException $e){
 
    $_SESSION['error'] = $e->getMessage();
 
    header("Location: create_profile.php");
    exit;
}
 
?>