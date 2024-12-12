<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['add_to_save'])){

    $post_id = $_POST['post_id'];
    $post_name = $_POST['post_name'];
    $post_price = $_POST['post_price'];
    $post_image = $_POST['post_image'];
    
    $check_save_numbers = mysqli_query($conn, "SELECT * FROM `save` WHERE name = '$post_name' AND user_id = '$user_id'") or die('query failed');

    $check_register_numbers = mysqli_query($conn, "SELECT * FROM `register` WHERE name = '$post_name' AND user_id = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_save_numbers) > 0){
        $message[] = 'already added to save';
    }elseif(mysqli_num_rows($check_register_numbers) > 0){
        $message[] = 'already added to register';
    }else{
        mysqli_query($conn, "INSERT INTO `save`(user_id, pid, name, price, image) VALUES('$user_id', '$post_id', '$post_name', '$post_price', '$post_image')") or die('query failed');
        $message[] = 'event added to save';
    }

}

if(isset($_POST['add_to_register'])){

    $post_id = $_POST['post_id'];
    $post_name = $_POST['post_name'];
    $post_price = $_POST['post_price'];
    $post_image = $_POST['post_image'];
    $post_quantity = $_POST['post_quantity'];

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<section class="quick-view">

    <h1 class="title">event details</h1>

    <?php  
        if(isset($_GET['pid'])){
            $pid = $_GET['pid'];
            $select_posts = mysqli_query($conn, "SELECT * FROM `posts` WHERE id = '$pid'") or die('query failed');
         if(mysqli_num_rows($select_posts) > 0){
            while($fetch_posts = mysqli_fetch_assoc($select_posts)){
    ?>
    <form action="" method="POST">
         <img src="uploaded_img/<?php echo $fetch_posts['image']; ?>" alt="" class="image">
         <div class="name"><?php echo $fetch_posts['name']; ?></div>
         <div class="price">RM<?php echo $fetch_posts['price']; ?></div>
         <div class="details"><?php echo $fetch_posts['details']; ?></div>
         <input type="number" name="post_quantity" value="1" min="0" class="qty">
         <input type="hidden" name="post_id" value="<?php echo $fetch_posts['id']; ?>">
         <input type="hidden" name="post_name" value="<?php echo $fetch_posts['name']; ?>">
         <input type="hidden" name="post_price" value="<?php echo $fetch_posts['price']; ?>">
         <input type="hidden" name="post_image" value="<?php echo $fetch_posts['image']; ?>">
         <input type="submit" value="add to save" name="add_to_save" class="option-btn">
         <input type="submit" value="add to register" name="add_to_register" class="btn">
      </form>
    <?php
            }
        }else{
        echo '<p class="empty">no events details available!</p>';
        }
    }
    ?>

    <div class="more-btn">
        <a href="index.php" class="option-btn">go to home page</a>
    </div>

</section>






<?php @include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>