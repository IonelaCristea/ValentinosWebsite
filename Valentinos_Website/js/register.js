// Google API serch placesSearch
$(document)ready(function(){
  var defaultBounds = new google.maps.LatLngBounds(
  new google.maps.LatLng(-33.8902, 151.1759),
  new google.maps.LatLng(-33.8474, 151.2631));

  var input = document.getElementById('placesSearch');
  var options = {
  bounds: defaultBounds,
  types: ['(regions)']
  };
  var autocomplete = new google.maps.places.Autocomplete(input, options);
});
