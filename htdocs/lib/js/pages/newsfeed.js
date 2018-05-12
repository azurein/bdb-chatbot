function initMap() {}

function decodeHtml(html) {
  var txt = document.createElement("textarea");
  txt.innerHTML = html;
  return txt.value;
}

Date.prototype.toDateInputValue = (function () {
  var local = new Date(this);
  local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
  return local.toJSON().slice(0, 10);
});

function checkDate(){
  if($('#date_from').val() > $('#date_to').val()){
    $('#date_to').val($('#date_from').val());
  }
  if($('#date_from_left').val() > $('#date_to_left').val()){
    $('#date_to_left').val($('#date_from_left').val());
  }
}

// var BASE_URL2 = "https://bunga-dalam-bahaya.herokuapp.com/"

function openModal(id){
  $.ajax({
    method: 'GET',
    url: BASE_URL + "index.php/bunga/openModalEvent/"+ encodeURI(id),
    success: function(html){
      $(".modal-body").html(html);
    }
  });
  $('#newsfeed').modal('show');
}

function save(){
  $('#status_form').submit();
}

$(document).ready(function () {
  $('#date_from').val(new Date().toDateInputValue());
  $('#date_to').val(new Date().toDateInputValue());
  $('#date_from_left').val(new Date().toDateInputValue());
  $('#date_to_left').val(new Date().toDateInputValue());

  var colors = [
    'blue',
    'aqua',
    'lime',
    'yellow',
    'green',
    'maroon',
    'fuchsia',
    'navy',
    'orange',
    'purple',
    'black',
    'teal',
    'light-blue'
  ];

  var groupBy = function (item, key) {
    return item.reduce(function (type, x) {
      (type[x[key]] = type[x[key]] || []).push(x);
      return type;
    }, {});
  };
  $.ajax({
    url: BASE_URL + 'index.php/bunga/getFeedLINE',
    method: 'GET',
    beforeSend: function () {
      $('.timeline').append(`<li class="loading"><img src="${'https://bunga-dalam-bahaya.herokuapp.com/lib/img/loading.gif'}"/></li>`);
    },
    success: function (result) {
      $('.loading').remove();

      var parseResult = JSON.parse(result);
      var area = "Jakarta";
      var resultByDate = groupBy(parseResult, 'submitDate');

      Object.keys(resultByDate).forEach((key) => {
        $('.timeline').append(`<li class="time-label"><span class="bg-black">${key}</span></li>`);

        var resultByTransactionCode = groupBy(resultByDate[key], 'transactionCode');

        Object.keys(resultByTransactionCode).forEach((key2) => {
          var text = "";
          var type = "Line",
            style = "success",
            trxCode = "";
          var textHTML = "";
          var displayName = resultByTransactionCode[key2][0].displayName;
          var phone = resultByTransactionCode[key2][0].phone;
          var textStatus = "Belum ditanggapi", colorStatus = "gray", btnStatus = "success";

          resultByTransactionCode[key2].forEach((item, idx) => {
            trxCode = item.transactionCode;
            if (item.message.type === "text") {
              if (item.questionId != "0") {
                textHTML = ` <b>${item.message.text}</b>`;
              } else {
                textHTML = ` ${item.message.text}`;
              }
              text += `<div class="col-xs-1 col-sm-1"><small style='font-style: italic; color: #999; margin-right: 20px;'>${item.submitTime}</small></div>
              <div class="col-xs-11 col-sm-11"><p>${item.question_id != "0" ? item.question : ''} ${textHTML}</p></div>`;
            } else if (item.message.type === "location") {
              text += `<div class="col-xs-1 col-sm-1"><small style='font-style: italic; color: #999; margin-right: 20px;'>${item.submitTime}</small></div>
              <div class="col-xs-11 col-sm-11">
              <p>
                <a href="https://www.google.co.id/maps/@${item.message.latitude},${item.message.longitude}" target="_new">
                  <div class="g_map" id="map-${item.message.id}" style="width: 100%; height: 300px;"></div>
                </a><br/>
                <script>
                  var mapOptions${item.message.id} = {
                    center: new google.maps.LatLng(${item.message.latitude}, ${item.message.longitude}),
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    zoom: 15,
                  };
                  var map${item.message.id} = new google.maps.Map(document.getElementById("map-${item.message.id}"), mapOptions${item.message.id});
                  var myLatlng = new google.maps.LatLng(${item.message.latitude}, ${item.message.longitude});
                  var marker = new google.maps.Marker({
                    position: myLatlng,
                    draggable: true,
                    map: map${item.message.id},
                  });
                  var markerCircle = new google.maps.Circle({
                    strokeColor: 'lime',
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: 'lime',
                    fillOpacity: 0.35,
                    map: map${item.message.id},
                    radius: 100
                  });
                  markerCircle.bindTo('center', marker, 'position');
                </script>
                Alamat : ${item.message.address}
              </p>
              </div>
            `;
            } else if (item.message.type === "pictures") {
              text += `<div class="col-xs-1 col-sm-1"><small style='font-style: italic; color: #999; margin-right: 20px;'>${item.submitTime}</small></div>
                <div class="col-xs-11 col-sm-11"><img src="http://placehold.it/150x100" alt="..." class="img-fluid"></div>`;
            } else if (item.message.type === "form") {
              type = "Form";
              style = "warning";
              if (item.questionId == "0") {
                textHTML = decodeHtml(item.message.text);
              } else {
                textHTML = ` <b>${item.message.text}</b>`;
              }
              text += `<div class="col-xs-1 col-sm-1"><small style='font-style: italic; color: #999; margin-right: 20px;'>${idx === 0 ? item.submitTime : ''}</small></div>
                <div class="col-xs-11 col-sm-11">${item.questionId != "0" ? item.question : ''} ${textHTML}</div>`;
            }
            if(item.status == "onprogress"){
              textStatus = "Sedang ditangani";
              colorStatus = "yellow";
              btnStatus = "warning";
            } else if(item.status == "done"){
              textStatus = "Sudah selesai";
              colorStatus = "green";
              btnStatus = "default";
            } else if(item.status == "cancel") {
              textStatus = "Dibatalkan";
              colorStatus = "red";
              btnStatus = "danger";
            }
          });


          $('.timeline').append(`
            <li>
              <i class="fa fa-envelope bg-${colors[Math.floor(Math.random()*colors.length)]}"></i>
              <div class="timeline-item">
                <span class="time"><i class="fa fa-clock-o"></i> <span class="badge badge-${style}">${type}</span></span>
                <h3 class="timeline-header"><a href="#">${displayName}</a> mengirimkan laporan</h3>
                <div class="timeline-body">
                  <table>
                    <tr>
                      <td width=200>Kontak</td>
                      <td width=20>:</td>
                      <td>${phone ? phone : '-'}</td>
                    </tr>
                    <tr>
                      <td>Area Korban</td>
                      <td>:</td>
                      <td>${area ? area : '-'}</td>
                    </tr>
                    <tr>
                      <td>Status Tindaklanjut</td>
                      <td>:</td>
                      <td class="text-${colorStatus}">${textStatus}</td>
                    </tr>
                  </table><br/>
                  <div class="row">
                    ${text}
                  </div>
                </div>
                <div class="timeline-footer">
                  <a class="btn btn-${btnStatus} btn-xs text-white" onClick="openModal('${trxCode}')">Tanggapi Kasus</a>
                </div>
              </div>
            </li>
        `); // append
        }); // Object.keys foreach
      }); // Object.keys foreach
    } // end success function
  }); // end ajax
});