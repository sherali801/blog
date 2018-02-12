<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

$video_id = empty($_GET['video_id']) ? 0 : escape_string($_GET['video_id']);

if (isset($_POST['submit'])) {
    $title = escape_string(trim($_POST['title']));
    $url = escape_string(trim($_POST['url']));
    $visibility = escape_string(trim($_POST['visibility']));
    $video_category_id = escape_string(trim($_POST['video_category_id']));
    if (check_length($title, 1, 512)) {
        if (update_video($video_id, $title, $url, $visibility, $video_category_id, $_SESSION['user_id'])) {
            $_SESSION['messages'][] = "Video \"{$title}\" has been updated.";
        } else {
            $_SESSION['messages'][] = "Video \"{$title}\" was not updated.";
        }
    } else {
        $_SESSION['messages'][] = "Video title length must be less than 255.";
    }
}

?>

<?php require_once '../assets/layouts/admin_header.php'; ?>

<?php

$result = get_video_by_id($video_id, $_SESSION['user_id']);
$result = $result->fetch_assoc();

?>

<?php if ($result != null) { ?>

    <<div class="container">
        <h2 class="text-center">Edit Video</h2>
        <form action='<?php echo $_SERVER["PHP_SELF"] . "?video_id={$video_id}"; ?>' method='POST'
              class="form-horizontal">

            <?php require_once('../assets/layouts/messages.php'); ?>

            <div class="form-group">
                <label class="col-sm-4 control-label">Title</label>
                <div class="col-sm-4">
                    <input type="text" name="title" value="<?php echo htmlentities($result['title']); ?>" class="form-control" placeholder="Title" maxlength="255" required
                           autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Visibility</label>
                <div class="col-sm-4">
                    <label class="radio-inline"><input type="radio" name="visibility" value="1" <?php echo ($result['visibility'] == 1) ? "checked" : ""; ?>> Yes</label>
                    <label class="radio-inline"><input type="radio" name="visibility" value="0" <?php echo ($result['visibility'] == 0) ? "checked" : ""; ?>> No</label>
                </div>
            </div>
            <?php $video_categories = get_all_video_categories(); ?>
            <div class="form-group">
                <label class="col-sm-4 control-label">Video Category</label>
                <div class="col-sm-4">
                    <select class="form-control" name="video_category_id">
                        <?php while ($row = $video_categories->fetch_assoc()) { ?>
                            <option <?php echo ($row['video_category_name'] == $result['video_category_name']) ? 'selected' : '' ?> value="<?php echo $row['id']; ?>"><?php echo htmlentities($row['video_category_name']); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">URL</label>
                <div class="col-sm-4">
                    <input type="url" name="url" value="<?php echo htmlentities($result['url']); ?>" class="form-control" placeholder="http(s)://" maxlength="512" pattern="^(?:http|https):\/\/[\w\-_]+(?:\.[\w\-_]+)+[\w\-.,@?^=%&:/~\\+#]*$">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                    <input type="submit" name="submit" value="Edit Video" class="btn btn-primary btn-block">
                </div>
            </div>
        </form>
    </div>

<?php } else { ?>

    <h2>No record was found.</h2>

<?php } ?>

<?php require_once '../assets/layouts/admin_footer.php'; ?>
