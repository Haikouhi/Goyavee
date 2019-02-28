 // home

// navbar
$( ".datepicker" ).datepicker();

$('#profile_pic_mobile').on('click', function(){
    $('.menucontent').slideToggle(1000);
    $('#profile_pic_mobile').toggleClass('open');
});

$('#profile_pic_desktop').on('click', function(){
    $('.menucontent').slideToggle(1000);
    $('#profile_pic_desktop').toggleClass('open');
});

// Cookie bar
$('.cookie-btn').on('click', function(){
    $('.cookie-bar').css("display", "none");
});

//  not connected : map (home)
if (document.getElementById('macarte') !== null) {
    var coords = null;
    
    window.addEventListener('load', function(){
        if(window.jQuery){
            console.log('Le script est chargé');
        }else{
            console.log('Problème avec le script');
        }
    });
    
    
    
    /*Affichage carte*/
    
    var carte = L.map('macarte').setView([46.3630104, 2.9846608], 5);
    
    
    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(carte);
    
    
    /*Géolocalisation*/
    
    function getLocation() {
     if (navigator.geolocation) {
       navigator.geolocation.getCurrentPosition(showPosition);
    
     } else {
         alert('La géolocalisation n\'est pas fonctionnelle.');
     }
    }
    
    /*Marqueur et zoom*/
    
    function showPosition(position) {
    
        var marker = L.marker([position.coords.latitude, position.coords.longitude]);
        marker.addTo(carte);
    
        carte.setZoom(16).panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
    
        coords = position.coords;
        console.log(coords);
    
        /*carte.setZoom(16);*/

        // Changes not geolocalised to geolocalise : removing css blur and button
        if (coords !== null){
            var map = document.getElementById('macarte');
            var button = document.getElementById('btn-geo');
            
            map.classList.remove('map-blur');
            button.style.display ="none";
}
    }
} 

// map after connection 

if (document.getElementById('mapevent') !== null) {
    var mapevent = L.map('mapevent').setView([46.3630104, 2.9846608], 6);

    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(mapevent);
    var marker = L.marker([46.6835956, -0.4137665]);
    marker.addTo(mapevent);
} 
