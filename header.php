<?php
    if (isset($_SESSION['email'])) {
        $sessionId = $_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($sessionId);
    }
    
?><nav class="navbar navbar-light">
    <div class="container border-bottom">
        <a href="index.php" class="navbar-brand">Smasssh</a>
    
        <div class="d-flex align-items-center">
            <?php if (!isset($_SESSION['email'])): ?>
            <form class="d-flex"> <!--class="d-none"-->
                <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                <a href="register.php" class="btn btn-primary">Signup</a>
            </form>
            <?php else: ?>
            <div class="flex-shrink-0 dropdown d-flex"> <!--class="d-flex"-->
                <a href="/php/smash/uploadProject.php" class="btn btn-primary m-3">Upload Project</a>
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="profile_pictures/<?php echo $userDataFromId['profile_pic']; ?>" class="p-2 rounded-circle" width="65px">
                </a>
                <ul class="dropdown-menu text-small shadow"  style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 34px, 0px);" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="#">Personal feed</a></li>
                    <li><a class="dropdown-item" href="usersettings.php">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>