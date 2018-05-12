<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>LSM - <?=$title ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('lib/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('lib/css/AdminLTE.min.css')?>">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('lib/css/1-col-portfolio.css')?>" rel="stylesheet">

    <script type="text/javascript">
      const BASE_URL='<?=base_url()?>';
    </script>
    
    <script src="<?=base_url('lib/vendor/jquery/jquery.min.js')?>"></script>
    
  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Selamat Datang, Admin LSM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item <?=$page == 'dashboard' ? 'active' : '' ?>">
              <a class="nav-link" href="<?=base_url('index.php/backend/dashboard')?>">Dashboard
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?=$page == 'newsfeed' ? 'active' : '' ?>">
              <a class="nav-link" href="<?=base_url('index.php/backend/newsfeed')?>">News Feed
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?=$page == 'safehouse' ? 'active' : '' ?>">
              <a class="nav-link" href="<?=base_url('index.php/backend/safehouse')?>">Safehouse
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?=$page == 'questions' ? 'active' : '' ?>">
              <a class="nav-link" href="<?=base_url('index.php/backend/manage/questions')?>">Kuesioner
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item <?=$page == 'staff' ? 'active' : '' ?>">
              <a class="nav-link" href="<?=base_url('index.php/backend/manage/staff')?>">Staff
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?=base_url('index.php/backend/logout')?>">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>