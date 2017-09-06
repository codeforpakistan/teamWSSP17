
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCe0I76FCBsgJP2dh193EWuX2IPST4gn0k"></script>
<script type="text/javascript">

    var lat= [];
    var lon= [];
	var type=[];

    var x=0;    
    var map = null; 
    var markerArray = []; 
    var infowindow; 

    <?php foreach($latlong as $row): ?>
        lat.push(<?php echo $row['lat']; ?>);
        lon.push(<?php echo $row['long']; ?>);
		    type.push(<?php echo '"'. $row['type'].'"'; ?>);
        x++;
    <?php endforeach; ?>

        function initialize() {
            var myOptions = {
                zoom: 10,
                center: new google.maps.LatLng(lat[0], lon[0]),
                mapTypeControl: true, 
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
                },
                navigationControl: true,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            infowindow = new google.maps.InfoWindow({
                size: new google.maps.Size(150, 50)
            });

            google.maps.event.addListener(map, 'click', function() {
                infowindow.close();
            });

            for (var i = 0; i < x; i++) {
                createMarker(new google.maps.LatLng(lat[i], lon[i]),type[i]);
            }

        }

        var onMarkerClick = function() {
          var marker = this;
          var latLng = marker.getPosition();
          infowindow.setContent('<p>Marker position is:' + latLng.lat() + ', ' + latLng.lng() +' </p>');
          infowindow.open(map, marker);
        };

    function createMarker(latlng,type){
		//console.log(type);
		var icon = "";
		 switch (type) {
            case "PendingReview":
                icon = "red";   
                break;
            case "Completed":
                icon = "blue";
                break;
            case "UnderReview":
                icon = "yellow";
                break;
            case "InProgress":
                icon = "green";
                break;
        }
       // var icon = "";
       //   switch (type) {
       //       case "PendingReview":
       //     icon = "red-circle";  
       //         break;
       //     case "Completed":
       //         icon = "grn-circle";
       //         break;
       //     case "UnderReview":
       //         icon = "orange-circle";
       //         break;
       //     case "InProgress":
       //         icon = "wht-circle";
       //         break;
       // }
	      icon = "http://maps.google.com/mapfiles/ms/icons/"+icon+".png";
         //icon="http://maps.google.com/mapfiles/kml/paddle/"+icon+".png";
        var marker = new google.maps.Marker({
            position: latlng,
            map: map,
			      icon: icon,
            animation: google.maps.Animation.DROP,
        
		});
		
	

        google.maps.event.addListener(marker, 'click', onMarkerClick);
        markerArray.push(marker);
    }

    window.onload = initialize;

</script>
<style type="text/css">
html, body {
	margin: 0;
	padding: 0;
}
#map_canvas {
	width: 100%;
	height: 700px;
}
}
</style>
<div class="content-wrapper"> 
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Maps  </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="#">Tables</a></li>
      <li class="active">Data tables</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> 
        <div id="map_canvas"></div>
      </div>
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>

