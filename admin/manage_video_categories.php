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

$result = get_all_video_categories_by_user_id($_SESSION['user_id']);

if ($result != null) { ?>

    <div class="container">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Video Category Name</th>
                <th>Visibilty</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlentities($row['video_category_name']); ?></td>
                    <td><?php echo htmlentities($row['visibility']) ? "Yes" : "No"; ?></td>
                    <td>
                        <a href="edit_video_category.php?video_category_id=<?php echo urlencode($row['id']); ?>"><button type="button" class="btn btn-info">Edit</button></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

<?php } else { ?>

    <h2>No record was found.</h2>

<?php } ?>

<?php require_once '../assets/layouts/admin_footer.php'; ?>
