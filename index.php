<?php

require_once('assets/src/db_connect.php');
require_once('assets/src/functions.php');

if (isset($_GET['current_page']) && !empty($_GET['current_page'])) {
    $current_page = (int) escape_string(trim($_GET['current_page']));
} else {
    $current_page = 1;
}

$per_page = 6;

$q = '';

if (isset($_GET["q"]) && !empty($_GET['q'])) {
  $q = escape_string(trim($_GET["q"]));
}

$total_count = count_posts($q);

$offset = offset($current_page, $per_page);

$total_pages = total_pages($total_count, $per_page);

?>

<?php require_once('assets/layouts/public_header.php'); ?>

<?php $result = get_posts($q, $per_page, $offset); ?>

<?php if ($result != null) { ?>

    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 text-center">
            <h2>Posts</h2>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center"><?php echo htmlentities($row['title']); ?></h3>
                        </div>
                        <div class="panel-body"><?php echo htmlentities($row['body']); ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 text-center">
            <ul class="pagination">
                <?php
                if ($total_pages > 1) {
                    if($current_page - 1 >= 1) {
                        $per_page = $current_page - 1;
                        echo "<li><a href='index.php?q=". urlencode($q) . "&current_page={$per_page}'>&laquo;</a></li>";
                    }
                    for($i=1; $i <= $total_pages; $i++) {
                        if ($i == $current_page) {
                            echo "<li class='active'><a href='index.php?q=". urlencode($q) . "&current_page={$i}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='index.php?q=". urlencode($q) . "&current_page={$i}'>{$i}</a></li>";
                        }
                    }
                    if(($current_page + 1) <= $total_pages) {
                        $next_page = $current_page + 1;
                        echo "<li><a href='index.php?q=". urlencode($q) . "&current_page={$next_page}'>&raquo;</a></li>";
                    }
                }
                ?>
            </ul>
        </div>

    </div>

<?php } else { ?>

    <h2 class="text-center">No record was found.</h2>

<?php } ?>

<?php require_once('assets/layouts/public_footer.php'); ?>
