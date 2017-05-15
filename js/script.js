// (function($, Drupal) {
//     $.fn.createMap = function(lat, lng) {
//
//         alert('Fduke!');
//
//         lat = typeof lat !== 'undefined' ? lat : 51;
//         lng = typeof lng !== 'undefined' ? lgn : 28;
//
//         var loc = {lat: +lat, lng: +lng};
//
//         var map = new google.maps.Map(document.getElementById('ajax_form_map'), {
//             center: loc,
//             scrollwheel: true,
//             zoom: 5
//         });
//
//         var marker = new google.map.Marker({
//             position: loc,
//             map: map
//         });
//
//     };
//
//     Drupal.behaviors.ajaxMapBehavior = {
//         attach: function (context, settings) {
//             //$(context).find('#'+'ajax_form_map').once('ajaxMapBehavior').each(function () {
//                 createMap();
//             //})
//         }
//     }
//
// })(jQuery, Drupal);

/**
 * @file
 * Attaches behaviors for the custom Google Maps.
 */

(function ($, Drupal) {

    const mapElement = 'ajax_form_map';

    /**
     * Initializes the map.
     */
    function init () {

        var point = {lat: 51, lng: 28};

        var map = new google.maps.Map(document.getElementById(mapElement), {
            center: point,
            scrollwheel: true,
            zoom: 5
        });

        var marker = new google.maps.Marker({
            position: point,
            map: map
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    }

    $.fn.changeMap = function(lat, lng) {

        var point = {lat: +lat, lng: +lng};

        var map = new google.maps.Map(document.getElementById(mapElement), {
            center: point,
            scrollwheel: true,
            zoom: 5
        });

        var marker = new google.maps.Marker({
            position: point,
            map: map
        });
        marker.addListener('click', function() {
            infowindow.open(map, marker);
        });
    };

    $.fn.reloadTable = function(data) {
        console.log(data);
        var tbody = document.getElementById("reloadTable__tbody");

        tbody.innerHTML = '';

        for (var i = 0; i < data.length; i++) {
            var id = data[i].id;
            var lat = data[i].latitude;
            var lng = data[i].longitude;

            var tr = document.createElement("tr");

            var idCell = document.createElement("td");
            var latCell = document.createElement("td");
            var lngCell = document.createElement("td");

            idCell.appendChild(document.createTextNode(id));
            latCell.appendChild(document.createTextNode(lat));
            lngCell.appendChild(document.createTextNode(lng));

            tr.appendChild(idCell);
            tr.appendChild(latCell);
            tr.appendChild(lngCell);

            tbody.appendChild(tr);
        }
    };

    $.fn.node = function(f, s) {
        alert(f+ ' ' +s);
    };

    Drupal.behaviors.ajaseBehavior = {
        attach: function (context, settings) {
            $(context).find('#'+mapElement).once('ajaseBehavior').each(function () {
                //init();
                init();
            });
            //init();
        }
    }

})(jQuery, Drupal);

