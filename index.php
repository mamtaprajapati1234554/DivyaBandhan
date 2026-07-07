<?php
session_start();
require_once("config/database.php");

// Fetch Premium Members
$stmt = $pdo->prepare("
    SELECT
        u.id,
        u.first_name,
        u.last_name,
        u.gender,
        u.dob,
        p.city,
        p.profile_photo
    FROM users u
    INNER JOIN profiles p
        ON u.id = p.user_id
    LIMIT 8
");

$stmt->execute();
$premiumMembers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DivyaBandhan</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/premium-members.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <!-- Navbar -->
    <?php include("includes/home-navbar.php"); ?>

    <!-- Hero Section -->
    <section class="hero-section">

        <img src="assets/images/hero banner.jpg"
            alt="Hero Banner"
            class="hero-img">

        <div class="hero-text">
            <h1>Two Hearts, One Beautiful Forever</h1>
            <h1 class="highlight">Make Yours Special</h1>

            <p>
                India's trusted matrimonial platform to find your perfect life partner.
            </p>
        </div>

        <div class="register-card">

            <h3>Create Your Account</h3>

            <p>
                Fill out the form to get started.
            </p>

            <a href="auth/register.php" class="register-btn-home">
                Register Now
            </a>

           

        </div>

    </section>

    <!-- Featured Members -->
    <section class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">
                <h2 class="fw-bold">
                    Featured Profiles
                </h2>

                <p class="text-muted">
                    Meet Our Verified Members
                </p>
            </div>

            <div class="row">

                <?php if (!empty($premiumMembers)): ?>

                    <?php foreach ($premiumMembers as $member): ?>

                        <?php
                        $photo = !empty($member['profile_photo'])
                            ? $member['profile_photo']
                            : "assets/images/default-profile.png";
                        ?>

                        <div class="col-lg-3 col-md-6 mb-4">

                            <div class="card shadow border-0 h-100">

                                <img src="<?= htmlspecialchars($photo); ?>"
                                    class="card-img-top"
                                    style="height:280px;object-fit:cover;">

                                <div class="card-body text-center">

                                    <h5 class="fw-bold">
                                        <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?>
                                    </h5>

                                    <p class="text-muted mb-2">
                                        📍 <?= htmlspecialchars($member['city']); ?>
                                    </p>

                                    <a href="dashboard/view-profile.php?id=<?= $member['id']; ?>"
                                        class="btn btn-danger rounded-pill px-4">
                                        View Profile
                                    </a>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="col-12 text-center">
                        <h4>No Profiles Found</h4>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>