<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Blog</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php">Gallery</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                  <?php $result = get_all_post_categories(); ?>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Post Categories<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <?php while ($row = $result->fetch_assoc()) { ?>
                              <li><a href="posts_by_category.php?post_category_id=<?php echo urlencode($row['id']); ?>"><?php echo htmlentities ($row['post_category_name']); ?></a></li>
                          <?php } ?>
                      </ul>
                  </li>
                  <?php $result = get_all_video_categories(); ?>
                  <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Video Categories<span class="caret"></span></a>
                      <ul class="dropdown-menu">
                          <?php while ($row = $result->fetch_assoc()) { ?>
                              <li><a href="videos_by_category.php?video_category_id=<?php echo urlencode($row['id']); ?>"><?php echo htmlentities ($row['video_category_name']); ?></a></li>
                          <?php } ?>
                      </ul>
                  </li>
              </ul>
              <form class="navbar-form navbar-left">
                <div class="form-group">
                  <input type="text" name="q" value="<?php echo $q; ?>" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </div>
