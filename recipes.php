<?php

include 'components/config.php';

?>

<!DOCTYPE html>
<html>
 <head>
    <meta name = "viewport" content="width = device-width, initial-scale = 1.0">
    <title>recipes</title>

   
    <link rel ="stylesheet" href="style.css">

 </head>
 <body>
    
  <!-- header section starts  -->

   <?php include 'components/header.php'; ?>

  <!-- header section ends -->




 <!--------------------------------Recipes section--------------------------->


 <section style="background-image: url(images/menu-bg.png);" class="bg_image">
   <div class="filter_menu">
      <div class="icon"><i id="left" class="fa-solid fa-angle-left"></i></div>

      <ul class="filters">
         <div class="filter-active" style="width: 75px; transform: translate(30px, 0px);"></div>
         <li class="filter active" data-filter=".all">All</li>
         <li class="filter" data-filter=".American">American</li>
         <li class="filter" data-filter=".Indian">Indian</li>
         <li class="filter" data-filter=".French">French</li>
         <li class="filter" data-filter=".Chinese">Chinese</li>
         <li class="filter" data-filter=".Japanese">Japanese</li>
         <li class="filter" data-filter=".Italian">Italian</li>
         <li class="filter" data-filter=".Spanish">Spanish</li>
         <li class="filter" data-filter=".Greek">Greek</li>
         <li class="filter" data-filter=".Turkish">Turkish</li>
         <li class="filter" data-filter=".Thai">Thai</li>
         <li class="filter" data-filter=".Mexican">Mexican</li>
         <li class="filter" data-filter=".Caribbean">Caribbean</li>
         <li class="filter" data-filter=".Russian">Russian</li>
         <li class="filter" data-filter=".German">German</li>
         <li class="filter" data-filter=".Hungarian">Hungarian</li>
      </ul>

      <div class="icon"><i id="right" class="fa-solid fa-angle-right"></i></div>
   </div>

   <section class="section_container recipes_container">
      <div class="section_header">

      </div>
      <div class="recipes_grid">
         <?php
         $select_posts = "SELECT * FROM `recipe`";
         $result_posts = mysqli_query($conn, $select_posts);
         if (mysqli_num_rows($result_posts) > 0) {
            while ($fetch_post = mysqli_fetch_assoc($result_posts)) {
               $post_id = $fetch_post['id'];
               $count_reviews = "SELECT * FROM `reviews` WHERE RecipeID = '$post_id'";
               $result_reviews = mysqli_query($conn, $count_reviews);
               $total_reviews = mysqli_num_rows($result_reviews);
         ?>
               <div class="recipes_card filter-item <?= $fetch_post['cuisine']; ?>">
                  <a href="view_recipe.php?get_id=<?= $post_id; ?>" class="inline-btn"><img src="uploaded_files/<?= $fetch_post['image']; ?>" class="recipe_image"></a>
                  <div class="recipes_details">
                     <h3 class="recipes_title"><?= $fetch_post['title']; ?></h3>
                  </div>
               </div>
         <?php
            }
         } else {
            echo '<p class="empty">no recipes added yet!</p>';
         }
         ?>
      </div>
   </section>
</section>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    var filtersContainer = document.querySelector(".filters");
    var containerWidth = filtersContainer.parentElement.offsetWidth;
    var scrollStep = 300; // Scroll one container width at a time
    var scrollDuration = 400; // Duration of scroll animation (in milliseconds)
    var scrollTimeout;

    function scrollContainer(scrollAmount) {
      filtersContainer.scrollTo({
        left: scrollAmount,
        behavior: "smooth"
      });
    }

    function scrollToLeft() {
      var scrollAmount = Math.max(filtersContainer.scrollLeft - scrollStep, 0);
      scrollContainer(scrollAmount);
      scrollTimeout = setTimeout(scrollToLeft, scrollDuration);
    }

    function scrollToRight() {
      var scrollAmount = Math.min(filtersContainer.scrollLeft + scrollStep, filtersContainer.scrollWidth - containerWidth);
      scrollContainer(scrollAmount);
      scrollTimeout = setTimeout(scrollToRight, scrollDuration);
    }

    document.getElementById("left").addEventListener("mousedown", function() {
      clearTimeout(scrollTimeout);
      scrollToLeft();
    });

    document.getElementById("right").addEventListener("mousedown", function() {
      clearTimeout(scrollTimeout);
      scrollToRight();
    });

    document.addEventListener("mouseup", function() {
      clearTimeout(scrollTimeout);
    });
  });

  document.addEventListener("DOMContentLoaded", function() {
    var filterOptions = document.querySelectorAll(".filter");
    var filterActive = document.querySelector(".filter-active");
    var recipesCards = document.querySelectorAll(".recipes_card");

    var activeFilter = null;

    filterOptions.forEach(function(option) {
      option.addEventListener("click", function() {
        if (activeFilter !== this) {
          activeFilter = this;

          var filterValue = this.getAttribute("data-filter");

          filterOptions.forEach(function(option) {
            option.classList.remove("active");
          });

          this.classList.add("active");

          filterActive.style.transform = `translate(${this.offsetLeft}px, 0px)`;
          filterActive.style.width = `${this.offsetWidth}px`;

          recipesCards.forEach(function(card) {
            card.style.display = "none";

            if (filterValue === ".all" || card.classList.contains(filterValue.slice(1))) {
              card.style.display = "block";
            }
          });
        }
      });
    });
  });
</script>


<?php include 'components/footer.php'; ?>



<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/alerts.php'; ?>
</html>