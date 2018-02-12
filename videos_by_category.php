<?php

require_once('assets/src/db_connect.php');
require_once('assets/src/functions.php');

if (isset($_GET['current_page']) && !empty($_GET['current_page'])) {
    $current_page = (int) escape_string(trim($_GET['current_page']));
} else {
    $current_page = 1;
}

if (isset($_GET['video_category_id']) && !empty($_GET['video_category_id'])) {
    $video_category_id = (int) escape_string(trim($_GET['video_category_id']));
} else {
    $video_category_id = 0;
}

$per_page = 6;

$q = '';

if (isset($_GET["q"]) && !empty($_GET['q'])) {
    $q = escape_string(trim($_GET["q"]));
}

$total_count = count_videos_by_category_id($q, $video_category_id);

$offset = offset($current_page, $per_page);

$total_pages = total_pages($total_count, $per_page);

?>

<?php require_once('assets/layouts/public_header.php'); ?>

<?php $result = get_videos_by_category_id($q, $video_category_id, $per_page, $offset); ?>

<?php if ($result->num_rows > 0) { ?>

    <div class="container">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 text-center">
            <h2>Videos</h2>
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
                        <div class="panel-body embed-responsive embed-responsive-16by9"><iframe src="<?php echo htmlentities($row['url']); ?>" frameborder="0" allowfullscreen></iframe></div>
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
                        echo "<li><a href='videos_by_category.php?q=". urlencode($q) . "&current_page={$per_page}&video_category_id={$video_category_id}'>&laquo;</a></li>";
                    }
                    for($i=1; $i <= $total_pages; $i++) {
                        if ($i == $current_page) {
                            echo "<li class='active'><a href='videos_by_category.php?q=". urlencode($q) . "&current_page={$i}&video_category_id={$video_category_id}'>{$i}</a></li>";
                        } else {
                            echo "<li><a href='videos_by_category.php?q=". urlencode($q) . "&current_page={$i}&video_category_id={$video_category_id}'>{$i}</a></li>";
                        }
                    }
                    if(($current_page + 1) <= $total_pages) {
                        $next_page = $current_page + 1;
                        echo "<li><a href='videos_by_category.php?q=". urlencode($q) . "&current_page={$next_page}&video_category_id={$video_category_id}'>&raquo;</a></li>";
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
