$(document).ready(function () {
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
// if (document.getElementById('macarte') !== null) {
//     var coords = null;
    
    
    
    
//     /*Affichage carte*/
    
//     var carte = L.map('macarte').setView([46.3630104, 2.9846608], 5);
    
    
//     L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
//         attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
//     }).addTo(carte);
    
    
//     /*Géolocalisation*/
    
//     function getLocation() {
//      if (navigator.geolocation) {
//        navigator.geolocation.getCurrentPosition(showPosition);
    
//      } else {
//          alert('La géolocalisation n\'est pas fonctionnelle.');
//      }
//     }
    
//     /*Marqueur et zoom*/
    
//     function showPosition(position) {
    
//         var marker = L.marker([position.coords.latitude, position.coords.longitude]);
//         marker.addTo(carte);
    
//         carte.setZoom(16).panTo(new L.LatLng(position.coords.latitude, position.coords.longitude));
    
//         coords = position.coords;
//         console.log(coords);
    
//         /*carte.setZoom(16);*/

//         // Changes not geolocalised to geolocalise : removing css blur and button
//         if (coords !== null){
//             var map = document.getElementById('macarte');
//             var button = document.getElementById('btn-geo');
            
//             map.classList.remove('map-blur');
//             button.style.display ="none";
// }
//     }
// } 

// map after connection 

// if (document.getElementById('mapevent') !== null) {
//     var mapevent = L.map('mapevent').setView([46.3630104, 2.9846608], 6);

//     L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
//                 attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
//             }).addTo(mapevent);
//     var marker = L.marker([46.6835956, -0.4137665]);
//     marker.addTo(mapevent);
// } 

// creating an event
    // adding location
$('#btn-add-location').on('click', function(){
    $('.creating-location').css("display", "block");
});

// Profile User
    // carousel
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();

    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            } else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            } else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            } else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({
                'transform': 'translateX(0px)',
                'width': itemWidth * itemNumbers
            });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        } else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }
    
    });
    