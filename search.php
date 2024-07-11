
<?php

include 'components/config.php';

?>

<?php
// search.php

// Check if the search query is provided
if (isset($_GET['search'])) {
    // Retrieve the search query from the GET parameters
    $searchQuery = $_GET['search'];

    // Perform the search query on the database
    // Modify the query according to your database schema
    $select_posts = "SELECT * FROM `recipe` WHERE title LIKE '%$searchQuery%'";
    $result_posts = mysqli_query($conn, $select_posts);

    // Check if there are any matching recipes
    if (mysqli_num_rows($result_posts) > 0) {
        // Output the matching recipes
        while ($fetch_post = mysqli_fetch_assoc($result_posts)) {
            $post_id = $fetch_post['id'];
            // Output the recipe information
            // Modify the HTML as per your requirements
            echo '<div class="recipes_card">';
            echo '<a href="view_recipe.php?get_id=' . $post_id . '"><img src="uploaded_files/' . $fetch_post['image'] . '" class="recipe_image"></a>';
            echo '<div class="recipes_details">';
            echo '<h3 class="recipes_title">' . $fetch_post['title'] . '</h3>';
            // Add any other recipe details you want to display
            echo '</div>';
            echo '</div>';
        }
    } else {
        // No matching recipes found
        echo '<p class="empty">No recipes found!</p>';
    }
} else {
    // No search query provided
    echo '<p class="empty">Please enter a search query!</p>';
}
?>


<!--------------------------------Footer section--------------------------->

<?php include 'components/footer.php'; ?>                                               
<script src="js/script.js"></script>

</body>




<?php include 'components/alerts.php'; ?>
</html>