<style>
  html {
    position: relative;
    min-height: 100%;
  }

  body {
    margin: 0 0 60px;
  }
</style>
<div id="newsfeed" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="image-managerLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Tanggapi Kasus</h3>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-success" type="button" onClick="save()">Save</button>
      </div>
    </div>
  </div>
</div>
<!-- Page Content -->
<div class="container" style="min-height: 650px;">

  <div class="row">
    <div class="col-lg-6 col-md-12">
      <h3>
        <?=$title ?>
      </h3>
    </div>
    <div class="col-lg-6 text-right filter-top">
      <label class="radio-inline" style="padding-right: 20px;">
        <h4>Sortir:</h4>
      </label>
      <label class="radio-inline" style="padding-right: 20px;">
        <input type="radio" name="sortradio_wide" val="desc"> Berita terbaru
      </label>
      <label class="radio-inline">
        <input type="radio" name="sortradio_wide" val="asc"> Berita terdahulu
      </label>
    </div>
  </div>
  <br/>
  <div class="row">
    <div class="col-lg-3">
      <div class="filter-left">
        <h4>Filter:</h4>
        <hr>
        <h5>Status berita</h5>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="pending" name="status"> Belum ditanggapi</label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="onprogress" name="status"> Sedang ditangani</label>
        </div>
        <div class="checkbox disabled">
          <label>
            <input type="checkbox" value="done" name="status"> Sudah selesai</label>
        </div>
        <div class="checkbox disabled">
          <label>
            <input type="checkbox" value="cancel" name="status"> Dibatalkan</label>
        </div>
        <hr>
        <h5>Rentang tanggal</h5>
        Dari:
        <input class="form-control" type="date" value="" style="width:90%;" id="date_from_left" onChange="checkDate()">
        <br> Sampai:
        <input class="form-control" type="date" value="" style="width:90%;" id="date_to_left" onChange="checkDate()">
        <hr>
        <h5>Jenis berita</h5>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="tolong" name="news_type_left">
            <span style="color: red;">TOLONG</span>
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="laporan" name="news_type_left"> Laporan</label>
        </div>
        <div class="checkbox disabled">
          <label>
            <input type="checkbox" value="safehouse" name="news_type_left"> Safehouse</label>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-12">
      <ul class="timeline"></ul>
    </div>
  </div>
</div>
<div class="filter-mobile">
  <button class="btn btn-primary" style="width: 45%" data-toggle="modal" data-target="#modalFilter">
    <span class="glyphicon glyphicon-filter"></span> Filter</button>
  <button class="btn btn-primary" style="width: 45%" data-toggle="modal" data-target="#modalSortir">
    <span class="glyphicon glyphicon-sort"></span> Sortir</button>
</div>

<div class="modal fade" id="modalSortir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Sortir</h4>
      </div>
      <div class="modal-body">
        <div class="radio">
          <label>
            <input type="radio" name="sortradio_mobile" value="newest"> Berita terbaru</label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="sortradio_mobile" value="oldest"> Berita terdahulu</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Terapkan sortir</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFilter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Filter</h4>
      </div>
      <div class="modal-body">
        <h5>Status berita</h5>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="pending" name="status"> Belum ditanggapi</label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="onprogress" name="status"> Sedang ditangani</label>
        </div>
        <div class="checkbox disabled">
          <label>
            <input type="checkbox" value="done" name="status"> Sudah selesai</label>
        </div>
        <div class="checkbox disabled">
          <label>
            <input type="checkbox" value="cancel" name="status"> Dibatalkan</label>
        </div>
        <hr>
        <h5>Rentang tanggal</h5>
        Dari:
        <input class="form-control" type="date" value="" style="width:90%;" id="date_from" name="date_from" onChange="checkDate()">
        <br> Sampai:
        <input class="form-control" type="date" value="" style="width:90%;" id="date_to" name="date_to" onChange="checkDate()">
        <hr>
        <h5>Jenis berita</h5>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="tolong" name="news_type">
            <span style="color: red;">TOLONG</span>
          </label>
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="laporan" name="news_type"> Laporan</label>
        </div>
        <div class="checkbox disabled">
          <label>
            <input type="checkbox" value="safehouse" name="news_type"> Safehouse</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Terapkan Filter</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
</script>