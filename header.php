<?php
    if (isset($_SESSION['email'])) {
        $sessionId = $_SESSION['id'];
        $userDataFromId = User::getUserDataFromId($sessionId);
    }

    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];
        $posts = Post::search($search);
        if (empty($posts)) {
            $emptystate = true;
        }
    }
    
?><nav class="navbar navbar-light border-bottom">
    <div class="container">
        <a href="index.php" class="navbar-brand">Smasssh</a>
    
        <div class="d-flex flex-wrap align-items-center justify-content-end">
            <?php if (!isset($_SESSION['email'])): ?>
            <form class="d-flex">
                <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                <a href="register.php" class="btn btn-primary">Signup</a>
            </form>
            <?php else: ?>
            <form class="header-search" action="" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search for projects" aria-label="Search for projects" aria-describedby="button-addon2">
                    <input class="btn btn-outline-primary btn-icon-search" type="submit" id="button-addon2" value=">">
                </div>
            </form>
            <a href="uploadProject.php" class="btn btn-primary m-3">Upload Project</a>
            <div class="flex-shrink-0 dropdown d-flex">
                <a href="#" class="d-block link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo $userDataFromId['profile_pic']; ?>" class="p-2 rounded-circle img-thumbnail" >
                </a>
                <ul class="dropdown-menu text-small shadow"  style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 34px, 0px);" aria-labelledby="dropdownUser2">
                    <li><a class="dropdown-item" href="profile.php?p=<?php echo $userDataFromId['id'] ?>">Profile</a></li>
                    <li><a class="dropdown-item" href="account-info.php">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</nav>