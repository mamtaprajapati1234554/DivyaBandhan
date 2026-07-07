<?php
session_start();
require_once("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$search = $_GET['search'] ?? "";

// Logged-in user ko chhodkar dusre users
$sql = "
SELECT
    users.id,
    users.first_name,
    users.last_name,
    profiles.city,
    profiles.state,
    profiles.occupation,
    profiles.profile_photo
FROM users
LEFT JOIN profiles
ON users.id = profiles.user_id
WHERE users.id != ?
";

$params = [$user_id];

if (!empty($search)) {
    $sql .= " AND (
        users.first_name LIKE ?
        OR users.last_name LIKE ?
        OR profiles.city LIKE ?
        OR profiles.occupation LIKE ?
    )";

    $keyword = "%".$search."%";

    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
    $params[] = $keyword;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$members = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Search Members</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f7fb;
}

.card{
    margin-bottom:20px;
}

img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:50%;
}

</style>

</head>

<body>

<div class="container mt-4">

<h2 class="mb-4">Search Members</h2>

<form method="GET">

<div class="input-group mb-4">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by Name, City, Profession"
value="<?= htmlspecialchars($search) ?>">

<button class="btn btn-primary">
Search
</button>

</div>

</form>

<div class="row">

<?php

if(count($members)>0){

foreach($members as $row){

$image="../uploads/default.png";

if(!empty($row['profile_photo'])){
$image="../uploads/".$row['profile_photo'];
}

?>

<div class="col-md-6">

<div class="card shadow">

<div class="card-body text-center">

<img src="<?= $image ?>">

<h4 class="mt-3">
<?= htmlspecialchars($row['first_name']." ".$row['last_name']) ?>
</h4>

<p>
<?= htmlspecialchars($row['city']) ?>,
<?= htmlspecialchars($row['state']) ?>
</p>

<p>
<?= htmlspecialchars($row['occupation']) ?>
</p>

<a href="profile.php?id=<?= $row['id'] ?>" class="btn btn-primary">
View Profile
</a>

</div>

</div>

</div>

<?php

}

}else{

echo "<h5>No Member Found.</h5>";

}

?>

</div>

</div>

</body>
</html> 