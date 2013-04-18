jQuery(document).ready(function(){
  var geocoder;
  var city = {
    home: new google.maps.LatLng(49.3974171, -123.5152222),
    vancouver: new google.maps.LatLng(49.261226, -123.1139268),
    sechelt: new google.maps.LatLng(49.4741736, -123.7545601)
  };

  locations = null;

  initialize();
  
  function initialize() {
    var tags = {
      recommend: "recommended tag",
      mustgo: "mustgo tag",
      popular: "popular tag"
    };

    /**
    * Enter specific address for each flag
    * Name, Geocode location, zIndex order, # of stars
    */
    var beaches = [
      ['Vancouver', 49.261226, -123.1139268, 4, "one", "http://farm4.static.flickr.com/3212/3012579547_097e27ced9_m.jpg", tags.recommend],
      ['Sechelt', 49.4741736, -123.7545601, 5, "three", "http://farm4.static.flickr.com/3212/3012579547_097e27ced9_m.jpg", tags.popular], 
      ['Gibsons', 49.3974171, -123.5152222, 6, "two", "http://farm4.static.flickr.com/3212/3012579547_097e27ced9_m.jpg"], 
      ['Roberts Creek', 49.424157, -123.64758, 3, "two", "http://farm4.static.flickr.com/3212/3012579547_097e27ced9_m.jpg", tags.mustgo], 
      ['Royal Reach Marina', 49.4798898, -123.7566687, 3, "two", "http://farm4.static.flickr.com/3212/3012579547_097e27ced9_m.jpg", tags.recommend] 
    ];



    geocoder = new google.maps.Geocoder();
    var mapOptions = {
      zoom: 10,
      center: new google.maps.LatLng(49.261226, -123.1139268),
      mapTypeId: google.maps.MapTypeId.ROADMAP, 
      mapTypeControlOptions: {
        style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
        position: google.maps.ControlPosition.TOP_CENTER
      },
    }
    var map = new google.maps.Map(document.getElementById('map_canvas'),
                                  mapOptions);

    // Create the DIV to hold the control and
    // call the HomeControl() constructor passing
    // in this DIV.
    var homeControlDiv = document.createElement('div');
    // homeControl = new HomeControl(homeControlDiv, "热门城市", null, null, map);
    // homeControl2 = new HomeControl(homeControlDiv, "名山明水", null, null, map);
    // homeControl3 = new HomeControl(homeControlDiv, "幽雅古镇", null, null, map);
    // homeControl4 = new HomeControl(homeControlDiv, "海滨海岛", null, null, map);


    homeControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);

    var cityControlDiv = document.createElement('div');
    // homeControl = new HomeControl(cityControlDiv, "Home", city.home, 10, map);
    // cityControl = new HomeControl(cityControlDiv, "Vancouver", city.vancouver, 13, map);
    // cityControl2 = new HomeControl(cityControlDiv, "Sechelt", city.sechelt, 16, map);

    cityControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.BOTTOM_CENTER].push(cityControlDiv);

    var map_canvas = $("#map_canvas");
    var cat_id = map_canvas.attr("cat_id");
    var sort_type = map_canvas.attr("sort_type");
    var items = map_canvas.attr("items");
    
    getMapData(map, cat_id, sort_type, items);
  }

  /**
   * The HomeControl adds a control to the map that simply
   * returns the user to Chicago. This constructor takes
   * the control DIV as an argument.
   */

  function HomeControl(controlDiv, text, location, zoom, map) {

    // Set CSS styles for the DIV containing the control
    // Setting padding to 5 px will offset the control
    // from the edge of the map
    controlDiv.style.padding = '5px';

    // Set CSS for the control border
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = 'white';
    controlUI.style.borderStyle = 'solid';
    controlUI.style.borderWidth = '1px';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click to set the map to Home';
    controlDiv.appendChild(controlUI);

    // Set CSS for the control interior
    var controlText = document.createElement('div');
    controlText.style.fontFamily = 'Arial,sans-serif';
    controlText.style.fontSize = '18px';
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';
    controlText.innerHTML = text;
    controlUI.appendChild(controlText);

    // Setup the click event listeners: simply set the map to
    google.maps.event.addDomListener(controlUI, 'click', function() {
      map.setCenter(location);
      map.setZoom(zoom);
    });

  }

  function setMarkers(map, locations) {
    // Add markers to the map

    // Marker sizes are expressed as a Size of X,Y
    // where the origin of the image (0,0) is located
    // in the top left of the image.

    // Origins, anchor positions and coordinates of the marker
    // increase in the X direction to the right and in
    // the Y direction down.
    var image = new google.maps.MarkerImage('images/beachflag.png',
        // This marker is 20 pixels wide by 32 pixels tall.
        new google.maps.Size(20, 32),
        // The origin for this image is 0,0.
        new google.maps.Point(0,0),
        // The anchor for this image is the base of the flagpole at 0,32.
        new google.maps.Point(0, 32));
    var shadow = new google.maps.MarkerImage('images/beachflag_shadow.png',
        // The shadow image is larger in the horizontal dimension
        // while the position and offset are the same as for the main image.
        new google.maps.Size(37, 32),
        new google.maps.Point(0,0),
        new google.maps.Point(0, 32));
        // Shapes define the clickable region of the icon.
        // The type defines an HTML <area> element 'poly' which
        // traces out a polygon as a series of X,Y points. The final
        // coordinate closes the poly by connecting to the first
        // coordinate.
    var shape = {
        coord: [1, 1, 1, 20, 18, 20, 18 , 1],
        type: 'poly'
    };
    for (var i = 0; i < locations.length; i++) {
      var post_title = locations[i].post_title;
      var address = locations[i].meta_value;

//      var myLatLng = new google.maps.LatLng(loc[1], loc[2]);
      var myLatLng = codeAddress(address);
      var marker = new RichMarker({
        position: myLatLng,
        map: map,
        shadow: false,
        draggable: false,
        content: '<div class="marker"><span class="test"></span><span class="carat"></span><div class="thumbnail">' +
        '<img src=""/></div><div class="name">'+ post_title +'</div></div>'
        });

      google.maps.event.addDomListener(marker, 'click', function() {
        $(".content", this.markerContent_).show();
        $(".marker", this.markerContent_).toggleClass( "expanded", 500 );
        //debugger;
        //toggleMarker(this.markerContent_);
      });
    }
  }

  function toggleMarker( marker ){
    $(marker).toggleClass( "expanded", 1000 );
  }

  //Converts string address to latlng 
  function codeAddress( address ) {
    var address_arr = address.split(',');
    var lat = address_arr[0];
    var lng = address_arr[1];
    return new google.maps.LatLng(lat, lng);
  } 

  function getMapData( map, cat_id, sort_type, items ) {
      var data = {
        action: 'get_nice_map_data',
        cat_id: cat_id,
        sort_type: sort_type,
        items: items
      };
      jQuery.post(NiceMapWidget.ajaxurl, data, function(response){ handleMapCallback(map, response); });
  }

  function handleMapCallback( map, response ) {

    var map_response = jQuery.parseJSON(response);

    if ( map_response.status == 1 ) {
      //Success, proceed to display
      setMarkers(map, map_response.response);
    } else {
      //Failure, notify user
      if ( map_response.message  != null ) { 
        //alert( map_response.message ); 
      }
    }
  }



});