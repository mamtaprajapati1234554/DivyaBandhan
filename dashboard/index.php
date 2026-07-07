<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
?>

<div class="main-content">

    <h2>Recommended Matches</h2>

    <div id="profiles" class="profiles-grid">

        <!-- API DATA LOAD HOGA -->

    </div>

</div>  



<script>
async function loadProfiles() {

    let res = await fetch("dashboardProfileApi.php");
    let data = await res.json();

    let container = document.getElementById("profiles");

    if (!data.status) {
        container.innerHTML = "<p>No matches found</p>";
        return;
    }

container.innerHTML = data.data.map(user => `

<a href="profile.php?id=${user.user_id}" class="text-decoration-none text-dark">

<div class="card">

    <img src="../${user.profile_photo}" alt="${user.first_name}">

    <div class="card-body">

        <h3>${user.first_name} ${user.last_name}</h3>

        <p>${user.age}+ years, ${user.religion}</p>

        <p>${user.caste}, ${user.height} ft</p>

        <p>${user.education}</p>

        <p>${user.occupation}</p>

        <p>${user.salary}</p>

        <div class="actions">
            <button>❤️ Interest</button>
            <button>⭐ Shortlist</button>
            <button>💬 Chat</button>
        </div>

    </div>

</div>

</a>



`).join('');
}

loadProfiles();
</script>

</body>
</html>