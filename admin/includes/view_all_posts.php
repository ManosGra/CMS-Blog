<?php
if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $postValueId) {
        $bulk_options = escape($_POST['bulk_options']);

        switch ($bulk_options) {
            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";

                $update_to_published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_published_status);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId}";

                $update_to_draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId}";
                $update_to_delete_status = mysqli_query($connection, $query);
                confirmQuery($update_to_delete_status);
                break;

            case 'clone':
                $query = "SELECT * FROM posts WHERE post_id = '{$postValueId}'";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_array($select_post_query)) {
                    $post_title = escape($row['post_title']);
                    $post_category_id = escape($row['post_category_id']);
                    $post_date = escape($row['post_date']);
                    $post_author = escape($row['post_author']);
                    $post_user = escape($row['post_user']);
                    $post_status = escape($row['post_status']);
                    $post_image = escape($row['post_image']);
                    $post_tags = escape($row['post_tags']);
                    $post_content = escape($row['post_content']);
                    $post_comment_count = escape($row['post_comment_count']);
                }

                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_status, post_image, post_tags, post_content, post_comment_count)";
                $query .= "VALUES ({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}', '{$post_date}','{$post_status}','{$post_image}','{$post_tags}', '{$post_content}', '{$post_comment_count}')";
                $copy_query = mysqli_query($connection, $query);
                if (!$copy_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                break;


        }
    }
}

?>



<form action="" method="post">
    <table class="table table-bordered table-hover">

        <div id="bulkOptionsContainer" class="col-xs-4" style="margin-bottom:20px; padding:0;">

            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>

        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>ID</th>
                <th>User</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>View Post</th>
                <th>Edit</th>
                <th>Delete</th>
                <th>Views</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $per_page = 15;

            if (isset($_GET['page'])) {
                $page = escape($_GET['page']);
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page - 1) * $per_page;
            }

            $view_post_query_count = "SELECT * FROM posts";
            $find_count = mysqli_query($connection, $view_post_query_count);
            $count = mysqli_num_rows($find_count);

            $count = ceil($count / $per_page);

            $query = "SELECT * FROM posts LIMIT $page_1, $per_page";
            $select_all_posts_query = mysqli_query($connection, $query);

            $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1, $per_page";
            $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id = escape($row['post_id']);
                $post_author = escape($row['post_author']);
                $post_user = escape($row['post_user']);
                $post_title = escape($row['post_title']);
                $post_category_id = escape($row['post_category_id']);
                $post_status = escape($row['post_status']);
                $post_image = escape($row['post_image']);
                $post_tags = escape($row['post_tags']);
                $post_comment_count = escape($row['post_comment_count']);
                $post_date = escape($row['post_date']);
                $post_view_counts = escape($row['post_view_counts']);

                echo "<tr>";
                ?>

                <td><input type="checkbox" class="checkBoxes" name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>

                <?php
                echo "<td>{$post_id}</td>";


                if(!empty($post_author)){
                    echo "<td>{$post_author}</td>";
                } elseif (!empty($post_user)){
                    echo "<td>{$post_user}</td>";
                }
                



                echo "<td>{$post_title}</td>";


                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
                $select_categories_id = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_categories_id)) {
                    $cat_id = escape($row['cat_id']);
                    $cat_title = escape($row['cat_title']);

                    echo "<td>{$cat_title}</td>";
                }

                echo "<td>{$post_status}</td>";
                echo "<td><img style='width:100px' src='../images/{$post_image}' alt='image'></td>";
                echo "<td>{$post_tags}</td>";

                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                $send_comment_query = mysqli_query($connection, $query);
                if (!$send_comment_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                

                $row = mysqli_fetch_array($send_comment_query);

                $count_comments = mysqli_num_rows($send_comment_query);
                if ($count_comments > 1) {
                    $row = mysqli_fetch_array($send_comment_query);
                    $comment_id = escape($row['comment_id']);
                } else {
                    $comment_id = ""; // ή οποιαδήποτε άλλη τιμή που θεωρείτε κατάλληλη
                }

                echo "<td><a href='post_comments.php?id=$post_id'>$count_comments</a></td>";



                echo "<td>{$post_date}</td>";
                echo "<td><a href='../post.php?p_id=$post_id'>View Post</a></td>";
                echo "<td><a href='posts.php?source=edit_post&p_id=$post_id'>Edit</a></td>";
                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete'); \" href='posts.php?delete={$post_id}'>Delete</a></td>";
                echo "<td><a href='posts.php?reset={$post_id}'>{$post_view_counts}</a></td>";
                echo "</tr>";
            }
            ?>

        </tbody>
    </table>
</form>

<ul class="pager">
<?php
    // Loop through pages and generate pagination links
    for ($i = 1; $i <= $count; $i++) {
        // Check if the current page is active
        if ($i == $page || ($page == "" && $i == 1)) {
            echo "<li><a class='active_link' href='posts.php?page={$i}'>{$i}</a></li>";
        } else {
            echo "<li><a href='posts.php?page={$i}'>{$i}</a></li>";
        }
    }
    ?>

</ul>

<?php

if (isset($_GET['delete'])) {

    $the_post_id = escape($_GET['delete']);

    $query = "DELETE FROM posts WHERE post_id = {$the_post_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: posts.php");
    exit();
}

if (isset($_GET['reset'])) {

    $the_post_id = escape($_GET['reset']);

    $query = "UPDATE posts SET post_view_counts = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
    $reset_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}


?>