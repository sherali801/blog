<?php

$messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];

unset($_SESSION['messages']);

?>

<?php if ($messages != null) { ?>

    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-4">
            <div class="alert alert-info">
                <ul>
                   <?php foreach ($messages as $message) { ?>
                       <li><?php echo $message; ?></li>
                   <?php } ?>
                </ul>
            </div>
        </div>
    </div>

<?php } ?>
