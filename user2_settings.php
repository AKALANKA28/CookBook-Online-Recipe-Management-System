<?php
include 'components/config.php';

if (isset($_POST['submit'])) {
   // Generate a unique ID
   $id = create_unique_id();

   // Retrieve the image details
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/' . $rename;

   // Retrieve name and email from form inputs
   $name = $_POST['name'];
   $email = $_POST['email'];

   if (!empty($image)) {

      // Check if the image size is within the limit
      if ($image_size > 2000000) {
         $warning_msg[] = 'Image size is too large!';
      } else {

         // Move the uploaded image to the designated folder
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $rename = '';
   }

  // Prepare and execute the SQL query to update user information
$update_user = $conn->prepare("UPDATE users SET name = ?, email = ?, image = ? WHERE id = ?");
if (!$update_user) {
   $error_msg[] = 'Error in preparing the SQL query: ' . mysqli_error($conn);
} else {
   $update_user->bind_param('ssss', $name, $email, $rename, $user_id);
   $execute_result = $update_user->execute();
   if (!$execute_result) {
      $error_msg[] = 'Error in executing the SQL query: ' . mysqli_error($conn);
   } else {
      // Display success message
      $success_msg[] = 'Updated successfully!';
   }
   $update_user->close();
}

}

if (isset($_POST['delete'])) {
   // Prepare and execute the SQL query to delete the user account
   $delete_user = $conn->prepare("DELETE FROM user WHERE id = ?");
   $delete_user->bind_param('s', $user_id);
   $delete_user->execute();

   // Close the database connection
   $delete_user->close();

   // Redirect to register.php
   header("Location: user2_register.php");
   exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link rel="stylesheet" href="style.css">

</head>

<body>

   <section class="account-form recipe-form">
      <div class="row">
      <?php
   $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
   $stmt->bind_param('s', $user_id);
   $stmt->execute();
   $result = $stmt->get_result();
   if($result->num_rows > 0){
      while($fetch_user = $result->fetch_assoc()){
    
   ?>
            <form action="" method="post" enctype="multipart/form-data">
               <h3>Your Account</h3>
              
            <h3>
               <label for="profile_pic">
                  <img src="uploaded_files/<?= $fetch_user['image']; ?>" alt="Preview" id="imagePreview" class="profile-pic">
               </label>
               <input  id="profile_pic" type="file" name="image" class="box" accept="image/*" onchange="previewImage(event)" style="display:none">

            </h3>
               <p class="placeholder">Name<span>*</span></p><br>
               <input type="text" name="name" value="<?= $fetch_user['name']; ?>" required maxlength="50" placeholder="enter your name" class="box">
               
               <p class="placeholder">Email<span>*</span></p><br>
               <input type="email" name="email" value="<?= $fetch_user['email']; ?>" required maxlength="50" placeholder="enter your email" class="box">

              <input type="submit" value="Save" name="submit" class="btn">
               <input type="reset" value="Cancel" name="cancel" class="btn">
               <input type="submit" value="Delete Account" name="delete" class="btn">
               <input type="submit" value="Back to Home" name="submit" class="btn" onclick="redirectToIndex()">

            </form>
            <?php
         }
      }else{
         echo '<p class="empty">something went wrong!</p>';
      }
      $stmt->close();
   ?>
      </div>
      
   </section>

   <script src="js/script.js"></script>


   <script>
   
   function previewImage(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

   function redirectToIndex() {
      // Redirect to index.php
      window.location.href = "index.php";
   }     
</script>
<style>
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>


   <?php include 'components/alerts.php'; ?>

</body>

</html>