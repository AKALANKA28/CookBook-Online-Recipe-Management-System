<?php
include 'components/config.php';

if (isset($_GET['get_id'])) {
   $get_id = $_GET['get_id'];
} else {
   $get_id = '';
   header('location:index.php');
}

if (isset($_POST['submit'])) {
   $image = $_FILES['image']['name'];
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = create_unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/' . $rename;

   $title = $_POST['title'];
   $cuisine = $_POST['cuisine'];
   $ingredients = $_POST['ingredients'];
   $ingredients = implode("$ ", $ingredients); // Convert ingredients array to comma-separated string
   $directions = $_POST['directions'];
   $directions = implode("$ ", $directions); // Convert directions array to comma-separated string
   $ptime = $_POST['ptime'];


   if (!empty($image)) {
      if ($image_size > 2000000) {
         $warning_msg[] = 'Image size is too large!';
      } else {
         move_uploaded_file($image_tmp_name, $image_folder);
      }
   } else {
      $rename = '';
   }


   $stmt = $conn->prepare("UPDATE `recipe` SET title = ?, image = ?, cuisine = ?, ingredients = ?, directions = ?, preparation_time = ?  WHERE id = ? AND UserID = ?");
   $stmt->bind_param("ssssssii", $title, $rename, $cuisine, $ingredients, $directions, $ptime, $get_id, $user_id);
   $stmt->execute();
   $stmt->close();

   $success_msg[] = 'Recipe updated!';
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

   <!-- header section starts  -->
   <?php// include 'components/header.php'; ?>
   <!-- header section ends -->

   <section class="account-form recipe-form">

      <?php
      $sql = "SELECT * FROM `recipe` WHERE id = ? AND UserID = ? LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("ii", $get_id, $user_id);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         while ($fetch_review = $result->fetch_assoc()) {
      ?>

            <div class="row">

               <form action="" method="post" enctype="multipart/form-data">
                  <h3>Add New Recipe</h3>
                  <p class="placeholder">Upload Recipe Image<span>*</span></p><br>
                  <input type="file" name="image" class="box" accept="image/*">

                  <p class="placeholder">Name of Recipe<span>*</span></p><br>
                  <input type="text" name="title" required maxlength="50" placeholder="enter your name" class="box">
                  <p class="placeholder">Select Cuisine Type<span>*</span></p><br>
                  <select class="box" name="cuisine">
                     <option>American</option>
                     <option>Indian</option>
                     <option>French</option>
                     <option>Chinese</option>
                     <option>Japanese</option>
                     <option>Italian</option>
                     <option>Spanish</option>
                     <option>Greek</option>
                     <option>Turkish</option>
                     <option>Thai</option>
                     <option>Mexican</option>
                     <option>Caribbean</option>
                     <option>German</option>
                     <option>Russian</option>
                     <option>Hungarian</option>
                  </select>

                  <p class="placeholder">Ingredients<span>*</span></p><br>
                  <div id="ingredient-container">
                     <input type="text" name="ingredients[]" required maxlength="50" placeholder="ingredient 1" class="box">
                  </div>
                  <button class="f-btn" type="button" id="post-add-ingredients" onclick="addIngredientInput()">
                     <i class="fas fa-plus"></i>
                     Add Ingredient
                  </button> <br><br>

                  <p class="placeholder">Directions<span>*</span></p><br>
                  <div id="directions-container">
                     <textarea name="directions[]" placeholder="Step 1" class="box"></textarea>
                  </div>
                  <button class="f-btn" type="button" onclick="addDirectionsInput()">
                     <i class="fas fa-plus"></i>
                     Add Direction
                  </button><br><br>

                  <p class="placeholder">Preparation Time<span>*</span></p><br>
                  <input type="text" name="ptime" required placeholder="20 Minutes, 15 minutes, etc." class="box">
                  <input type="submit" value="Save" name="submit" class="btn">
                  <input type="reset" value="Cancel" name="cancel" class="btn">
               </form>
            </div>
      <?php
         }
      } else {
         echo '<p class="empty">something went wrong!</p>';
      }
      $stmt->close();
      ?>

   </section>

   <!-- sweetalert cdn link  -->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>


   <script>
      function addIngredientInput() {
         var container = document.getElementById("ingredient-container");
         var input = document.createElement("input");
         input.type = "text";
         input.name = "ingredients[]";
         input.required = true;
         input.placeholder = "ingredient " + (container.childElementCount + 1);
         input.classList.add("box");
         container.appendChild(input);
      }

      function addDirectionsInput() {
         var container = document.getElementById("directions-container");
         var textarea = document.createElement("textarea");
         textarea.name = "directions[]";
         textarea.placeholder = "Step " + (container.childElementCount + 1);
         textarea.classList.add("box");
         container.appendChild(textarea);
      }
   </script>

   <?php include 'components/alerts.php'; ?>

</body>

</html>
