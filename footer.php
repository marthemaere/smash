<div class="bg-light mt-4">
    <footer class="container pt-4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <a href="#" class="navbar-brand my-2">Smasssh</a>
                <p class="py-3 pe-5">Smasssh is a design community created by and for students of <a href="https://weareimd.be/?utm_source=smash">Interactive Multimedia Design</a> at <a href="https://www.thomasmore.be/opleidingen/professionele-bachelor/informatiemanagement-en-multimedia/interactive-multimedia-design?utm_source=smash">Thomas More</a>.</p>
                <p class="">❤️ <strong>Did you know</strong> we have a WeAreIMD <a href="https://chrome.google.com/webstore/detail/imd-social-showcase/jcdbllfpadfhmjebbldaneiifhgllkdc">Chrome</a> or <a href="https://addons.mozilla.org/en-GB/firefox/addon/imd-social-showcase/">Firefox</a> extension you can install right now? Install it now to never miss an upload and to see <a href="https://wrk.weareimd.be">jobs & internships</a>.</p>
            </div>
            <div class="col-sm-12 col-md-2">
                <h4>Pages</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="index.php" class="nav-link px-0 text-muted">Home</a></li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item"><a href="profile.php?p=<?php echo $userDataFromId['id']; ?>" class="nav-link px-0 text-muted">Profile</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a href="login.php" class="nav-link px-0 text-muted">Profile</a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="col-sm-12 col-md-2">
                <h4>Profile</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="account-info.php" class="nav-link px-0 text-muted">Account info</a></li>    
                    <li class="nav-item"><a href="edit-profile.php" class="nav-link px-0 text-muted">Edit profile</a></li>
                    <li class="nav-item"><a href="change-password.php" class="nav-link px-0 text-muted">Change password</a></li>
                </ul>
            </div>
            <?php if (isset($_SESSION['id'])): ?>
            <div class="col-sm-12 col-md-2">
                <h4>Account</h4>
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="logout.php" class="nav-link px-0 text-muted">Log out</a></li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-between align-items-center py-3">
            <p class="text-muted">&nbsp;</p>
            <p class="text-muted fw-light" style="font-size: 0.8em">Made with love by <a href="https://github.com/Yanellevdb">Yanelle</a>, <a href="https://github.com/Jade-Apers">Jade</a>, <a href="https://github.com/ellendeveth">Ellen</a> & <a href="https://github.com/fgrardi">Fien</a><br> and contributors <a href="https://www.goodbytes.be" title="Freelance web developer Antwerp">GoodBytes</a>, <a href="https://bierebeeck.be/">Robbe</a></p>
        </div>
    </footer>
</div>