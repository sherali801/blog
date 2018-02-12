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

$result = get_all_users();

if ($result != null) { ?>

    <div class="container">
        <table class="table table-bordered table-striped">
            <tr>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlentities($row['username']); ?></td>
                    <td>
                        <a href="edit_admin.php?user_id=<?php echo urlencode($row['id']); ?>"><button type="button" class="btn btn-info">Edit</button></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

<?php } else { ?>
    <h2>No record was found.</h2>
<?php } ?>

<?php require_once '../assets/layouts/admin_footer.php'; ?>
