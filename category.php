<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>

<!-- Navigation -->
<?php include "includes/navigation.php" ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            $post_category_id = isset($_GET['category']) ? $_GET['category'] : 0;

            $query = " SELECT * FROM posts WHERE post_category_id = $post_category_id ";
            $select_all_posts_query = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = escape($row['post_id']);
                $post_title = escape($row['post_title']);
                $post_author = escape($row['post_author']);
                $post_date = escape($row['post_date']);
                $post_image = escape($row['post_image']);
                $post_content = substr( $row['post_content'],0,150);
                ?>

                <h1 class="page-header">
                    Page Heading
                </h1>

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" style="width:900px; height:300px;" src="images/<?php echo $post_image;?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            <?php } ?>
        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>
    </div>

    <hr>

    <?php include "includes/footer.php" ?>