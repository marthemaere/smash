<nav class="navbar navbar-light">
    <div class="container border-bottom">
        <a class="navbar-brand">Smasssh</a>
        <a href="/php/smash/uploadProject.php" class="btn btn-primary">Upload Project</a>
        <div class="d-flex align-items-center">
            <form class="d-flex"> <!--class="d-none"-->
                <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                <a href="register.php" class="btn btn-primary">Signup</a>
            </form>
            <div class="flex-shrink-0 dropdown d-none"> <!--class="d-flex"-->
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
                <ul class="dropdown-menu text-small shadow"  style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 34px, 0px);" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#">Personal feed</a></li>
                    <li><a class="dropdown-item" href="usersettings.php">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>