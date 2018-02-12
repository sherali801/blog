<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

$title = '';
$body = '';
$visibility = 1;
$post_category_id = 0;

if (isset($_POST['submit'])) {
    $title = escape_string(trim($_POST['title']));
    $body = escape_string(trim($_POST['body']));
    $visibility = escape_string(trim($_POST['visibility']));
    $post_category_id = escape_string(trim($_POST['post_category_id']));
    if (check_length($title)) {
        if (create_post($title, $body, $visibility, $post_category_id, $_SESSION['user_id'])) {
            $_SESSION['messages'][] = "Post \"{$title}\" has been added.";
            $title = '';
            $body = '';
            $visibility = 1;
            $post_category_id = 0;
        } else {
            $_SESSION['messages'][] = "Post \"{$title}\" was not added.";
        }
    } else {
        $_SESSION['messages'][] = "Post title length must be less than 255.";
    }
}

?>

<?php require_once('../assets/layouts/admin_header.php'); ?>

<div class="container">
    <h2 class="text-center">Add New Post</h2>
    <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' class="form-horizontal">

        <?php require_once('../assets/layouts/messages.php'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Title</label>
            <div class="col-sm-4">
                <input type="text" name="title" value="<?php echo htmlentities($title); ?>" class="form-control" placeholder="Title" maxlength="255" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Visibility</label>
            <div class="col-sm-4">
                <label class="radio-inline"><input type="radio" name="visibility" value="1" <?php echo ($visibility == 1) ? "checked" : ""; ?>> Yes</label>
                <label class="radio-inline"><input type="radio" name="visibility" value="0" <?php echo ($visibility == 0) ? "checked" : ""; ?>> No</label>
            </div>
        </div>
        <?php $result = get_all_post_categories(); ?>
        <div class="form-group">
            <label class="col-sm-4 control-label">Post Category</label>
            <div class="col-sm-4">
                <select class="form-control" name="post_category_id">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <option <?php echo ($row['id'] == $post_category_id) ? 'selected' : '' ?> value="<?php echo $row['id']; ?>"><?php echo htmlentities($row['post_category_name']); ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Body</label>
            <div class="col-sm-4">
                <textarea name="body" class="form-control" rows="5" placeholder="Body" required><?php echo htmlentities($body); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
                <input type="submit" name="submit" value="Add New Post" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
</div>

<?php require_once('../assets/layouts/admin_footer.php'); ?>
