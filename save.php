<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

if(isset($_POST['add_to_register'])){

    $post_id = $_POST['post_id'];
    $post_name = $_POST['post_name'];
    $post_price = $_POST['post_price'];
    $post_image = $_POST['post_image'];
    $post_quantity = 1;

    $check_register_numbers = mysqli_query($conn, "SELECT * FROM `register` WHERE name = '$post_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_register_numbers) > 0){
        $message[] = 'already added to register';
    }else{

        $check_save_numbers = mysqli_query($conn, "SELECT * FROM `save` WHERE name = '$post_name' AND user_id = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_save_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `save` WHERE name = '$post_name' AND user_id = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `register`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$post_id', '$post_name', '$post_price', '$post_quantity', '$post_image')") or die('query failed');
        $message[] = 'event added to register';
    }

}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `save` WHERE id = '$delete_id'") or die('query failed');
    header('location:save.php');
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `save` WHERE user_id = '$user_id'") or die('query failed');
    header('location:save.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>save</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="heading">
    <h3>your save</h3>
    <p> <a href="index.php">home</a> / save
</section>

<section class="save">

    <h1 class="title">events added</h1>

    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_save = mysqli_query($conn, "SELECT * FROM `save` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_save) > 0){
            while($fetch_save = mysqli_fetch_assoc($select_save)){
    ?>
    <form action="" method="POST" class="box">
        <a href="save.php?delete=<?php echo $fetch_save['id']; ?>" class="fas fa-times" onclick="return confirm('delete this from save?');"></a>
        <a href="view_page.php?pid=<?php echo $fetch_save['pid']; ?>" class="fas fa-eye"></a>
        <img src="uploaded_img/<?php echo $fetch_save['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_save['name']; ?></div>
        <div class="price">RM<?php echo $fetch_save['price']; ?></div>
        <input type="hidden" name="post_id" value="<?php echo $fetch_save['pid']; ?>">
        <input type="hidden" name="post_name" value="<?php echo $fetch_save['name']; ?>">
        <input type="hidden" name="post_price" value="<?php echo $fetch_save['price']; ?>">
        <input type="hidden" name="post_image" value="<?php echo $fetch_save['image']; ?>">
        <input type="submit" value="add to register" name="add_to_register" class="btn">
        
    </form>
    <?php
    $grand_total += $fetch_save['price'];
        }
    }else{
        echo '<p class="empty">your save is empty</p>';
    }
    ?>
    </div>

    <div class="save-total">
        <p>grand total : <span>RM<?php echo $grand_total; ?></span></p>
        <a href="event.php" class="option-btn">continue browsing</a>
		<a href="save.php?delete_all" 
		   class="delete-btn <?php echo ($is_all_free) ? 'disabled' : ''; ?>" 
           onclick="return <?php echo ($is_all_free) ? 'false' : 'confirm(\'Delete all from save?\');'; ?>">
		   Delete All
		</a>		

    </div>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>