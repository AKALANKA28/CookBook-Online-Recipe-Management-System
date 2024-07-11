<?php
session_start();

include 'components/config.php';

if (isset($_POST['submit'])) {
   $id = create_unique_id();
   $name = $_POST['name'];
   $email = $_POST['email'];
   $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
   $c_pass = password_verify($_POST['c_pass'], $pass);

   $image = $_FILES['image']['name'];
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/' . $rename;

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $warning_msg[] = 'Image size is too large!';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $rename = '';
   }

   $verify_email_query = "SELECT * FROM `users` WHERE email = '$email'";
   $verify_email_result = mysqli_query($conn, $verify_email_query);

   if (mysqli_num_rows($verify_email_result) > 0) {
      $_SESSION['form_submitted'] = true; // Set the flag in the session
      $warning_msg[] = 'Email already taken!';
   } else {
      if ($c_pass == 1) {
         $insert_user2_query = "INSERT INTO `users` ( id,name, email, password, image) VALUES ('$id','$name', '$email', '$pass', '$rename')";
         $insert_user2_result = mysqli_query($conn, $insert_user2_query);
         if ($insert_user2_result) {
            $success_msg[] = 'Registered successfully!';
            // Redirect to login.php
            header("Location: user2_login.php");
            exit();
         } else {
            $warning_msg[] = 'Error occurred while registering!'. mysqli_error($conn);
         }
      } else {
         $warning_msg[] = 'Confirm password not matched!';
      }
   }
}

// Check if the flag is set in the session
if (isset($_SESSION['form_submitted'])) {
   // Check if the error message is already present
   if (!in_array('Email already taken!', $warning_msg)) {
      // Display the error message
      $warning_msg[] = 'Email already taken!';
   }
   // Remove the flag from the session
   unset($_SESSION['form_submitted']);
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>


<section class="form">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>make your account!</h3>
      <p class="placeholder">your name <span>*</span></p>
      <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
      <p class="placeholder">your email <span>*</span></p>
      <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
      <p class="placeholder">your password <span>*</span></p>
      <input type="password" name="pass" required maxlength="50" placeholder="enter your password" class="box">
      <p class="placeholder">confirm password <span>*</span></p>
      <input type="password" name="c_pass" required maxlength="50" placeholder="confirm your password" class="box">
      <p class="placeholder">profile pic</p>
      <input type="file" name="image" class="box" accept="image/*">
      <p class="link">already have an account? <a href="login.php">login now</a></p>
      <input type="submit" value="register now" name="submit" class="btn">

   </form>
</section>

<!-- sweetalert cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alerts.php'; ?>

</body>
</html>
