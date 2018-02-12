<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

?>

<?php require_once('../assets/layouts/admin_header.php'); ?>

<div class="container text-center">
    <h2>Menu</h2>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h3>Admin</h3>
            <div class="btn-group btn-group-md btn-group-vertical" role="group" aria-label="...">
                <a href="add_new_admin.php" class="btn btn-info" role="button">Add New Admin</a>
                <a href="manage_admins.php" class="btn btn-info" role="button">Manage Admins</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Post</h3>
            <div class="btn-group btn-group-lg btn-group-vertical" role="group" aria-label="...">
                <a href="add_new_post_category.php" class="btn btn-info" role="button">Add New Post Category</a>
                <a href="manage_post_categories.php" class="btn btn-info" role="button">Manage Post Categories</a>
                <a href="add_new_post.php" class="btn btn-info" role="button">Add New Post</a>
                <a href="manage_posts.php" class="btn btn-info" role="button">Manage Posts</a>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Video</h3>
            <div class="btn-group btn-group-lg btn-group-vertical" role="group" aria-label="...">
                <a href="add_new_video_category.php" class="btn btn-info" role="button">Add New Video Category</a>
                <a href="manage_video_categories.php" class="btn btn-info" role="button">Mansage Video Categories</a>
                <a href="add_new_video.php" class="btn btn-info" role="button">Add New Video</a>
                <a href="manage_videos.php" class="btn btn-info" role="button">Manage Videos</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('../assets/layouts/admin_footer.php'); ?>
