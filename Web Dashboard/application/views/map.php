<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=AIzaSyCe0I76FCBsgJP2dh193EWuX2IPST4gn0k&sensor=false"></script>
<script type="text/javascript">


    var latitude= [];
    var longitude= [];
	var type=[];
	var img=[];
	var bin=[];
	var details=[];

    var x=0;    
    var map = null; 
    var markerArray = []; 
    var infowindow; 

    <?php foreach($latlong as $row): ?>
        latitude.push(<?php echo $row['latitude']; ?>);
        longitude.push(<?php echo $row['longitude']; ?>);
		type.push("<?php echo $row['status']; ?>");
		details.push("<?php echo $row['c_details']; ?>");
		bin.push("<?php echo $row['bin_address']; ?>");
				img.push("<?php echo $row['image_path']; ?>");

		
        x++;
    <?php endforeach; ?>

        function initialize() {
            var myOptions = {
				
                zoom: 12,
                center: new google.maps.LatLng(latitude[0], longitude[0]),
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
                createMarker(new google.maps.LatLng(latitude[i], longitude[i]),type[i],details[i],bin[i],img[i]);
            }

        }

        var onMarkerClick = function() {
          var marker = this;
          var latLng = marker.getPosition();
		  var details = marker.content;
		  infowindow.setContent('<p>Details:'+details+'</p>');
		  infowindow.open(map, marker);
        };
		

    function createMarker(latlng,type,details,bin,img){
        // ga('status', {
        //   hitType: type,
        //   eventCategory: '',
        //   eventAction: '',
        //   eventLabel: 
        // });
		//console.log(type);
		var icon = "";
		 switch (type) {
              case "inprogress":
            icon = "yellow"; 
            type="In Progress";  
                break;
            case "pendingreview":
                icon = "red";
                type="Pending Review"; 
                break;
            case "completed":
                icon = "green";
                type="Completed"; 
                break;
           //case "underreview":
             //   icon = "green";
               // break;
        }
	        icon = "http://maps.google.com/mapfiles/ms/icons/"+icon+".png";
        
        var marker = new google.maps.Marker({
            position: latlng,
			icon: icon,
			animation: google.maps.Animation.DROP,	
			titl:bin,
			content: '<p>'+details+'</p><p>status :'+type+'</p><p>Location :'+bin+'</p><p>image :</p><img src="'+img+'" width="150px" height="150px"/>',
			image:img,
				
		      //title:details,		
            map: map
			
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
</head>
<body>
<div id="map_canvas"></div>
</body>
</html>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

 ga('create', 'UA-100500944-1', 'auto');
  ga('send', 'pageview');

</script>