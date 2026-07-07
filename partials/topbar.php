<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-body">

        <!-- Search -->

        <form action="index.php" method="GET">

            <div class="input-group">

                <span class="input-group-text bg-white border-end-0">
                    🔍
                </span>

                <input
                    type="text"
                    name="search"
                    class="form-control border-start-0"
                    placeholder="Search by Name, City, Profession"
                    value="<?= htmlspecialchars($search ?? '') ?>">

                <button class="btn btn-primary" type="submit">
                    Search
                </button>

            </div>

        </form>

        <!-- Filters -->

        <div class="mt-3 d-flex flex-wrap gap-2">

            <a href="index.php" class="btn btn-outline-secondary btn-sm">
                All
            </a>

            <a href="index.php?verified=1" class="btn btn-outline-success btn-sm">
                Verified
            </a>

            <a href="index.php?online=1" class="btn btn-outline-primary btn-sm">
                Online
            </a>

            <a href="index.php?nearby=1" class="btn btn-outline-warning btn-sm">
                Nearby
            </a>

            <a href="index.php?premium=1" class="btn btn-outline-danger btn-sm">
                Premium
            </a>

        </div>

    </div>

</div>