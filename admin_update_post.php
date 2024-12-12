<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_POST['update_post'])){
	
    $update_p_id = $_POST['update_p_id'];
	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$price = mysqli_real_escape_string($conn, $_POST['price']);
	$details = mysqli_real_escape_string($conn, $_POST['details']);	
	
	mysqli_query($conn, "UPDATE `posts` SET name = '$name', details ='$details', price = '$price' WHERE id = '$update_p_id'") or die('query failed');

   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folter = 'uploaded_img/'.$image;
   $old_image = $_POST['update_p_image'];
	
   if(!empty($image)){
	   if($image_size > 2000000){
		   $message[] = 'image file size is too large!';
	   }else{
		   mysqli_query($conn, "UPDATE `posts` SET image ='$image' WHERE id = '$update_p_id'") or die('query failed');
		   move_uploaded_file($image_tmp_name, $image_folter);
		   unlink('uploaded_img/'.$old_image);
		   $message[] = 'image updated successfully!';
	   }
   }
   
   $message[] = 'post updated successfully!';
   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update post</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>

<?php @include 'admin_header.php'; ?>

<section class="update-post">

<?php

   $update_id = $_GET['update'];
   $select_posts = mysqli_query($conn, "SELECT * FROM `posts` WHERE id = '$update_id'") or die('query failed');
   if(mysqli_num_rows($select_posts) > 0){
      while($fetch_posts = mysqli_fetch_assoc($select_posts)){
?>

<form action="" method="post" enctype="multipart/form-data">
	<img src="uploaded_img/<?php echo $fetch_posts['image']; ?>" class="image"  alt="">
	<input type="hidden" value="<?php echo $fetch_posts['id']; ?>" name="update_p_id">
	<input type="hidden" value="<?php echo $fetch_posts['image']; ?>" name="update_p_image">	
	<input type="text" class="box" value="<?php echo $fetch_posts['name']; ?>" required placeholder="update event name" name="name">
    <input type="number" min="0" class="box" value="<?php echo $fetch_posts['price']; ?>" required placeholder="update registration price" name="price">
    <textarea name="details" class="box" required placeholder="update event details" cols="30" rows="10"><?php echo $fetch_posts['details']; ?></textarea>
    <input type="file" accept="image/jpg, image/jpeg, image/png" class="box" name="image">
    <input type="submit" value="update post" name="update_post" class="btn">
	<a href="admin_posts.php" class="option-btn">go back</a>
</form>

<?php
			}
		}else{
			echo '<p class="empty">no update post select</p>';
		}
?>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>