<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bunga Dalam Bahaya - News Feed</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('lib/vendor/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
	  <link rel="stylesheet" href="<?=base_url('lib/css/AdminLTE.min.css')?>">

    <!-- Custom styles for this template -->
    <link href="<?=base_url('lib/css/1-col-portfolio.css')?>" rel="stylesheet">
    <style>
    </style>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Admin Bunga</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#">News Feed
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

    <?php
      $color = array(
        0 => 'blue',
        1 => 'aqua',
        2 => 'lime',
        3 => 'yellow',
        4 => 'green',
        5 => 'maroon',
        6 => 'fuchsia',
        7 => 'navy',
        8 => 'orange',
        9 => 'purple',
        10 => 'black',
        11 => 'teal',
        12 => 'light-blue'
      )
    ?>
    <!-- Page Content -->
    <div class="container">

    <div class="row">
        <div class="col-md-12">
          <h4>
            News Feed
            <small>Selamat Datang, &lt;&lt;Admin LSM_01&gt;&gt;</small>
          </h4><br/>
      </div>
    </div>

    <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    16 Desember 2017
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-envelope bg-<?=$color[rand(0,sizeof($color)-1)]?>"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <span class="badge badge-warning">Form</span> 12:05</span>

                <h3 class="timeline-header"><a href="#">Bunga A</a> mengirimkan laporan kekerasan</h3>

                <div class="timeline-body">
                  <table>
                    <tr>
                      <td width=200>Kontak</td>
                      <td width=20>:</td>
                      <td><a href="mailto:korbanbunga@bunga.com">korbanbunga@bunga.com</a> / 08123456789</td>
                    </tr>
                    <tr>
                      <td>Area Korban</td>
                      <td>:</td>
                      <td>Jakarta Selatan</td>
                    </tr>
                    <tr>
                      <td>Sudah ditanggapi oleh</td>
                      <td>:</td>
                      <td class="text-red">Belum ada tanggapan</td>
                    </tr>
                  </table><br/>
                  <p>Saya mengalami kekerasan dalam rumah tangga saya. Setiap hari suami saya pulang kerja dengan emosi yang sangat tinggi. Dan kadang dia sering memukuli saya sampai saya mengalami memar2. Saya tidak berani bercerita kepada teman2 saya karena sejujurnya saya malu dengan perilaku tersebut. apakah bunga bisa membantu saya?</p>
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-danger btn-xs text-white">Tanggapi Kasus</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-user bg-<?=$color[rand(0,sizeof($color)-1)]?>"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <span class="badge badge-success">Line</span> 5 mins ago</span>

                <h3 class="timeline-header"><a href="#">Bunga B</a> mengirimkan lokasi dan pesan </h3>

                <div class="timeline-body">
                  <table>
                    <tr>
                      <td>Sudah ditanggapi oleh</td>
                      <td>:</td>
                      <td class="text-red">Belum ada tanggapan</td>
                    </tr>
                  </table><br/>
                  <a href="https://www.google.co.id/maps/@-6.2240244,106.8308283,17.42z?hl=en" target="_new"><img src="<?=base_url('lib/img/maps.png')?>" height=200 /></a>
                  <p>Saya diikuti oleh orang mencurigakan di daerah ini. ciri-ciri orangnya kulit hitam, pakai baju hitam tingginya sekitar 170cm</p>
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-danger btn-xs text-white">Tanggapi Kasus</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-comments bg-<?=$color[rand(0,sizeof($color)-1)]?>"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <span class="badge badge-warning">Form</span> 2 hours ago</span>

                <h3 class="timeline-header"><a href="#">Bunga C</a> mengirimkan laporan kekerasan</h3>

                <div class="timeline-body">
                <table>
                <tr>
                  <td width=200>Kontak</td>
                  <td width=20>:</td>
                  <td><a href="mailto:korbanbunga@bunga.com">korbanbunga2@bunga.com</a> / 081289089089</td>
                </tr>
                <tr>
                  <td>Area Korban</td>
                  <td>:</td>
                  <td>Jakarta Selatan</td>
                </tr>
                <tr>
                  <td>Sudah ditanggapi oleh</td>
                  <td>:</td>
                  <td class="text-blue">Lembaga Sosial 1</td>
                </tr>
              </table><br/>
              <p>Saya mengalami kekerasan dalam rumah tangga saya. Setiap hari suami saya pulang kerja dengan emosi yang sangat tinggi. Dan kadang dia sering memukuli saya sampai saya mengalami memar2. Saya tidak berani bercerita kepada teman2 saya karena sejujurnya saya malu dengan perilaku tersebut. apakah bunga bisa membantu saya?</p>
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-warning btn-flat btn-xs text-white">Dalam Penanganan</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-red">
                    10 Desember 2017
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              <i class="fa fa-camera bg-<?=$color[rand(0,sizeof($color)-1)]?>"></i>

              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <span class="badge badge-success">Line</span> 5 days ago</span>

                <h3 class="timeline-header"><a href="#">Bunga D</a> mengirimkan foto</h3>

                <div class="timeline-body">
                  <table>
                    <tr>
                      <td>Sudah ditanggapi oleh</td>
                      <td>:</td>
                      <td class="text-red">Belum ada tanggapan</td>
                    </tr>
                  </table><br/>
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                  <img src="http://placehold.it/150x100" alt="..." class="margin">
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-danger btn-xs text-white">Tanggapi Kasus</a>
                </div>
              </div>
            </li>
            <!-- END timeline item -->
            <li>
              <i class="fa fa-clock-o bg-gray"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>

      <div class="row">
        <div class="col-md-12" style="margin: 10px; text-align: center;">
          <a href="" class="btn btn-default">Lihat laporan terdahulu</a>
        </div>
      </div>

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Bunga Dalam Bahaya <?=date('Y')?></p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url('lib/vendor/jquery/jquery.min.js')?>"></script>
    <script src="<?=base_url('lib/vendor/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
    <script type="text/javascript">
    $(document).ready(function(){
      $.ajax({
        url: <?=base_url('index.php/bunga/getFeedLINE')?>,
        method: 'GET',
        success: function(result){
          var res = JSON.parse(result);
          res.foreach(x => {
            console.log(x);
            $('.timeline').append('<li>');
            $('.timeline').append('<i class="fa fa-envelope bg-<?=$color[rand(0,sizeof($color)-1)]?>"></i>');
            $('.timeline').append(`
            <div class="timeline-item">
              <span class="time"><i class="fa fa-clock-o"></i> <span class="badge badge-warning">Form</span> 12:05</span>

              <h3 class="timeline-header"><a href="#">Bunga A</a> mengirimkan laporan kekerasan</h3>

              <div class="timeline-body">
                <table>
                  <tr>
                    <td width=200>Kontak</td>
                    <td width=20>:</td>
                    <td><a href="mailto:korbanbunga@bunga.com">korbanbunga@bunga.com</a> / 08123456789</td>
                  </tr>
                  <tr>
                    <td>Area Korban</td>
                    <td>:</td>
                    <td>Jakarta Selatan</td>
                  </tr>
                  <tr>
                    <td>Sudah ditanggapi oleh</td>
                    <td>:</td>
                    <td class="text-red">Belum ada tanggapan</td>
                  </tr>
                </table><br/>
                <p>Saya mengalami kekerasan dalam rumah tangga saya. Setiap hari suami saya pulang kerja dengan emosi yang sangat tinggi. Dan kadang dia sering memukuli saya sampai saya mengalami memar2. Saya tidak berani bercerita kepada teman2 saya karena sejujurnya saya malu dengan perilaku tersebut. apakah bunga bisa membantu saya?</p>
              </div>
              <div class="timeline-footer">
                <a class="btn btn-danger btn-xs text-white">Tanggapi Kasus</a>
              </div>
            </div>
            `);
            $('.timeline').append('</li>');
          });
        }
      });
    </script>

  </body>

</html>