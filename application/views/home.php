<?php include('header.php');?>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand js-scroll-trigger" href="<?=base_url()?>">Bunga Dalam Bahaya</a>
  </div>
</nav>

<header class="masthead">
  <div class="container h-100">
    <div class="row h-100">
      <div class="col-lg-7 my-auto">
        <div class="header-content mx-auto">
          <h1 class="mb-5">Bunga Dalam Bahaya! Ayo Lapor Sekarang!</h1>
          <a href="#report" class="btn btn-outline btn-xl js-scroll-trigger">Laporkan!</a>
          <br/>
          <br/>
          <a href="#download" class="btn btn-outline btn-xl js-scroll-trigger">Tambah Teman Line</a>
        </div>
      </div>
      <div class="col-lg-5 my-auto">
        <div class="device-container">
          <div class="device-mockup iphone6_plus portrait white">
            <div class="device">
              <div class="screen">
                <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                <img src="<?=base_url('lib/img/bunga-profile.jpg')?>" class="img-fluid" alt="">
              </div>
              <div class="button">
                <!-- You can hook the "home button" to some JavaScript events or just remove it -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<section class="features" id="features">
  <div class="container">
    <div class="section-heading text-center">
      <h2>Laporkan Langsung Ke Bunga</h2>
      <p class="text-muted">Ketahui apa saja yang bisa dilakukan oleh Bunga</p>
      <hr>
    </div>
    <div class="row">
      <div class="col-lg-4 my-auto">
        <div class="device-container">
          <div class="device-mockup iphone6_plus portrait white">
            <div class="device">
              <div class="screen">
                <img src="<?=base_url('lib/img/bunga.jpg')?>" class="img-fluid" alt="">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8 my-auto">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-6">
              <div class="feature-item">
                <i class="fa fa-bullhorn text-primary"></i>
                <h3>Cari Bantuan</h3>
                <p class="text-muted">Bunga akan mencarikan bantuan untuk sister</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="feature-item">
                <i class="fa fa-file text-primary"></i>
                <h3>Buat Laporan</h3>
                <p class="text-muted">laporkan tindak kekerasan langsung ke Bunga</p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="feature-item">
                <i class="fa fa-home text-primary"></i>
                <h3>Rumah Aman</h3>
                <p class="text-muted">Cari rumah aman bersama dengan Bunga</p>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="feature-item">
                <i class="fa fa-book text-primary"></i>
                <h3>Info dan Pengetahuan</h3>
                <p class="text-muted">Bunga akan memberikan info, tips, dan trik menarik</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="download text-center" id="download" style="background: #eee">
  <div class="container">
    <div class="row">
      <div class="col-md-8 mx-auto">
        <h2 class="section-heading">Tambah Bunga Sebagai Teman Kamu di Line!</h2>
        <p>Scan QR Code Berikut!</p>
        <div class="badges">
          <img src="http://qr-official.line.me/L/f_yMAnT4r5.png" class="img-fluid" style="height: 200px">
        </div>
      </div>
    </div>
  </div>
</section>

<section class="cta" id="report">
  <div class="cta-content">
    <div class="container">
      <h2>Form Pelaporan</h2>
      <form action="<?=base_url()?>" id="regForm" method="POST">
        <!--Form_1-->
        <div class="tab">
          <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap anda" required>
          </div>
          <div class="form-group">
            <label for="hp">Nomor HP</label>
            <input type="text" class="form-control" id="hp" name="hp" placeholder="Masukkan nomor handphone anda (contoh: 08112345678)" required>
          </div>
          <div class="form-group">
            <label for="email">Alamat E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan alamat e-mail anda" required>
          </div>
        </div>
        <!--Form_2-->
        <div class="tab" style="display:none;">
          <?php foreach($questions as $key => $question){ ?>
          <div class="form-group">
            <label for="question_<?=$question['id']?>"><?=$question['text']?></label>
            <select name="question_<?=$question['id']?>" class="form-control">
              <option value="<?=$question['option_a']?>"><?=$question['option_a']?></option>
              <option value="<?=$question['option_b']?>"><?=$question['option_b']?></option>
              <option value="<?=$question['option_c']?>"><?=$question['option_c']?></option>
              <option value="<?=$question['option_d']?>"><?=$question['option_d']?></option>
            </select>
          </div>
          <?php } ?>
          <div class="form-group">
            <label for="textarea">Ceritakan tentang pengalaman yang kamu alami</label>
            <textarea name="textarea" id="textarea"></textarea>
          </div>
        </div>
        <div style="overflow:auto;">
          <div style="float:right;">
            <button type="button" id="prevBtn" class="btn btn-outline btn-xl" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" class="btn btn-outline btn-xl" onclick="nextPrev(1)">Next</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="overlay"></div>
</section>

<?php include('footer.php');?>
<script type="text/javascript">
var currentTab = 0;
showTab(currentTab);

function checkForm(){
  var name = $("#name").val();
  var hp = $("#hp").val();
  var email = $("#email").val();

  if(name === "" || name === null) {
    $("#name").css("border-color","#f00");
    return false;
  } else {
    $("#name").css("border-color","#000");
  }

  if(hp === "" || hp === null) {
    $("#hp").css("border-color","#f00");
    return false;
  } else {
    $("#hp").css("border-color","#000");
  }

  if(email === "" || email === null) {
    $("#email").css("border-color","#f00");
    return false;
  } else {
    $("#email").css("border-color","#000");
  }

  return true;
}

function showTab(n) {
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Lapor Sekarang!";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
}

function nextPrev(n) {
  var x = document.getElementsByClassName("tab");
  
  if(checkForm()){
    x[currentTab].style.display = "none";
    currentTab = currentTab + n;
    if (currentTab >= x.length) {
      document.getElementById("regForm").submit();
      // return false;
    }
    showTab(currentTab);
  }
}

//bootstrap WYSIHTML5 - text editor
CKEDITOR.replace('textarea');
</script>

</body>

</html>