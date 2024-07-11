
<?php

include 'components/config.php';

?>

<!DOCTYPE html>
<html>
 <head>
    <meta name = "viewport" content="width = device-width, initial-scale = 1.0">
    <title>Cook Book</title>

    <link rel ="stylesheet" href="style.css">

 </head>
 <body>
    <div class="hero" style ="background-image: url(images/bt4.jpg); " >
    

    <div class="content">
           <form action="" method="get" class="search-bar">
                <input type="text" class="input" placeholder="search any recipe" name="search">
                <button type="submit">
                  <i class="uil uil-search"></i>
                </button>
           </form>
        </div>
    </div>
    <!-- header section starts  -->

    <?php include 'components/header.php'; ?>

    <!-- header section ends -->

    



 <!--------------------------------Recipes section--------------------------->


 <section style ="background-image: url(images/menu-bg.png); " class= "bg_image">
    <section class="section_container recipes_container">
        <div class="section_header">
          <div>
            <h2 class="section_title">Recipes</h2>
            <h2 class="section_subtitle">
              Explore our latest recipes    
          </h2>
          </div>
        </div>
        <div class="recipes_grid">
          <?php
          $select_posts = "SELECT * FROM `recipe`";
          $result_posts = mysqli_query($conn, $select_posts);
          if(mysqli_num_rows($result_posts) > 0){
              while($fetch_post = mysqli_fetch_assoc($result_posts)){

              $post_id = $fetch_post['id'];
          ?>
          <div class="recipes_card">
          <a href="view_recipe.php?get_id=<?= $post_id; ?>"><img src="uploaded_files/<?= $fetch_post['image']; ?>" class="recipe_image" ></a> 
            <div class="recipes_details">
              <h3 class="recipes_title"><?= $fetch_post['title']; ?></h3>
              
              
            </div>
          </div>
          
         
          <?php
         }
      }else{
         echo '<p class="empty">no recipes added yet!</p>';
      }
      ?>
      
        </div>
    </section>
  </section>
<!--------------------------------subscribe section--------------------------->



<section class="subscribe" style="background-image: url(images/blog-pattern-bg.png);">
        <div class="wrap">
          <form action="">
            <p>Get the latest recipe right into your inbox:</p>
            <input type="text" placeholder="Email Address...">
            <button type="submit">Subscribe</button> 
          </form>
       </div> 
</section>



<!--------------------------------Trending section--------------------------->
<section class="section_container recipes_container">
  <div class="section_header">
    <div>
      <h2 class="section_title">Trending</h2>
      <h2 class="section_subtitle">
        Here you can find this week trending.
      </h2>
    </div> 
  </div>

  <div class="trending_grid">
  <?php
    $select_posts = "SELECT recipe.*, AVG(reviews.rating) AS average_rating
                     FROM recipe
                     LEFT JOIN reviews ON recipe.id = reviews.RecipeID
                     GROUP BY recipe.id
                     HAVING average_rating > 4";
                     
    $result_posts = mysqli_query($conn, $select_posts);
    
    if(mysqli_num_rows($result_posts) > 0) {
      while($fetch_post = mysqli_fetch_assoc($result_posts)) {
        $post_id = $fetch_post['id'];

        ?>
        <div class="recipes_card">
          <a href="view_recipe.php?get_id=<?= $post_id; ?>"><img src="uploaded_files/<?= $fetch_post['image']; ?>" class="recipe_image" ></a> 

  <?php     
        }
      } else {
        echo '<p class="empty">No trending recipes this week</p>';
      }
  ?>

  </div>
</section>

<!--------------------------------section5------------------------------------>

<section class="section5">
  <div class="section5_container">
    <div class="section5_col">
      <div class="video-container">
        <video autoplay loop muted plays-inline>
            <source src="assets/Creamy_Garlic Chicken_Breast_Recipe.mp4" type="video/mp4">
        </video>
      </div>
    </div>
      
    <div class="section5_content">
      <div>
        <h2 class="section_title">
        FEATURED VIDEO
        </h2>
        <p>
          Creamy Garlic Chicken
        </h2>
        <h3 class="content">The ultimate comfort food! Topped with the flakiest, mile-high biscuits ever (made ahead of time). So cozy + so darn good!</h3>
      
        <button class="btn"><a href ="http://localhost/ORMS/view_recipe.php?get_id=L5K7O3QAXW">View Recipe</button>
      </div>
    </div>
  </div>
</section>







<!--------------------------------subscribe section--------------------------->



      <section class="subscribe" style="background-image: url(images/blog-pattern-bg.png);">
        <div class="wrap">
          <form action="">
            <p>Get the latest recipe right into your inbox:</p>
            <input type="text" placeholder="Email Address...">
            <button type="submit">Subscribe</button> 
          </form>
       </div> 
      </section>


<!--------------------------------Footer section--------------------------->

<?php include 'components/footer.php'; ?>                                              
<script src="js/script.js"></script>

</body>




<?php include 'components/alerts.php'; ?>
</html>