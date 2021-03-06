<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container">
    <a class="navbar-brand" href="/">EduCat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">Home</a>
        </li>
        <?php if ($user->type === "ADMIN") : ?>
          <li class="nav-item">
            <a class="nav-link" href="/admin">Dashboard</a>
          </li>
        <?php endif; ?>
      </ul>
      <ul class="navbar-nav ml-auto">
        <?php if (!$user) : ?>
          <li class="nav-item">
            <a class="nav-link" href="/login">Log in</a>
          </li>
        <?php endif; ?>
        <?php if ($user) : ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              My Profile
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item text-primary" href="/profile">Visit my profile</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-danger" href="/logout">Log out</a>
            </div>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>