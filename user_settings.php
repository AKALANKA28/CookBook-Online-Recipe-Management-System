<?php
include 'components/config.php';

if (isset($_POST['submit'])) {
   $id = create_unique_id();
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/' . $rename;
   $name = $_POST['name'];
   $email = $_POST['email'];
   if (!empty($image)) {
      if ($image_size > 2000000) {
         $warning_msg[] = 'Image size is too large!';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $rename = '';
   }

   $insert_user = $conn->prepare("UPDATE users SET name = ?, email = ?,image = ? WHERE id = ?");
   $insert_user->bind_param('ssss', $name, $email,$rename, $user_id);
   $insert_user->execute();
   $success_msg[] = 'Updated successfully!';
   echo '<script>';
   echo 'function refreshPage() {';
   echo '    window.parent.location.reload();';
   echo '}';
   echo 'refreshPage();'; // Call the JavaScript function
   echo '</script>';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <link rel="stylesheet" href="css/style.css">

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

        
</script>
<style>
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>


   <?php include 'components/alers.php'; ?>

</body>

</html>
