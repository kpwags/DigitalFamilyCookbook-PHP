<footer>
    <div class="container">
        <ul>
            <?php if ($Security->IsUserLoggedIn()) { ?>
                <li><a href="admin">Admin</a></li>
                <li><a href="php/action.logout.php">Logout</a></li>
            <?php } else { ?>
                <li><a href="login">Login</a></li>
            <?php } ?>
            <li><a href="about">About</a></li>
            <li class="copyright">&copy; 2014 Keith Wagner (<a href="http://www.kpwags.com" target="_blank">kpwags.com</a>)</li>
        </ul>
    </div>
</footer>