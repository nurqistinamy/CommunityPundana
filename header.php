<?php
@include 'config.php'; // Include database configuration file
session_start(); // Start session to access session variables

// Initialize user_id from session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = null; // Set to null if not logged in
}
?>

<?php
// Display messages if any exist
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<header class="header">

    <div class="flex">

        <a href="index.php" class="logo">CommUnity Pundana</a>

        <nav class="navbar">
            <ul>
                <li><a href="index.php">home</a></li>
                <li><a href="#">pages +</a>
                    <ul>
                        <li><a href="about.php">about</a></li>
                        <li><a href="contact.php">contact</a></li>
                    </ul>
                </li>
                <li><a href="event.php">event</a></li>
                <li><a href="registered.php">registered</a></li>
                <li><a href="#">account +</a>
                    <ul>
                        <li><a href="login.php">login</a></li>
                        <li><a href="register.php">register</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
            // Count saved items if user is logged in
            if ($user_id) {
                $select_save_count = mysqli_query($conn, "SELECT * FROM `save` WHERE user_id = '$user_id'") or die('Query failed: ' . mysqli_error($conn));
                $save_num_rows = mysqli_num_rows($select_save_count);

                // Count registered events if user is logged in
                $select_register_count = mysqli_query($conn, "SELECT * FROM `register` WHERE user_id = '$user_id'") or die('Query failed: ' . mysqli_error($conn));
                $register_num_rows = mysqli_num_rows($select_register_count);
            } else {
                $save_num_rows = 0;
                $register_num_rows = 0;
            }
            ?>
            <a href="save.php"><i class="fas fa-save"></i><span>(<?php echo $save_num_rows; ?>)</span></a>
            <a href="registration.php"><i class="fas fa-pen"></i><span>(<?php echo $register_num_rows; ?>)</span></a>
        </div>

        <div class="account-box">
            <?php if (isset($_SESSION['user_name'], $_SESSION['user_email'])): ?>
                <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">logout</a>
            <?php else: ?>
                <p>You are not logged in.</p>
            <?php endif; ?>
        </div>

    </div>

</header>
