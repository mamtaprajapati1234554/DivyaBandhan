<div class="row">

    <div class="col-md-4">

        <?php if (!empty($row['profile_photo'])) { ?>

            <img src="../uploads/<?php echo htmlspecialchars($row['profile_photo']); ?>"
                 class="img-fluid rounded-start" alt="Profile">

        <?php } else { ?>

            <img src="../assets/images/default.png"
                 class="img-fluid rounded-start" alt="Default">

        <?php } ?>

    </div>

    <div class="col-md-8">

        <div class="card-body">

            <h4>
                <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?>
            </h4>

            <p>
                📍 <?php echo htmlspecialchars($row['city']); ?>,
                <?php echo htmlspecialchars($row['state']); ?>
            </p>

            <p>
                💼 <?php echo htmlspecialchars($row['occupation']); ?>
            </p>

            <p>
                🎓 <?php echo htmlspecialchars($row['education']); ?>
            </p>

            <p>
                ₹ <?php echo htmlspecialchars($row['salary']); ?>
            </p>

            <a href="#" class="btn btn-danger btn-sm">Interest</a>

            <a href="#" class="btn btn-primary btn-sm">Chat</a>

        </div>

    </div>

</div>          