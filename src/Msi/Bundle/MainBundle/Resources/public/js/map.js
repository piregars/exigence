function init()
{
    var map = new google.maps.Map(document.getElementById('mapCanvas'), {
        zoom: 15,
        center: new google.maps.LatLng(45.5750095, -73.54818290000003),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(45.5750095, -73.54818290000003),
        map: map,
        title: 'Groupe MSI'
    });
}
google.maps.event.addDomListener(window, 'load', init);
