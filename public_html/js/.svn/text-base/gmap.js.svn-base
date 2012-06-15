var GMap = {
  map: null,
  infoWindow: null,
  markers: [
  ]
};
/**
 * Called when clicking anywhere on the map and closes the info window.
 */
GMap.closeInfoWindow = function() {
  GMap.infoWindow.close();
};

/**
 * Opens the shared info window, anchors it to the specified marker, and
 * displays the marker's position as its content.
 */
GMap.openInfoWindow = function(marker) {
  var markerLatLng = marker.obj.getPosition();
  GMap.infoWindow.setContent(marker.content);
  GMap.infoWindow.open(GMap.map, marker.obj);
};

GMap.panToMarker = function(markerNum) {
    GMap.openInfoWindow(GMap.markers[markerNum]);
    //GMap.map.setZoom(15);
    //GMap.map.panTo(GMap.markers[markerNum].obj.getPosition());
}

/**
 * Called only once on initial page load to initialize the map.
 */
GMap.init = function(markerselector) {
    GMap.map = null;
    GMap.infoWindow = null;
    GMap.markers = new Array();
  if(!$(markerselector).length>0) return false;
  
  // Create single instance of a Google Map.
  //var centerLatLng = new google.maps.LatLng(37.789879, -122.390442);
  GMap.map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 15,
    //center: centerLatLng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  
  // Create a single instance of the InfoWindow object which will be shared
  // by all Map objects to display information to the user.
  GMap.infoWindow = new google.maps.InfoWindow();
  
  // Make the info window close when clicking anywhere on the map.
  google.maps.event.addListener(GMap.map, 'click', GMap.closeInfoWindow);
  
  // Make markers on map from the selector given
  // load markers into object
  var firstPos = null;
  $(markerselector).each(function () {
      var marker = {
      obj:new google.maps.Marker({
          map: GMap.map,
          position: new google.maps.LatLng($(this).data("lat"), $(this).data("lng")),
          title: $(this).text()
      }),
      content: "<b style='font-size:14px;'>" + $(this).data("title") + "</b><br />" + $(this).text()
      };
      GMap.markers[$(this).data("id")] = marker;      
  // Register event listeners to each marker to open a shared info
  // window displaying the marker's position when clicked or dragged.
      google.maps.event.addListener(marker.obj, 'click', function() {
        GMap.openInfoWindow(marker);
      });
      if(firstPos == null) firstPos = marker.obj.getPosition();
      //{ lat:  title: $(this).data("title"), address: $(this).text() }
  });
  GMap.map.setCenter(firstPos);
   
}