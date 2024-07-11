<?php
include 'components/config.php';

if (isset($_POST['submit'])) {
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
   $select_user->bind_param("i", $user_id);
   $select_user->execute();
   $fetch_user_result = $select_user->get_result();
   $fetch_user = $fetch_user_result->fetch_assoc();

   $name = $_POST['name'];
   $email = $_POST['email'];

   if (!empty($name)) {
      $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
      $update_name->bind_param("si", $name, $user_id);
      $update_name->execute();
      $success_msg[] = 'Username updated!';
   }

   if (!empty($email)) {
      $verify_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND id != ?");
      $verify_email->bind_param("si", $email, $user_id);
      $verify_email->execute();
      $verify_email_result = $verify_email->get_result();
      if ($verify_email_result->num_rows > 0) {
         $warning_msg[] = 'Email already taken!';
      } else {
         $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
         $update_email->bind_param("si", $email, $user_id);
         $update_email->execute();
         $success_msg[] = 'Email updated!';
      }
   }

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
         $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
         $update_image->bind_param("si", $rename, $user_id);
         $update_image->execute();
         move_uploaded_file($image_tmp_name, $image_folder);
         if ($fetch_user['image'] != '') {
            unlink('uploaded_files/' . $fetch_user['image']);
         }
         $success_msg[] = 'Image updated!';
      }
   }

   $prev_pass = $fetch_user['password'];

   $old_pass = password_hash($_POST['old_pass'], PASSWORD_DEFAULT);

   $empty_old = password_verify('', $old_pass);

   $new_pass = password_hash($_POST['new_pass'], PASSWORD_DEFAULT);

   $empty_new = password_verify('', $new_pass);

   $c_pass = password_verify($_POST['c_pass'], $new_pass);

   if ($empty_old != 1) {
      $verify_old_pass = password_verify($_POST['old_pass'], $prev_pass);
      if ($verify_old_pass == 1) {
         if ($c_pass == 1) {
            if ($empty_new != 1) {
               $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
               $update_pass->bind_param("si", $new_pass, $user_id);
               $update_pass->execute();
               $success_msg[] = 'Password updated!';
            } else {
               $warning_msg[] = 'Please enter a new password!';
            }
         } else {
            $warning_msg[] = 'Confirm password not matched!';
         }
      } else {
         $warning_msg[] = 'Old password not matched!';
      }
   }
}

if (isset($_POST['delete_image'])) {
   $select_old_pic = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
   $select_old_pic->bind_param("i", $user_id);
   $select_old_pic->execute();
   $fetch_old_pic_result = $select_old_pic->get_result();
   $fetch_old_pic = $fetch_old_pic_result->fetch_assoc();

   $update_old_pic = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
   $update_old_pic->bind_param("si", '', $user_id);
   $update_old_pic->execute();
   if ($fetch_old_pic['image'] != '') {
      unlink('uploaded_files/' . $fetch_old_pic['image']);
   }

   // After successful update redirects back to profile
   header('Location: Profile.php?success=1');
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update profile</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="style.css">

</head>

<body>

   

   <!-- update section starts  -->

   <section class="account-form">

      <form action="" method="post" enctype="multipart/form-data">
         <h3>update your profile!</h3>
         <p class="placeholder">your name</p>
         <input type="text" name="name" maxlength="50" placeholder="<?= $fetch_profile['name']; ?>" class="box">
         <p class="placeholder">your email</p>
         <input type="email" name="email" maxlength="50" placeholder="<?= $fetch_profile['email']; ?>" class="box">
         <p class="placeholder">old password</p>
         <input type="password" name="old_pass" maxlength="50" placeholder="enter your old password" class="box">
         <p class="placeholder">new password</p>
         <input type="password" name="new_pass" maxlength="50" placeholder="enter your new password" class="box">
         <p class="placeholder">confirm password</p>
         <input type="password" name="c_pass" maxlength="50" placeholder="confirm your new password" class="box">
         <p class="placeholder">profile pic</p>
         <input type="file" name="image" class="box" accept="image/*">
         <input type="submit" value="update now" name="submit" class="btn">
      </form>

   </section>

   <!-- update section ends -->

   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <?php include 'components/alerts.php'; ?>

</body>

</html>
