<script>
var markers = <?=$safehouse?>;
var new_marker = [
	{
		"address": '',
		"lat": '',
		"lng": '',
		"center": '',
		"pic_name1": '',
		"pic_contact1": '',
		"pic_name2": '',
		"pic_contact2": '',
		"radius": '500',
		"title": '',
	}
];

var NEW_MARKER_FLAG = 0;
var CURRENT_NEW_LOCATION = { lat: () => { return 0 }, lng: () => { return 0 }};
var newMarkers = [];
var CURRENT_ID_M = -1;
var newMarkerCircles = [];
var CURRENT_ID_MC = -1;
var defaultMarker = { draggable: true, icon: BASE_URL+'lib/img/safehouse.png' }
var defaultMarkerCircle = {
	strokeOpacity: 0.8,
	strokeWeight: 2,
	fillOpacity: 0.35,
}
var defaultMarkerCircleActive = {
	strokeColor: 'lime',
	fillColor: 'lime',
}
var defaultMarkerCircleInActive = {
	strokeColor: 'silver',
	fillColor: 'silver',
}
var markerActiveSelected = {
	strokeColor: 'green',
	fillColor: 'lime',
}
var markerInActiveSelected = {
	strokeColor: 'grey',
	fillColor: 'silver',
}

function getGeocodeLocation(geocoder, location, defaultAddress = 'Geolocation Failed'){
	geocoder.geocode({'location': location}, function(results, status) {
		if (status === 'OK') {
			if (results[0]) {
				$("#txtAddress").val(results[0].formatted_address);
			} else {
				$("#txtAddress").val(defaultAddress);
			}
		} else {
			$("#txtAddress").val(defaultAddress);
		}
	});
}

function getData(data, latLng){
	$("#txtId").val(data.id);
	$("#txtNamaPIC1").val(data.pic_name1);
	$("#txtKontakPIC1").val(data.pic_contact1);
	$("#txtNamaPIC2").val(data.pic_name2);
	$("#txtKontakPIC2").val(data.pic_contact2);
	$("#txtRadius").val(data.radius/100);
	$("#txtLatitude").val(latLng.lat());
	$("#txtLongitude").val(latLng.lng());
	if(data.is_active){
		$("#chkAktif").prop("checked",true);
	}else{
		$("#chkAktif").prop("checked",false);
	}
}

function removeMarker(idM, idMC){
	newMarkers[idM].setMap(null);
	newMarkerCircles[idMC].setMap(null);
}

// New marker object event
function placeMarker(location, map, geocoder) {
	var data = new_marker[0];
	var marker = new google.maps.Marker({
		...defaultMarker,
		position: location,
		map: map
	});
	var markerCircle = new google.maps.Circle({
		...defaultMarkerCircle,
		strokeColor: 'lightskyblue',
		fillColor: 'lightskyblue',
		map: map,
		radius: Math.sqrt(data.radius) * 150,
		editable: true
	});

	markerCircle.bindTo('center', marker, 'position');
	getData(data, location);
	getGeocodeLocation(geocoder, {lat:location.lat(),lng:location.lng()});

	marker.addListener('drag', function(event) {
		getData(data, event.latLng);
		getGeocodeLocation(geocoder, {lat:event.latLng.lat(),lng:event.latLng.lng()});
		markerCircle.setOptions({center:{lat:event.latLng.lat(),lng:event.latLng.lng()}});
	});

	google.maps.event.addListener(marker, 'click', function(event) {
		getData(data, event.latLng);
		getGeocodeLocation(geocoder, {lat:event.latLng.lat(),lng:event.latLng.lng()});
		markerCircle.setOptions({center:{lat:event.latLng.lat(),lng:event.latLng.lng()}});
	});

	google.maps.event.addListener(markerCircle, 'radius_changed', function() {
		$("#txtRadius").val((markerCircle.getRadius()/1000).toFixed(2));
	});

	NEW_MARKER_FLAG = 1;
	CURRENT_NEW_LOCATION = location;
	CURRENT_ID_M = marker.__gm_id;
	newMarkers[CURRENT_ID_M] = marker;
	CURRENT_ID_MC = markerCircle.__gm_id;
	newMarkerCircles[CURRENT_ID_MC] = markerCircle;
}

function initMap() {
	var mapOptions = {
		center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
		zoom: 10,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map"), mapOptions);
	var geocoder = new google.maps.Geocoder;	

	google.maps.event.addListener(map, 'click', function(event) {
		if(NEW_MARKER_FLAG == 1 && CURRENT_NEW_LOCATION != location){
			removeMarker(CURRENT_ID_M, CURRENT_ID_MC);
		}
		getGeocodeLocation(geocoder, {lat:event.latLng.lat(),lng:event.latLng.lng()});
		placeMarker(event.latLng, map, geocoder);
	});

	var marker = new Array();
	var markerCircle = new Array();

	// Generate existing marker
	for (var i = 0; i < markers.length; i++) {
		var data = markers[i];
		var myLatlng = new google.maps.LatLng(data.lat, data.lng);
		marker[i] = new google.maps.Marker({
			...defaultMarker,
			position: myLatlng,
			map: map,
			title: data.title,
		});
		markerCircle[i] = new google.maps.Circle({
			...defaultMarkerCircle,
			...(data.is_active ? defaultMarkerCircleActive : defaultMarkerCircleInActive),
			map: map,
			radius: Math.sqrt(data.radius) * 150,
			editable: true
		});
		markerCircle[i].bindTo('center', marker[i], 'position');

		// Attach events to existing marker
		(function (marker, data) {
			google.maps.event.addListener(marker, "click", function (e) {
				getData(data,e.latLng);
				getGeocodeLocation(geocoder, {lat:e.latLng.lat(),lng:e.latLng.lng()}, data.address);
				markerCircle.forEach((item, index) => {
					if(item.strokeColor == 'green' || item.strokeColor == 'lime'){
						markerCircle[index].setOptions(defaultMarkerCircleActive);
					} else {
						markerCircle[index].setOptions(defaultMarkerCircleInActive);
					}
				});
				if(data.is_active) {
					markerCircle[data.index].setOptions(markerActiveSelected);
				} else {
					markerCircle[data.index].setOptions(markerInActiveSelected);
				}
			});

			marker.addListener('drag', function(event) {
				getData(data, event.latLng);
				getGeocodeLocation(geocoder, {lat:event.latLng.lat(),lng:event.latLng.lng()}, data.address);
				markerCircle[data.index].setOptions({center:event.latLng});
				markerCircle.forEach((item, index) => {
					if(item.strokeColor == 'green' || item.strokeColor == 'lime'){
						markerCircle[index].setOptions(defaultMarkerCircleActive);
					} else {
						markerCircle[index].setOptions(defaultMarkerCircleInActive);
					}
				});
				if(data.is_active) {
					markerCircle[data.index].setOptions(markerActiveSelected);
				} else {
					markerCircle[data.index].setOptions(markerInActiveSelected);
				}
			});

			google.maps.event.addListener(markerCircle[data.index], 'radius_changed', function() {
				$("#txtRadius").val(parseFloat(markerCircle[data.index].getRadius()/800).toFixed(2));
			});
			
		})(marker[i], data);

	}
}
</script>
<!-- Page Content -->
<div class="container">

	<div class="row">
		<div class="col-md-12">
			<h4>
				<?=$title ?>
			</h4><br/>
		</div>
	</div>

	<form action="<?=base_url('index.php/backend/safehouse/save')?>" method="POST">
		<div class="row">
			<div class="col-md-7">
				<div id="map"></div>
				<ul id="safehouse-legend" class="list-inline" style="text-align: center;">
					<li style="color: lime; width: 100px;" class="list-inline-item">Aktif</li>
					<li style="color: silver; width: 100px;" class="list-inline-item">Tidak Aktif</li>
					<li style="color: lightskyblue; width: 100px;" class="list-inline-item">Baru</li>
				</ul>
			</div>
			<div class="col-md-5">
				<br>
				<div class="form-group" style="display: none;">
					<label>ID</label>
					<input type="text" class="form-control" id="txtId" name="txtId">
				</div>
				<div class="form-group">
					<label>Alamat/Nama Safehouse</label>
					<textarea type="text" class="form-control" id="txtAddress" name="txtAddress" required="required"></textarea>
				</div>
				<div class="row" style="display: none;">
					<div class="form-group col-md-6">
						<label>Latitude</label>
						<input type="text" class="form-control" id="txtLatitude" name="txtLatitude">
					</div>
					<div class="form-group col-md-6">
						<label>Longitude</label>
						<input type="text" class="form-control" id="txtLongitude" name="txtLongitude">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label>Nama PIC 1</label>
						<input type="text" class="form-control" id="txtNamaPIC1" name="txtNamaPIC1" required="required">
					</div>
					<div class="form-group col-md-6">
						<label>Kontak PIC 1</label>
						<input type="text" class="form-control" id="txtKontakPIC1" name="txtKontakPIC1" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label>Nama PIC 2</label>
						<input type="text" class="form-control" id="txtNamaPIC2" name="txtNamaPIC2" required="required">
					</div>
					<div class="form-group col-md-6">
						<label>Kontak PIC 2</label>
						<input type="text" class="form-control" id="txtKontakPIC2" name="txtKontakPIC2" required="required">
					</div>
				</div>
				<div class="row">
					<div class="form-group col-md-6">
						<label>Radius</label>
						<div class="input-group">
							<input type="text" class="form-control" id="txtRadius" name="txtRadius" aria-describedby="basic-addon" readonly="readonly">
							<span class="input-group-addon" id="basic-addon">KM</span>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label>&nbsp;</label>
						<div class="input-group">
							<span class="input-group-addon"><input type="checkbox" id="chkAktif" name="chkAktif"></span>
							<label class="form-control" for="chkAktif">Safehouse aktif?</label>
						</div>					
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-success" name="submitBtn" value="saveBtn">Simpan</button>
					<button type="submit" class="btn btn-danger" name="submitBtn" value="removeBtn">Hapus</button>
				</div>
			</div>
		</div>
	</form>

</div>