<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['add_post'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;

   $select_post_name = mysqli_query($conn, "SELECT name FROM `posts` WHERE name = '$name'") or die('query failed');

   if(mysqli_num_rows($select_post_name) > 0){
      $message[] = 'event name already exist!';
   }else{
      $insert_post = mysqli_query($conn, "INSERT INTO `posts`(name, details, price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');

      if($insert_post){
         if($image_size > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name, $image_folter);
            $message[] = 'event added successfully!';
         }
      }
   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `posts` WHERE id = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `posts` WHERE id = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `save` WHERE pid = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `register` WHERE pid = '$delete_id'") or die('query failed');
   header('location:admin_posts.php');

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>events</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="add-posts">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new event</h3>
      <input type="text" class="box" required placeholder="enter event name" name="name">
      <input type="number" min="0" class="box" required placeholder="enter event price" name="price">
      <textarea name="details" class="box" required placeholder="enter event details" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add event" name="add_post" class="btn">
   </form>

</section>

<section class="show-posts">

   <div class="box-container">

      <?php
         $select_posts = mysqli_query($conn, "SELECT * FROM `posts`") or die('query failed');
         if(mysqli_num_rows($select_posts) > 0){
            while($fetch_posts = mysqli_fetch_assoc($select_posts)){
      ?>
      <div class="box">
         <div class="price">RM<?php echo $fetch_posts['price']; ?></div>
         <img class="image" src="uploaded_img/<?php echo $fetch_posts['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_posts['name']; ?></div>
         <div class="details"><?php echo $fetch_posts['details']; ?></div>
         <a href="admin_update_post.php?update=<?php echo $fetch_posts['id']; ?>" class="option-btn">update</a>
         <a href="admin_posts.php?delete=<?php echo $fetch_posts['id']; ?>" class="delete-btn" onclick="return confirm('delete this event?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no events added yet!</p>';
      }
      ?>
   </div>
   

</section>












<script src="js/admin_script.js"></script>

</body>
</html>