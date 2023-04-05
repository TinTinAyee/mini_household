<nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-3 mb-5 bg-body rounded">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-secondary" href="/transaction"> Transaction </a>
                </li>
            </ul>
        </div>

        <?php if($_SESSION['user']['email'] ?? false ): ?>
        <span class="navbar-text me-2">
            <?= $_SESSION['user']['email']; ?>
        </span>

        <span class="navbar-text me-2">
            |
        </span>

        <span class="navbar-text me-2">
            <a href="/logout" class="text-decoration-none">Logout</a>
        </span>

        <?php else: ?>
        <span class="navbar-text me-2">
            <a href="/register" class="text-decoration-none">Register</a>
        </span>

        <span class="navbar-text me-2">
            |
        </span>

        <span class="navbar-text me-2">
            <a href="/login" class="text-decoration-none">Login</a>
        </span>
        <?php endif ; ?>
    </div>
</nav>