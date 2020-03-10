<nav class="navbar navbar-dark fixed-top bg-primary flex-md-nowrap p-0">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 text-white">EduCat</a>
    <!-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> -->
    <ul class="navbar-nav px-3 mr-auto">
        <li class="nav-item text-nowrap">
            <a class="nav-link active" href="/">Home</a>
        </li>
    </ul>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <a class="nav-link" href="/logout">Log out</a>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link " href="/admin">
                            <span data-feather="home"></span>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/admin/users">
                            <span data-feather="users"></span>
                            Users
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link " href="/admin/settings">
                            <span data-feather="settings"></span>
                            Settings
                        </a>
                    </li>
                    <?php if ($path === "admin/users") : ?>
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Actions</span>
                        </h6>
                        <ul class="nav flex-column mb-2">
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/users/create">
                                    <span data-feather="plus-circle"></span>
                                    Create user
                                </a>
                            </li>
                        </ul>
                    <?php endif; ?>
            </div>
        </nav>