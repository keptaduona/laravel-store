@extends('master')

@section('content')

    <div class="contact-main container">
        <div class="col-md-8 col-sm-12" id="map"></div>
        <div class="col-md-4">
            <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Donec odio. Quisque volutpat mattis eros. Nullam malesuada erat ut turpis. Suspendisse urna nibh, viverra non, semper suscipit, posuere a, pede. Donec nec justo eget felis facilisis fermentum. Aliquam porttitor mauris sit amet orci. Aenean dignissim pellentesque felis. Morbi in sem quis dui placerat ornare. Pellentesque odio nisi, euismod in, pharetra a, ultricies in, diam. Sed arcu. Cras consequat.</p>
        </div>
    </div>

    <script>
      function initMap() {
        var uluru = {lat: 54.687302, lng: 25.280590};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 16,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBogLhyT0I2onf5KX_ZSTvglSDSXtircc&callback=initMap">
    </script>

    <style scoped>
        #map {
          height: 400px;
          background-color: grey;
        }
    </style>

@endsection
