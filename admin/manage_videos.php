<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

?>

<?php require_once '../assets/layouts/admin_header.php'; ?>

<?php require_once('../assets/layouts/messages.php'); ?>

<?php

$result = get_all_videos_by_user_id($_SESSION['user_id']);

if ($result != null) { ?>

    <div class="container">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Title</th>
                <th>URL</th>
                <th>Visibilty</th>
                <th>Video&nbsp;Category</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlentities($row['title']); ?></td>
                    <td><?php echo htmlentities($row['url']); ?></td>
                    <td><?php echo htmlentities($row['visibility']) ? "Yes" : "No"; ?></td>
                    <td><?php echo htmlentities($row['video_category_name']); ?></td>
                    <td>
                        <a href="edit_video.php?video_id=<?php echo urlencode($row['id']); ?>"><button type="button" class="btn btn-info">Edit</button></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

<?php } else { ?>

    <h2>No record was found.</h2>

<?php } ?>

<?php require_once '../assets/layouts/admin_footer.php'; ?>
