<?php
require_once("config/database.php");

$sql = "SELECT u.id, u.first_name, u.last_name,
               p.city, p.occupation, p.profile_photo
        FROM users u
        INNER JOIN profiles p ON u.id = p.user_id";

$stmt = $pdo->query($sql);
$profiles = $stmt->fetchAll();
?>

<section class="featured-members">

    <h2>Featured Profiles</h2>

    <div class="profile-grid">

        <?php foreach($profiles as $profile): ?>

            <?php
            $photo = !empty($profile['profile_photo'])
                ? "uploads/".$profile['profile_photo']
                : "assets/images/default-profile.png";
            ?>

            <!-- YAHI CARD HAI -->
            <div class="profile-card">

                <a href="dashboard/profile.php?id=<?= $profile['id']; ?>">

                    <img src="<?= $photo; ?>" alt="Profile">

                    <div class="profile-content">

                        <h3>
                            <?= htmlspecialchars($profile['first_name']." ".$profile['last_name']); ?>
                        </h3>

                        <p><?= htmlspecialchars($profile['occupation']); ?></p>

                        <p><?= htmlspecialchars($profile['city']); ?></p>

                        <button class="view-btn">View Profile</button>

                    </div>

                </a>

            </div>

        <?php endforeach; ?>

    </div>

</section>