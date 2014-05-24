/*jslint browser: true*/
/*global osm_geojson, $, L, map*/
function getURLParameter(sParam) {
    'use strict';
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
    for (i = 0; i < sURLVariables.length; i += 1) {
        sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] === sParam) {
            return sParameterName[1];
        }
    }
}

function addPolygon(data) {
    'use strict';
    var geojson = osm_geojson.osm2geojson(data), points;
    $.each(geojson.features, function (i, feature) {
        if (feature.geometry.type === 'Polygon') {
            points = [];
            $.each(feature.geometry.coordinates, function (i, coordSet) {
                $.each(coordSet, function (i, coords) {
                    points.push(L.latLng(coords[1], coords[0]));
                });
            });
            var polyline = L.polygon(points, {color: 'red'}).addTo(map);
            map.fitBounds(polyline.getBounds());
        }
    });
}

function getWay(data) {
    'use strict';
    var id = $(data).find('way').attr('id');
    if (id) {
        $.get('http://api.openstreetmap.org/api/0.6/way/' + id + '/full', addPolygon);
    }
}

function getNode(data) {
    'use strict';
    if (data[0]) {
        $.get('http://api.openstreetmap.org/api/0.6/node/' + data[0].osm_id + '/ways', getWay);
    }
}

function getNodeId(address) {
    'use strict';
    $.getJSON('http://nominatim.openstreetmap.org/search?street=' + address + '&city=Strasbourg&country=France&format=json&limit=1', getNode);
}

function initOSMInfo() {
    'use strict';
    $.getJSON('script/getAdresseFromId.php?archiIdAdresse=' + getURLParameter('archiIdAdresse'), getNodeId);
}

$(document).ready(initOSMInfo);
