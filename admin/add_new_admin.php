<?php

require_once('../assets/src/functions.php');
require_once('../assets/src/session.php');

if (!isset($_SESSION['user_id'])) {
    redirect_to('login.php');
}

$username = '';

if (isset($_POST['submit'])) {
    $username = escape_string(trim($_POST['username']));
    $pwd = trim($_POST['pwd']);
    if (check_username($username)) {
        $pwd = check_password($pwd);
        if (insert_user($username, $pwd)) {
            $_SESSION['messages'][] = 'Account has been created.';
            $username = '';
        } else {
            $_SESSION['messages'][] = "Account was not created.";
        }
    } else {
        $_SESSION['messages'][] = "Account was not created.";
    }
}

?>

<?php require_once '../assets/layouts/admin_header.php'; ?>

<div class="container">
    <h2 class="text-center">Add New Admin</h2>
    <form action='<?php echo $_SERVER["PHP_SELF"]; ?>' method='POST' class="form-horizontal">

        <?php require_once('../assets/layouts/messages.php'); ?>

        <div class="form-group">
            <label class="col-sm-4 control-label">Email</label>
            <div class="col-sm-4">
                <input type="email" name="username" value="<?php echo htmlentities($username); ?>" class="form-control" placeholder="user@domain.com" maxlength="255" pattern="^[\w.%+\-]+@[\w.\-]+\.[A-Za-z]{2,6}$" required autofocus>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Password</label>
            <div class="col-sm-4">
                <input type="password" name="pwd" class="form-control" placeholder="Password" minlength="8" maxlength="15" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])\S{8,15}$" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-4">
                <input type="submit" name="submit" value="Register" class="btn btn-primary btn-block">
            </div>
        </div>
    </form>
</div>

<?php require_once '../assets/layouts/admin_footer.php'; ?>
