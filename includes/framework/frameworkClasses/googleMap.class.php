<?php
/**
 * Classe GoogleMap
 * 
 * PHP Version 5.3.3
 * 
 * @category Class
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @author   Partenaire Immobilier <contact@partenaireimmo.com>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * 
 * */

/**
 * Classe pour gérer l'affichage des cartes
 * 
 * PHP Version 5.3.3
 * 
 * @category Class
 * @package  ArchiWiki
 * @author   Pierre Rudloff <contact@rudloff.pro>
 * @author   Laurent Dorer <laurent_dorer@yahoo.fr>
 * @author   Partenaire Immobilier <contact@partenaireimmo.com>
 * @license  GNU GPL v3 https://www.gnu.org/licenses/gpl.html
 * @link     https://archi-strasbourg.org/
 * */
class GoogleMap extends config
{
    var $googleMapNameId;
    var $googleMapKeyProperty;
    var $googleMapWidth;
    var $googleMapHeight;
    var $coordonnees;
    var $markerOnClickType;
    var $setTimeOutPaquets;
    var $debugMode;
    var $googleMapZoom;
    var $divStyle;
    var $mapType;
    
    var $centerLong;
    var $centerLat;
    
    
    var $noDisplayZoomSelectionSquare;
    var $zoomType;
    var $noDisplayEchelle;
    var $noDisplayMapTypeButtons;
    var $noDisplayMiniZoom;
    
    /**
     * Constructeur de la classe GoogleMap
     * 
     * @param array $params Paramètres
     * 
     * @return void
     * */
    function __construct($params=array())
    {
        $this->noDisplayZoomSelectionSquare=false;
        $this->noDisplayZoomSlider=false;
        $this->zoomType = '';
        $this->noDisplayEchelle=false;
        $this->noDisplayMapTypeButtons=false;
                
        parent::__construct();
        if (isset($params['googleMapNameId']) && $params['googleMapNameId']!='') {
            $this->googleMapNameId = $params['googleMapNameId'];
        } else {
            $this->googleMapNameId='divMap';
        }
        
        if (isset($params['mapType']) && $params['mapType']!='') {
            $this->mapType=$params['mapType'];
        } else {
            $this->mapType='';
        }
        
        
        if (isset($params['height']) && $params['height']!='') {
            $this->googleMapHeight = $params['height'];
        } else {
            $this->googleMapHeight = '300';
        }
        
        if (isset($params['divStyle']) && $params['divStyle']!='') {
            $this->divStyle=$params['divStyle'];
        } else {
            $this->divStyle='';
        }
        
        if (isset($params['width']) && $params['width']!='') {
            $this->googleMapWidth = $params['width'];
        } else {
            $this->googleMapWidth = '500';
        }
        
        if (isset($params['setOnClickType']) && $params['setOnClickType']!='') {
            $this->markerOnClickType = $params['setOnClickType'];
        } else {
            $this->markerOnClickType = 'link';
        }
        
        if (isset($params['setTimeOutPaquets'])
            && $params['setTimeOutPaquets']!=''
        ) {
            $this->setTimeOutPaquets = $params['setTimeOutPaquets'];
        } else {
            $this->setTimeOutPaquets = 5000;
        }
        
        if (isset($params['debugMode']) && $params['debugMode']==true) {
            $this->debugMode = true;
        } else {
            $this->debugMode = false;
        }
        
        if (isset($params['zoom']) && $params['zoom']!='') {
            $this->googleMapZoom = $params['zoom'];
        } else {
            $this->googleMapZoom = 10;
        }
        
        if (isset($params['noDisplayZoomSelectionSquare'])
            && $params['noDisplayZoomSelectionSquare']==true
        ) {
            $this->noDisplayZoomSelectionSquare=true;
        }
        
        if (isset($params['noDisplayZoomSlider'])
            && $params['noDisplayZoomSlider']==true
        ) {
            $this->noDisplayZoomSlider=true;
        }
        
        if (isset($params['noDisplayEchelle'])
            && $params['noDisplayEchelle']==true
        ) {
            $this->noDisplayEchelle=true;
        }
                
        if (isset($params['noDisplayMapTypeButtons'])
            && $params['noDisplayMapTypeButtons']==true
        ) {
            $this->noDisplayMapTypeButtons=true;
        }
        
        if (isset($params['zoomType']) && $params['zoomType']!='') {
            $this->zoomType=$params['zoomType'];
        }
        
        
        if (isset($params['centerLong']) && isset($params['centerLat'])) {
            $this->centerLong = $params['centerLong'];
            $this->centerLat = $params['centerLat'];
        } else {
            $this->centerLong = "7.7400"; // on centre sur strasbourg par defaut
            $this->centerLat = "48.585000";
        }
                
        $this->googleMapKeyProperty = $params['googleMapKey'];
        $this->coordonnees = array();
    }
    
    /**
     * Ajouter une adresse ?
     * 
     * @param array $params Paramètres
     * 
     * @return void
     * */
    function addAdresse($params=array())
    {
        $index = count($this->coordonnees);
        
        if (isset($params['adresse']) && $params['adresse']!='') {
            $this->coordonnees[$index]['adresse'] = $params['adresse'];
        } else {
            $this->coordonnees[$index]['adresse'] = '';
        }
        
        if (isset($params['link']) && $params['link']!='') {
            $this->coordonnees[$index]['link'] = $params['link'];
        } else {
            $this->coordonnees[$index]['link']='';
        }
        
        if (isset($params['imageFlag']) && $params['imageFlag']!='') {
            $this->coordonnees[$index]['imageFlag']=$params['imageFlag'];
        } else {
            $this->coordonnees[$index]['imageFlag']='';
        }
        
        if (isset($params['longitude']) && $params['longitude']!=''
            && isset($params['latitude']) && $params['latitude']!=''
        ) {
            $this->coordonnees[$index]['longitude'] = $params['longitude'];
            $this->coordonnees[$index]['latitude'] = $params['latitude'];
        }
        
        if (isset($params['setImageWidth'])) {
            $this->coordonnees[$index]['imageWidth'] = $params['setImageWidth'];
        }
        
        if (isset($params['setImageHeight'])) {
            $this->coordonnees[$index]['imageHeight'] = $params['setImageHeight'];
        }
        
        if (isset($params['pathToImageFlag']) && $params['pathToImageFlag']!='') {
            $this->coordonnees[$index]['pathToImageFlag']=$params['pathToImageFlag'];
        } else {
            $this->coordonnees[$index]['pathToImageFlag']='';
        }
    }
    
    /**
     * ?
     * 
     * @return string HTML
     * */
    public function getHtmlFromAdresses()
    {   
        $html="<div id='".$this->googleMapNameId."' style='width: ".
        $this->googleMapWidth."px; height: ".$this->googleMapHeight.
        "px;'></div>";
    
        $html.="<script  >";

        if (count($this->coordonnees)>0) {
            foreach ($this->coordonnees as $indice => $value) {
                if (isset($value['link'])) {
                    $html.="tabAdresses[".$indice."]=\"".$value['link']."\";\n";
                }
            }
        }
        
        $html.="</script>";
        
        if ($this->debugMode) {
            $displayDebug='block';
        } else {
            $displayDebug='none';
        }
            
        $html.="<script>load();</script>";
        
        /* fonction appelant les affichages de coordonnées,
         * appels regroupées dans une fonction
         * qui groupe les coordonnées par paquet,
         * afin de ne pas trop en envoyer a la fois
         * */
        if (count($this->coordonnees)>0) {
            $html.="<script>";
            $html.="var numPaquet=0;\n";
            $html.="var timer;\n";
            $html.="startTimerPaquets();\n";
            $html.="function startTimerPaquets()\n";
            $html.="{";
            $html.="afficheCoordonneesParPaquets();\n";
            $html.="timer = setInterval(\"afficheCoordonneesParPaquets()\", ".
            $this->setTimeOutPaquets.");\n";
            $html.="}\n";
            
            $html.="function afficheCoordonneesParPaquets(){\n";
            $i=0;
            $numPaquet = 0;
            foreach ($this->coordonnees as $indice => $value) {
                $image = ", \"https://www.google.com/mapfiles/marker.png\"";//
                if (isset($value['imageFlag']) && $value['imageFlag']!='') {
                    $image = ", \"".$value['imageFlag']."\"";
                }
                
                if ($i%10==0) {
                    $html.="if (numPaquet==".$numPaquet.")\n";
                    $html.="{\n";
                    $iDebut = $i;
                }
                
                $html.=" getCoordonnees(\"".$value['adresse']."\", ".
                $indice." ".$image.");\n";
                
                if ($i==$iDebut+9 || $i==count($this->coordonnees)-1 ) {
                    $html.="}\n";
                    $numPaquet++;
                }
                $i++;
            }
            

            $html.="if (numPaquet>".$numPaquet.")\n";
            $html.="{\n";
            $html.="clearInterval(timer);\n";
            $html.="}\n";
            $html.="numPaquet++;\n";
            $html.="}\n";
            $html.="</script>";
        }
        

        
        if ($this->debugMode) {
            $displayDebug='block';
        } else {
            $displayDebug='none';
        }
        
        $html.="<div style='width:500px; height:300px;overflow:scroll;display:".
        $displayDebug.";' id='debugGoogleMap'></div>";
        return $html;
    }
    
    
    
    /**
     * Même fonction que la precedente,
     * mais celle ci fonctionne a partir des coordonnees geographiques
     * plutot que l'adresse
     * Récuperation des coordonnées par une boucle sur la fonction addAdresse
     * 
     * @return string HTML
     * */
    public function getHtmlFromAdressesNoPauseWithGeoLocalization()
    {   
        $html="<div id='".$this->googleMapNameId."' style='width: ".
        $this->googleMapWidth."px; height: ".$this->googleMapHeight."px;'></div>";
    
        $html.="<script  >";

        /*if (count($this->coordonnees)>0) {
            foreach ($this->coordonnees as $indice => $value) {
                if (isset($value['link'])) {
                    $html.="tabAdresses[".$indice."]=\"".$value['link']."\";\n";
                }
            }
        }*/
        
        $html.="</script>";
        
        if ($this->debugMode) {
            $displayDebug='block';
        } else {
            $displayDebug='none';
        }
            
        $html.="<script>load();</script>";
        
        
        $html.="<script>";
        foreach ($this->coordonnees as $indice => $values) {
            if (isset($values['latitude']) && $values['latitude']!=''
                && isset($values['longitude']) && $values['longitude']!=''
            ) {
                $urlImage = $values['imageFlag'];
                if (!isset($values['imageHeight'])
                    && !isset($values['imageWidth'])
                ) {
                    list($imageSizeX,  $imageSizeY,  $typeImage,  $attrImage)
                        = getimagesize($values['pathToImageFlag']);
                } else {
                    $imageSizeX = $values['imageWidth'];
                    $imageSizeY = $values['imageHeight'];
                }
                    
                $html.="
                  
                    var iconMarker = L.marker();";
            
            
            
                $html.="
                    
                    point$indice = L.latLng(".$values['latitude'].
                    ", ".$values['longitude'].");
                    marker$indice = L.marker(point$indice, {icon: icon});
                    marker$indice.addTo(markers);
                    //marker$indice.openInfoWindowHtml(\"".$values['link']."\");
                    
                    ";
                
                $html.="
                    function onClickFunction$indice(overlay,
                    point){marker$indice.openInfoWindowHtml(\"".
                    $values['link']."\");}";
                
                $html.="marker$indice.addEventListener('click',
                onClickFunction$indice);";
            }

                
        }
        
        $html.="</script>";
        

        
        if ($this->debugMode) {
            $displayDebug='block';
        } else {
            $displayDebug='none';
        }
        
        $html.="<div style='width:500px; height:300px;overflow:scroll;display:".
        $displayDebug.";' id='debugGoogleMap'></div>";
        return $html;
    }
    
    
    
    /**
     * Affiche la carte
     * Si l'on veut rajouter des evenements a cette carte,
     * il faut ajouter le code des evenements apres l'appel a cette fonction,
     * car c'est ici que l'on cree "map"
     * 
     * @return string HTML
     * */
    public function getHTML()
    {
    
        $html="<div id='".$this->googleMapNameId."' style='width: ".
        $this->googleMapWidth."px; height: ".$this->googleMapHeight.
        "px; ".$this->divStyle.
        "'>Veuilliez patienter pendant le chargement de la carte...</div>";
    
    
        $html.="<script  >load();</script>";
        $html.="<script  >";
        if (isset($params['urlImageIcon']) && isset($params['pathImageIcon'])) {
            $urlImage = $params['urlImageIcon'];

            list($imageSizeX,  $imageSizeY,  $typeImage,  $attrImage)
                = getimagesize($params['pathImageIcon']);
            
            $html.="
                var icon = L.icon();
               
                var iconMarker = L.marker();
            ";
        } else {
            $html.="
               
                icon.infoWindowAnchor = L.marker();
            ";
        }
        $html.="</script>";
        
        if (isset($params['listeCoordonnees'])) {
            $html.="<script  >";
            foreach ($params['listeCoordonnees'] as $indice => $values) {
                $html.="
                
                    point$indice = L.latLng(".$values['latitude'].
                    ", ".$values['longitude'].");
                    marker$indice = L.marker(point$indice, {icon: icon});
                    overlay$indice = map.addOverlay(marker$indice);
                    //marker$indice.openInfoWindowHtml(\"".$values['libelle']."\");
                    
                    ";
                
                if (isset($values['jsCodeOnClickMarker'])) {
                    $html.="
                            function onClickFunction$indice(overlay,
                            point){".$values['jsCodeOnClickMarker']."}";
                
                    $html.="marker$indice.addListener('click',
                    onClickFunction$indice);";
                }
                
               
                
            }
            $html.="</script>";
        }
        
        
        
        return $html;
    }
    
    /**
     * ?
     * 
     * @param array $params Paramètres
     * 
     * @return string HTML
     * */
    public function getJsFunctions($params=array())
    {
        $html="";
        
        $urlImage = "https://labs.google.com/ridefinder/images/mm_20_red.png";
        $imageSizeX = "24";
        $imageSizeY = "30";

        $html.="
        <link rel='stylesheet' href='js/leaflet/leaflet.css' />
        <script src='js/leaflet/leaflet.js'></script>
        <script src='js/leaflet/Polyline.encoded.js'></script>
        <script>
                var map, markers, icon = L.icon({iconUrl: 'images/pointGM.png'});
                var geocoder;
                var tabAdresses = new Array();
                

                // addAddressToMap() is called when the geocoder returns an
                // answer.  It adds a marker to the map with an open info window
                function addAddressToMap(response) {

                    if (!response || response.Status.code != 200) {
                        alert('L\'adresse n'est pas correcte.'
                        + 'Exemple : 22 rue de bâle strasbourg,  france');
                    } 
                    else {
                        place = response.Placemark[0];
                        point = L.latLng(place.Point.coordinates[1],
                        place.Point.coordinates[0]);
                        marker = L.marker(point);
                        map.addOverlay(marker);
                        marker.openInfoWindowHtml(place.address + '<br>'
                        + '<b>Country code:</b> ' +
                        place.AddressDetails.Country.CountryNameCode);
                    }

                }

                // showLocation() is called when you click on the Search button
                // in the form.  It geocodes the address entered into the form
                // and adds a marker to the map at that location.
                function showLocation() {
                    var address = document.forms[0].q.value;
                    geocoder.getLocations(address,  addAddressToMap);
                }

                function findLocation(address) {
                    document.forms[0].q.value = address;
                    showLocation();
                }

                function createMarker(point,  index, image) {
                  // Create a lettered icon for this point using our icon class

                  var letter = String.fromCharCode(\"A\".charCodeAt(0) + index);
                  icon.image = image;
                  var iconMarker = L.marker(icon);
                  
                  var marker = new L.marker(point,  {icon: iconMarker});
                    
                  GEvent.addListener(marker, \"click\", function(){
                    
                    marker.openInfoWindowHtml(tabAdresses[index]);
                    
                  });
                  /*
                  marker.addEventListener(\"click\",  function() {
                ";  
        switch($this->markerOnClickType) {
        case 'alert':
            $html.="alert(tabAdresses[index]); ";
            break;
        case 'link':
        default:
            $html.="location.href = tabAdresses[index]; ";
            break;
        }
            
            $html.="      
                  });
                  */
                  return marker;
                }

                function getCoordonnees(address,  index, image) {
                  geocoder.getLatLng(
                    address, 
                    function(point) {
                      if (!point) {
                        document.getElementById('debugGoogleMap').innerHTML+=
                        address + \" not found<br>\";
                      } else {
                        document.getElementById('debugGoogleMap').innerHTML+=
                        address + \"<img src='\"+image+\"'><br>\";
                        map.addOverlay(new createMarker(point,  index, image));
                      }
                    }
                  );
                }               
                </script>";
        
            // GZoom
            $html.="<script>
            function GZoomControl(oBoxStyle, oOptions, oCallbacks) {
    //box style options
  GZoomControl.G.style = {
    nOpacity:.2, 
    sColor:\"#000\", 
    sBorder:\"2px solid blue\"
  };
  var style=GZoomControl.G.style;
  for (var s in oBoxStyle) {style[s]=oBoxStyle[s]};
  var aStyle=style.sBorder.split(' ');
  style.nOutlineWidth=parseInt(aStyle[0].replace(/\D/g, ''));
  style.sOutlineColor=aStyle[2];
  style.sIEAlpha='alpha(opacity='+(style.nOpacity*100)+')';
    
    // Other options
    GZoomControl.G.options={
        bForceCheckResize:false, 
        sButtonHTML:'zoom ...', 
        oButtonStartingStyle:{width:'52px', border:'1px solid black',
        padding:'0px 5px 1px 5px'}, 
        oButtonStyle:{background:'#FFF'}, 
        sButtonZoomingHTML:'Drag a region on the map', 
        oButtonZoomingStyle:{background:'#FF0'}, 
        nOverlayRemoveMS:6000, 
        bStickyZoom:false
    };
    
    for (var s in oOptions) {GZoomControl.G.options[s]=oOptions[s]};
    
    // callbacks: buttonClick,  dragStart, dragging,  dragEnd
    if (oCallbacks == null) {oCallbacks={}};
    GZoomControl.G.callbacks=oCallbacks;
}

/* alias get element by id */
function \$id(sId) { return document.getElementById(sId); }
/* utility functions in acl namespace */
if (!window['acldefined']) {var acl={};window['acldefined']=true;}

/* A general-purpose function to get the absolute position of
the mouse */
acl.getMousePosition=function(e) {
    var posx = 0;
    var posy = 0;
    if (!e) var e = window.event;
    if (e.pageX || e.pageY) {
        posx = e.pageX;
        posy = e.pageY;
    } else if (e.clientX || e.clientY){
        posx = e.clientX + (document.documentElement.scrollLeft?
        document.documentElement.scrollLeft:document.body.scrollLeft);
        posy = e.clientY + (document.documentElement.scrollTop?
        document.documentElement.scrollTop:document.body.scrollTop);
    }   
    return {left:posx,  top:posy};  
};

/*
To Use: 
    var pos = acl.getElementPosition(element);
    var left = pos.left;
    var top = pos.top;
*/
acl.getElementPosition=function(eElement) {
  var nLeftPos = eElement.offsetLeft;       
    var nTopPos = eElement.offsetTop;       
    var eParElement = eElement.offsetParent;    
    while (eParElement != null ) {               
        nLeftPos += eParElement.offsetLeft;      
        nTopPos += eParElement.offsetTop;  
        eParElement = eParElement.offsetParent; 
    }
    return {left:nLeftPos,  top:nTopPos};
};
//elements is either a coma-delimited list of ids or an array of DOM objects.
//o is a hash of styles to be applied
//example: style('d1, d2', {color:'yellow'});  
acl.style=function(a, o){
    if (typeof(a)=='string') {a=acl.getManyElements(a);}
    for (var i=0;i<a.length;i++){
        for (var s in o) { a[i].style[s]=o[s];}
    }
};
acl.getManyElements=function(s){        
    t=s.split(', ');
    a=[];
    for (var i=0;i<t.length;i++){a[a.length]=\$id(t[i])};
    return a;
};

        
        function load() {
        //if (GBrowserIsCompatible()) {\n
        
            var BingLayer = L.TileLayer.extend({
            getTileUrl: function (tilePoint) {
                this._adjustTilePoint(tilePoint);
                return L.Util.template(this._url, {
                    s: this._getSubdomain(tilePoint),
                    q: this._quadKey(tilePoint.x, tilePoint.y, this._getZoomForUrl())
                });
            },
            _quadKey: function (x, y, z) {
                var quadKey = [];
                for (var i = z; i > 0; i--) {
                    var digit = '0';
                    var mask = 1 << (i - 1);
                    if ((x & mask) != 0) {
                        digit++;
                    }
                    if ((y & mask) != 0) {
                        digit++;
                        digit++;
                    }
                    quadKey.push(digit);
                }
                return quadKey.join('');
            }
        });

        var bing = new BingLayer(
            'http://t{s}.tiles.virtualearth.net/tiles/a{q}.jpeg?g=1398', {
            subdomains: ['0', '1', '2', '3', '4'],
            attribution: '&copy; <a href=\"http://bing.com/maps\">Bing Maps</a>'
        });
            map = new L.map('".$this->googleMapNameId.
            "').setView(L.latLng(".$this->centerLat.", ".$this->centerLong.
            "),  ".$this->googleMapZoom.");
            markers = L.layerGroup().addTo(map);
            bing.addTo(map);
            var OSM = L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution:
                '&copy; <a href=\'http://osm.org/copyright\'>OpenStreetMap</a>'
            });

            L.control.layers({'Vue aérienne': bing, 'Plan': OSM}).addTo(map);
            ";

        if (isset($params['jsOnLoad'])) {
            $html.=$params['jsOnLoad'];
        }
        $html.="
        //}\n
        }</script>";    
       
        
        
        
        
        
        return $html;
    }
    
    /**
     * Attention que tout soit bien initialisé avant d'appeler cette fonction !
     * 
     * @param array $params Paramètres
     * 
     * @return string HTML
     * */
    public function setOnClickEvent($params = array())
    {
        // ajoute un evenement
        $html="<script langage='javascript'>";
        
        if (isset($params['jsCode'])) {
            //$html.="function onClickFunction(overlay,  point)";
            $html.="map.addEventListener('click',
            function(overlay,  point){if (point){".$params['jsCode']."}});";
        } else {
            /* fonctions permettant de renvoyer l'adresse a partir du point
             * cliqué sur la carte,
             * on enleve le numero de l'adresse par javascript
             * pour n'avoir que la rue
             * */
            $html.=" 
                function IsNumeric(input) {
                   return (input - 0) == input && input.length > 0;
                }

                function convertToUrlAdressSeach(str) {                   
                    var stop = false;
                    var posIni=0;
                    i=0;
                    if (IsNumeric(str.charAt(0)))
                    {
                        for(i=0; i<str.length && !stop ; i++)
                        {
                            if ( str.charAt(i)==' ')
                            {   
                                stop=true;
                                posIni = i;
                            
                            }
                        }
                    }
                
                    return str.substring(i, str.length);
                }
                
                
                function showAddress(response) {
                  map.clearOverlays();
                  if (!response || response.Status.code != 200) {
                    alert('Status Code:' + response.Status.code);
                  } else {
                    place = response.Placemark[0];
                    point = L.latLng(place.Point.coordinates[1],
                    place.Point.coordinates[0]);
                    marker = new L.marker(point);
                    map.addOverlay(marker);
                    marker.openInfoWindowHtml(
                        '<b>orig latlng:</b>' + response.name + '<br/>' + 
                        '<b>latlng:</b>'
                        + place.Point.coordinates[1] + ', '
                        + place.Point.coordinates[0] + '<br>' +
                        '<b>Status Code:</b>'
                        + response.Status.code + '<br>' +
                        '<b>Status Request:</b>'
                        + response.Status.request + '<br>' +
                        '<b>Address:</b>'
                        + place.address + '<br>' +
                        '<b>Accuracy:</b>'
                        + place.AddressDetails.Accuracy + '<br>' +
                        '<b>Country code:</b> '
                        + place.AddressDetails.Country.CountryNameCode);
                        
                        ".$params['jsAction']."                        
                        
                        
                  }
                }
            
            
                map.disableDoubleClickZoom();
                GEvent.addListener(map,  'click',  function(overlay,  point){\n
                map.clearOverlays();\n
                if (point) {\n
                L.marker(point).addTo(markers);\n
                map.panTo(point);\n
                document.getElementById('debug').value
                = point.lat() + ' ' + point.lng();\n
                geocoder.getLocations(point,  showAddress);
                
                

            }});";
        }   
        

        $html.="</script>";
        return $html;
    }
    
    /**
     * Ceci est utile quand on utilise pas la fonction load
     * qui permet d'afficher une carte,
     * ici on affiche pas de carte, on se sert juste de l'API Google Maps
     * 
     * @return string HTML
     * */
    public function getJSInitGeoCoder()
    {
        return "<script>geocoder = new GClientGeocoder();</script>";
    }
    

    /**
     * Cette fonction permet de recuperer les longitudes et latitudes
     * d'une adresse ( elle gere plusieurs appels differents
     * grace a l'identifiant qui peut etre passé en parametre)
     * Elle renvoi la fonction recuperant les coordonnées
     * et la ligne qui appelle cette fonction,
     * cette ligne peut etre placée sur un bouton ou executée
     * directement dans le code entourée des balises de script
     * 
     * @param array $params Paramètres
     * 
     * @return array
     * */
    public function getJSRetriveCoordonnees($params=array())
    {
        if (isset($params['identifiant'])) {
            $identifiant = $params['identifiant'];
        } else {
            $identifiant = '';
        }
        
        if (isset($params['adresse'])) {
            $adresse = $params['adresse'];
        } else {
            $adresse = '';
        }
        
        if (isset($params['nomChampLatitudeRetour'])) {
            $nomChampLatitudeRetour = $params['nomChampLatitudeRetour'];
        } else {
            $nomChampLatitudeRetour = "latitude";
        }
        
        if (isset($params['nomChampLongitudeRetour'])) {
            $nomChampLongitudeRetour = $params['nomChampLongitudeRetour'];
        } else {
            $nomChampLongitudeRetour = "longitude";
        }
            
        if (isset($params['getAdresseFromElementById'])
            && $params['getAdresseFromElementById']==true
        ) {
            $location = $params['jsAdresseValue'];
        } else {
            $location = "\\\"".$adresse."\\\"";
        }
        
        $jsIfOK="";
        if (isset($params['jsToExecuteIfOK'])) {
            $jsIfOK= $params['jsToExecuteIfOK'];
        }
        
        $jsIfNoAddressFound="";
        if (isset($params['jsToExecuteIfNoAddressFound'])) {
            $jsIfNoAddressFound = $params['jsToExecuteIfNoAddressFound'];
        }
        
        
        $fonction =  "<script>

                function getPointGMFrameWork".$identifiant."(response) {
                    if (response.Status.code != 200) 
                    {
                        $jsIfNoAddressFound
                    }
                    else 
                    {
                        place = response.Placemark[0];
                        document.getElementById(
                        '$nomChampLatitudeRetour$identifiant').value
                        = place.Point.coordinates[1];
                        document.getElementById(
                        '$nomChampLongitudeRetour$identifiant').value
                        = place.Point.coordinates[0];
                        $jsIfOK
                            
                    }
                }               
            </script>";
        
        $appelFonction="geocoder.getLocations($location,
        getPointGMFrameWork".$identifiant.");";
        
        return array('jsFunctionToExecute'=>$fonction,
        'jsFunctionCall'=>$appelFonction);
    }
    
    
    /**
     * Même fonction que la precedente mais permet de rapatrier plusieurs adresses
     * 
     * @param array $params       Paramètres
     * @param array $configFields ?
     * 
     * @return array
     * */
    public function getJSMultipleRetriveCoordonnees(
        $params=array(), $configFields = array()
    ) {
        if (isset($params['identifiant'])) {
            $identifiantUniqueFonction = $params['identifiant'];
        } else {
            $identifiantUniqueFonction = '';
        }
        
        $jsIfOK="";
        if (isset($params['jsToExecuteIfOK'])) {
            $jsIfOK= $params['jsToExecuteIfOK'];
        }
        
        $jsIfNoAddressFound="";
        if (isset($params['jsToExecuteIfNoAddressFound'])) {
            $jsIfNoAddressFound = $params['jsToExecuteIfNoAddressFound'];
        }
        
        
        $fonction =  "<script>";
        $fonction.= "var erreurGetGoogleMap = 0;";
        $fonction.= "var trouveGetGoogleMap = 0;";
        foreach ($configFields as $identifiant => $values) {
            if (isset($values['nomChampLatitudeRetour'])) {
                $nomChampLatitudeRetour = $values['nomChampLatitudeRetour'];
            } else {
                $nomChampLatitudeRetour = "latitude";
            }
            
            if (isset($values['nomChampLongitudeRetour'])) {
                $nomChampLongitudeRetour = $values['nomChampLongitudeRetour'];
            } else {
                $nomChampLongitudeRetour = "longitude";
            }

            if (isset($values['adresse'])) {
                $adresse = $values['adresse'];
            } else {
                $adresse = '';
            }
                
            $fonction.="
            

            
            
                function getPointGMFrameWork".$identifiantUniqueFonction
                ."_".$identifiant."(response) {

                        if (response.Status.code == 200)
                        {
                            place = response.Placemark[0];
                            document.getElementById('$nomChampLatitudeRetour').value
                            = place.Point.coordinates[1];
                            document.getElementById('$nomChampLongitudeRetour').value
                            = place.Point.coordinates[0];
                            trouveGetGoogleMap++;
                        }
                }";
        }
        
        $fonction.="
            function validGetMultipleAdresse$identifiantUniqueFonction() {
                $jsIfOK
            }
        ";
        $fonction.="</script>";
        
        $appelFonction = "";
        if (isset($params['jsCodeForWaitingWhileLocalization'])) {
            $appelFonction.=$params['jsCodeForWaitingWhileLocalization'];
        }
        foreach ($configFields as $identifiant => $values) {
            $location="";
            if (isset($values['getAdresseFromElementById'])
                && $values['getAdresseFromElementById']==true
            ) {
                $location = $values['jsAdresseValue'];
            }

            $appelFonction.="geocoder.getLocations($location,
            getPointGMFrameWork".$identifiantUniqueFonction."_".$identifiant.");";
            
            
            //$appelFonction.="alert($location);";
        }
        $appelFonction.="setTimeout(
        'validGetMultipleAdresse$identifiantUniqueFonction()', 3000);";
        
        $appelFonction .="";
        return array('jsFunctionToExecute'=>$fonction,
        'jsFunctionCall'=>$appelFonction);
    }
    
    /**
     * ?
     * 
     * @param array $params Paramètres
     * 
     * @return string HTML
     * */
    public function setFunctionAddPointsCallableFromChild($params = array())
    {
        $html = "
            function addPoint(longitude, latitude, labelText, onClick) {
                   
                var iconMarker = L.marker(L.latLng(latitude,
                longitude).addTo(markers);
            
                //var eLabel = new ELabel(point, labelText,
                \"styleLabelGoogleMap\");
                //eLabel.pixelOffset = new GSize(20, -10);
                //map.addOverlay(eLabel);
                //eLabel.hide();
                
                //function onClickFunction(overlay,
                point){currentMarker = marker; currentLabel=eLabel; onClick}
                //GEvent.addListener(marker,  'click',  onClickFunction); 
            }
        
        ";
        
        return $html;
    }
    
    /**
     * Affiche la carte et charge les fonctions
     * sans options supplémentaires contrairement à getHTML
     * 
     * @param array $params Paramètres
     * 
     * @return string HTML
     * */
    public function getMap($params = array())
    {
        $html="";
        /*$html="w = window.open();
        
            obj = parent.window;
        
            for(i in obj) {
                w.document.write(i+' => '+obj[i]+'<br>');
            }
        
        ";
        */
        if (isset($params['mapIsOnParentDocument'])
            && $params['mapIsOnParentDocument']==true
        ) {
            if (isset($params['noScriptBalises'])
                && $params['noScriptBalises']==true
            ) {
                $html.="map = parent.window.map;";
            } else {
                $html.="<script>map = parent.window.map;</script>";
            }
        }
        

        
        
        if (isset($params['addPointsOnMapMode'])
            && $params['addPointsOnMapMode']==true
        ) {
            // la carte est deja affichee
            // on se contente de rajouter des points
        } else {
            $html.="<div id='".$this->googleMapNameId.
            "' style='padding:0px;margin:0px;width: ".
            $this->googleMapWidth."px; height: ".$this->googleMapHeight.
            "px; ".$this->divStyle."'></div>";
            /* dans le cas d'un parcours de type 'walking',  a pied, 
             * il faut preciser le div avec l'affichage des informations du chemin,
             * sinon le parcours ne s'affichera pas
             * */
            if (isset($params['idDivDisplayEtapesText'])
                && $params['idDivDisplayEtapesText']!=''
            ) {
                $html.="<div id='".$params['idDivDisplayEtapesText'].
                "' style=''></div>";
            }
            $html.="<script>load();</script>";
        }
        
        if (isset($params['noScriptBalises']) && $params['noScriptBalises']==true) {
            // pas de balise script
        } else {
            $html.="<script>";
        }
        
        if (isset($params['urlImageIcon']) && isset($params['pathImageIcon'])) {
            $urlImage = $params['urlImageIcon'];
            list($imageSizeX,  $imageSizeY,  $typeImage,  $attrImage)
                = getimagesize($params['pathImageIcon']);
            
            $html.="
                var iconMarker = L.marker();
            ";
        } else {
        }
        
        if (isset($params['noScriptBalises']) && $params['noScriptBalises']==true) {
            // pas de balise script
        } else {
            $html.="</script>";
        }
        
        
        if (isset($params['noScriptBalises']) && $params['noScriptBalises']==true) {
            // si pas de balise  ,  pas de code html non plus
        } else {
            if (isset($params['styleLabel'])) {
                $html.="<style type=\"text/css\">.styleLabelGoogleMap {".
                $params['styleLabel']."}</style>";
            } else {
                $html.="<style type=\"text/css\">.styleLabelGoogleMap {
                    background-color:#FFFFD5;font-size:9px;width:170px;
                    border:1px #006699 solid;padding:2px;}</style>";
            }
        }
        
        
        if (isset($params['listeCoordonnees'])) {
            if (isset($params['noScriptBalises'])
                && $params['noScriptBalises']==true
            ) {
                // pas de balise de script
            } else {
                $html.="<script>";
            }
            
            $Ymax = 0;
            $Ymin = 0;
            $Xmax = 0;
            $Xmin = 0;
            $i = 0;
            foreach ($params['listeCoordonnees'] as $indice => $values) {
                $html.="
                    point$indice = L.latLng(".$values['latitude'].", ".
                    $values['longitude'].");
                    marker$indice = L.marker(point$indice, {icon: icon, title: '".
                    addslashes(strip_tags($values['label']))."'}).addTo(markers);
                    //overlay$indice = map.addOverlay(marker$indice);
                    //marker$indice.bindPopup(\"".$values['libelle']."\");
                ";
                
                if (isset($values['jsCodeOnClickMarker'])) {
                    $html.="function onClickFunction$indice(overlay,
                    point){currentMarker = marker$indice;  ".
                    $values['jsCodeOnClickMarker']."}";
                    $html.="marker$indice.addEventListener('click',
                    onClickFunction$indice);";
                }

                
                if (isset($params['setAutomaticCentering'])
                    && $params['setAutomaticCentering']==true
                ) {
                    /* verif pour que l'on reste a peu pres
                     * dans les coordonnees de la france
                     * (verif a retirer si besoin)
                     * */
                    if ($values['latitude']>47 && $values['latitude']<49
                        && $values['longitude']>7 && $values['longitude']<8
                    ) {
                        if ($i == 0) {
                            $yMax = $values['latitude'];
                            $yMin = $values['latitude'];
                            $xMax = $values['longitude'];
                            $xMin = $values['longitude'];
                            $i++;
                        }
                        
                        
                        if ($values['latitude']>$yMax) {
                            $yMax = $values['latitude'];
                        }
                        
                        if ($values['latitude']<$yMin) {
                            $yMin = $values['latitude'];
                        }
                        
                        if ($values['longitude']>$xMax) {
                            $xMax = $values['longitude'];
                        }
                        
                        if ($values['longitude']<$xMin) {
                            $xMin = $values['longitude'];
                        }
                        
                        //$html.=" alert(' $yMax $yMin $xMax $xMin'); ";
                    }
                }
                
                
                
            }
            
            if (isset($params['setAutomaticCentering'])
                && $params['setAutomaticCentering']==true
                && isset($yMax)
            ) {
                $html.="
                    var max_lat = $yMax;
                    var min_lat = $yMin;
                    var max_lon = $xMax;
                    var min_lon = $xMin;
                    // calcul du zoom
                    var bounds = L.latLngBounds;
                    bounds.extend(L.latLng(min_lon,  min_lat));
                    bounds.extend(L.latLng(max_lon,  max_lat));
                    var zoom = map.getBoundsZoomLevel(bounds); 
                
                    // calcul du centre
                    var centreLat = (min_lat+max_lat)/2;
                    var centreLong = (min_lon+max_lon)/2;
                    map.setCenter(L.latLng(centreLat, centreLong), zoom); 
                    //alert(max_lat+' '+min_lat+' '+max_lon+' '+min_lon);

                    
                    
                ";
            
            }
            
            
            if (isset($params['noScriptBalises'])
                && $params['noScriptBalises']==true
            ) {
                // pas de balise de script
            } else {
                $html.="</script>";
            }
        }
        
        // coordonnees de parcours (itineraire)
        if (isset($params['listeCoordonneesParcours'])) {
            if (isset($params['noScriptBalises'])
                && $params['noScriptBalises']==true
            ) {
                // pas de balise de script
            } else {
                $html.="<script  >";
            }
            
            
            
            
            $html.="
            
                var directionsDiv;
            ";
            
            
            $html.="var options = {};";
            
            
            
            $html.="
                //gdir = new GDirections(map, directionsDiv);
            ";
            if (isset($params['getCoordonneesParcours'])
                && $params['getCoordonneesParcours']==true
            ) {
                $html.="
                    GEvent.addListener(gdir, 'load', onGDirectionLoaded);";
            }
            $html.="
                numWP = 0;
                wp = new Array();
                ";
            foreach ($params['listeCoordonneesParcours'] as $indice => $values) {
                if (isset($values['urlIcon']) && $values['urlIcon']!='') {
                    $dimX = 19;
                    $dimY = 32;
                    
                    if (isset($values['dimIconX'])) {
                        $dimX = $values['dimIconX'];
                    }
                    if (isset($values['dimIconY'])) {
                        $dimY = $values['dimIconY'];
                    }
                    
                    

                    
                    
                    $html.="
                        var iconMarker = L.marker();
                    
                    
                    ";
                }
                $html.="
                
                    point$indice = L.latLng(".$values['latitude'].", ".
                    $values['longitude'].");
                    marker$indice = L.marker(point$indice, {icon: icon});
                    marker$indice.addTo(markers);
                    //marker$indice.openInfoWindowHtml(\"".$values['libelle']."\");
                ";
                
                
                $html.="
                    
                    wp[numWP] = point$indice;
                    
                    numWP++;
                    ";
                
                if (isset($values['label'])) {
                    $html.="
                    marker$indice.bindPopup('".addslashes($values['label'])."');
                    ";
                } else {
                    $html.= "var eLabel$indice = null; ";
                }
                
                
                
               
                
            }
            



            //$html.="gdir.loadFromWaypoints(wp, options); ";
            $lastPoint=end($params['listeCoordonneesParcours']);
            $html.="
                var encodedPolyline = L.polyline(L.PolylineUtil.decode('".
                $params['polyline']."'));
                /*var encodedPolyline = new GPolyline.fromEncoded({
                            points: '".$params['polyline']."', 
                            levels: '".$params['levels']."', 
                            zoomFactor: 32, 
                            numLevels: 4
                        });*/
                map.addLayer(encodedPolyline);
                var bounds = encodedPolyline.getBounds();
                map.setView(bounds.getCenter(), map.getBoundsZoom(bounds), true);
            ";
            
            
            
            // récuperation des coordonnées du tracé
            if (isset($params['getCoordonneesParcours'])
                && $params['getCoordonneesParcours']==true
            ) {
                $html.="
                function onGDirectionLoaded() {
                    polyline = gdir.getPolyline();

                    formForm = document.createElement('FORM');
                    formForm.setAttribute('name', 'formVertices');
                    formForm.setAttribute('action', '');
                    formForm.setAttribute('method', 'POST');
                    formForm.setAttribute('enctype', 'multipart/form-data');

                    if (polyline)
                    for(i=0 ; i<polyline.getVertexCount() ; i++)
                    {
                        longitude = polyline.getVertex(i).lng();
                        latitude = polyline.getVertex(i).lat();
                        
                        
                        formInputLongitude = document.createElement('INPUT');
                        formInputLongitude.setAttribute('type', 'text');
                        formInputLongitude.setAttribute('name', 'longitudes['+i+']');
                        formInputLongitude.setAttribute('value', longitude);
                        
                        formInputLatitude = document.createElement('INPUT');
                        formInputLatitude.setAttribute('type', 'text');
                        formInputLatitude.setAttribute('name', 'latitudes['+i+']');
                        formInputLatitude.setAttribute('value', latitude);
                        
                        formForm.appendChild(formInputLongitude);
                        formForm.appendChild(formInputLatitude);
                        
                    }
                    formSubmitButton = document.createElement('INPUT');
                    formSubmitButton.setAttribute('type', 'submit');
                    formSubmitButton.setAttribute('name', 'submitVertices');
                    formSubmitButton.setAttribute('value',
                    'Modifier le chemin entre les étapes');
                    
                    formForm.appendChild(formSubmitButton);
                    document.body.appendChild(formForm);
                }
                
                
                ";
            }
            
            if (isset($params['noScriptBalises'])
                && $params['noScriptBalises']==true
            ) {
                // pas de balise de script
            } else {
                $html.="</script>";
            }
        }
        
        
        
        
                
        return $html;
    }
    
    /**
     * Calcul de distance
     * 
     * @param int $lat1 Latitude 1
     * @param int $lon1 Longitude 1
     * @param int $lat2 Latitude 2
     * @param int $lon2 Longitude 2
     * 
     * @return int Distance
     * */
    public function distance($lat1=0, $lon1=0, $lat2=0,  $lon2=0) 
    {
        $theta = $lon1 - $lon2;
        $dist = sin(_deg2rad($lat1)) * sin(_deg2rad($lat2)) + cos(_deg2rad($lat1))
            * cos(_deg2rad($lat2)) * cos(_deg2rad($theta));
        $dist = acos($dist);
        $dist = _rad2deg($dist);
        $dist = $dist * 60 * 1.1515;
        $dist = $dist * 1.609344;

        return $dist;
    }

    /**
     * This function converts decimal degrees to radians
     * 
     * @param int $deg Degrees
     * 
     * @return int Radians
     * */
    private function _deg2rad($deg=0) 
    {
          return ($deg * pi() / 180.0);
    }

    /**
     * This function converts radians to decimal degrees
     * 
     * @param int $rad Radians
     * 
     * @return int Degrees
     * */
    private function _rad2deg($rad=0) 
    {
          return ($rad / pi() * 180.0);
    }
}
?>
