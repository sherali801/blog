<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

$post_category_name = '';
$visibility = 1;

if (isset($_POST['submit'])) {
    $post_category_name = escape_string(trim($_POST['post_category_name']));
    $visibility = escape_string(trim($_POST['visibility']));
    $user_id = $_SESSION['user_id'];
    if (check_length($post_category_name)) {
        if (create_post_category($post_category_name, $visibility, $user_id)) {
            $_SESSION['messages'][] = "Post Category \"{$post_category_name}\" has been added.";
            $post_category_name = '';
            $visibility = 1;
        } else {
            $_SESSION['messages'][] = "Post Category \"{$post_category_name}\" was not added.";
        }
    } else {
        $_SESSION['messages'][] = 'Post Category length must be less than 256.';
    }
}

?>

<?php require_once '../assets/layouts/admin_header.php'; ?>

<div class="container">
    <h2 class="text-center">Add New Post Category</h2>
    <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' class="form-horizontal">

        <?php require_once('../assets/layouts/messages.php'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Post Category Name</label>
            <div class="col-sm-4">
                <input type="text" name="post_category_name" value="<?php echo htmlentities($post_category_name); ?>" class="form-control" placeholder="Post Category" maxlength="255" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Visibility</label>
            <div class="col-sm-4">
                <label class="radio-inline"><input type="radio" name="visibility" value="1" <?php echo ($visibility == 1) ? "checked" : ""; ?>> Yes</label>
                <label class="radio-inline"><input type="radio" name="visibility" value="0" <?php echo ($visibility == 0) ? "checked" : ""; ?>> No</label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
                <input type="submit" name="submit" value="Add New Post Category" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
</div>

<?php require_once '../assets/layouts/admin_footer.php'; ?>
