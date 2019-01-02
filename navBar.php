<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top justify-content-center">
    <a class="navbar-brand" href="index.php"><img src="assets/logo.png" width="30" height="30" alt=""></a>
    <ul class="navbar-nav">
        <li class="nav-item">
            <?php if ($_SESSION['is_admin_logged_in']) : ?>
                    <a <?php if ($_SERVER['REQUEST_URI']== "/add_a_word.php"){echo "class='nav-link active'";}else{echo "class='nav-link'";}?> href="add_a_word.php">Add a word</a>\
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <a <?php if ($_SERVER['REQUEST_URI']== "/manage_words.php"){echo "class='nav-link active'";}else{echo "class='nav-link'";}?> href="manage_words.php">Words</a>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['is_admin_logged_in']): ?>
                    <a <?php if ($_SERVER['REQUEST_URI']== "/add_an_user.php"){echo "class='nav-link active'";}else{echo "class='nav-link'";}?> href="add_an_user.php">Add an user</a>
            <?php else : ?>
                    <a <?php if ($_SERVER['REQUEST_URI']== "/learn_a_word.php"){echo "class='nav-link active'";}else{echo "class='nav-link'";}?> href="learn_a_word.php">Learn a word</a>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['is_admin_logged_in']) : ?>
                    <a <?php if ($_SERVER['REQUEST_URI']== "/manage_users.php"){echo "class='nav-link active'";}else{echo "class='nav-link'";}?> href="manage_users.php">Manage users</a>
            <?php endif; ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="logout.php">Sign out</a>
        </li>
    </ul>
</nav>


