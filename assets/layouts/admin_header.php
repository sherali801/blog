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
              <a class="navbar-brand" href="home.php">Gallery</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                <li><a href="home.php">Home</a></li>
              </ul>
                <?php if (isset($_SESSION['user_id'])) { ?>
                  <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
                          <ul class="dropdown-menu">
                              <li><a href="add_new_admin.php">Add New Admin</a></li>
                              <li><a href="manage_admins.php">Manage Admins</a></li>
                          </ul>
                      </li>
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Post<span class="caret"></span></a>
                          <ul class="dropdown-menu">
                              <li><a href="add_new_post_category.php">Add New Post Category</a></li>
                              <li><a href="manage_post_categories.php">Manage Post Categories</a></li>
                              <li><a href="add_new_post.php">Add New Post</a></li>
                              <li><a href="manage_posts.php">Manage Posts</a></li>
                          </ul>
                      </li>
                      <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Video<span class="caret"></span></a>
                          <ul class="dropdown-menu">
                              <li><a href="add_new_video_category.php">Add New Video Category</a></li>
                              <li><a href="manage_video_categories.php">Manage Video Categories</a></li>
                              <li><a href="add_new_video.php">Add New Video</a></li>
                              <li><a href="manage_videos.php">Manage Videos</a></li>
                          </ul>
                      </li>
                      <li><a href="logout.php">Log Out</a></li>
                  </ul>
                <?php } ?>
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container-fluid -->
        </nav>
    </div>
