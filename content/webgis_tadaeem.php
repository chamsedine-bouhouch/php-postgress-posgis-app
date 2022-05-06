
<?php include("includes/init.php");
      if (logged_in()) {
         $username=$_SESSION['username'];
         if (!verify_user_group($pdo, $username, "Tadaeem Clients")) {
            set_msg("User '{$username}' does not have permission to view this page");
            redirect('index.php');
        }
    } else {
        set_msg("Please log-in and try again");
        redirect('index.php');
    } 
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>WebGIS TADAEEM</title>
        <link rel="stylesheet" href="src/leaflet.css">
        <link rel="stylesheet" href="src/css/bootstrap.css">
        <link rel="stylesheet" href="src/plugins/L.Control.MousePosition.css">
        <link rel="stylesheet" href="src/plugins/L.Control.Sidebar.css">
        <link rel="stylesheet" href="src/plugins/Leaflet.PolylineMeasure.css">
        <link rel="stylesheet" href="src/plugins/easy-button.css">
        <link rel="stylesheet" href="src/css/font-awesome.min.css">
        <link rel="stylesheet" href="src/plugins/leaflet.awesome-markers.css">
        <link rel="stylesheet" href="src/plugins/MarkerCluster.css">
        <link rel="stylesheet" href="src/plugins/MarkerCluster.Default.css">
        <link rel="stylesheet" href="src/plugins/leaflet-legend.css">
        <link rel="stylesheet" href="src/jquery-ui.min.css">
        
        <script src="src/leaflet.js"></script>
        <script src="src/jquery-3.3.1.min.js"></script>
        <script src="src/plugins/L.Control.MousePosition.js"></script>
        <script src="src/plugins/L.Control.Sidebar.js"></script>
        <script src="src/plugins/Leaflet.PolylineMeasure.js"></script>
        <script src="src/plugins/easy-button.js"></script>
        <script src="src/plugins/leaflet-providers.js"></script>
        <script src="src/plugins/leaflet.ajax.min.js"></script>
        <script src="src/plugins/leaflet.awesome-markers.min.js"></script>
        <script src="src/plugins/leaflet.markercluster.js"></script>
        <script src="src/plugins/leaflet-legend.js"></script>
        <script src="src/jquery-ui.min.js"></script>
        <script src="src/turf.min.js"></script>

        <style>
            #mapdiv {
                height:100vh;
            }

            .col-xs-12, .col-xs-6, .col-xs-4 {
                padding:3px;
            }

            #divProject {
                background-color: beige;
            }
            
            #divBUOWL {
                background-color: #ffffb3;
            }
            
            #divEagle {
                background-color: #ccffb3;
            }
            
            #divRaptor {
                background-color: #e6ffff;
            }
            
            .errorMsg {
                padding:0;
                text-align:center;
                background-color:darksalmon;
            }
            .btnSurveys{
                display:none;
            }
            .text-labels {
                font-size:16px;
                font-weight: bold;
                color:red;
                background: aqua;
                text-align: center;
                display: inline-block;
                padding: 5pt;
                border: 3px double darkred;
                border-radius: 5pt;
                margin-left: -15pt;
                margin-top: -8pt;
            }
            
            .eagle-labels {
                font-size:12px;
                font-weight: bold;
                color:white;
                background: black;
                text-align: center;
                display: inline-block;
                padding: 5pt;
                border: 3px double red;
                border-radius: 5pt;
                margin-left: -20pt;
                margin-top: -32pt;
            }
             /* The Modal (background) */
             .modal {
                z-index: 2001; /* Sit on top */
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                display: none; /* Hidden by default */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content */
            .modal-content {
                color: saddlebrown;
                padding: 20px;
                margin-top: 5%;
                background-color:antiquewhite;
                height:80%;
                overflow-y:auto;
            }
            
            .tblHeader {
                background-color: wheat
            }
        </style>
    </head>
    <body>
        <div id="side-bar" class="col-md-3">
            <button id='btnLocate' class='btn btn-primary btn-block'>Locate</button>
            <button id="btnShowLegend" class='btn btn-primary btn-block'>Show Legend</button>
            <button id="btnBackToCMS" class='btn btn-primary btn-block'>Back to CMS</button>
            <div id="legend">
                <div id="lgndClientLinears">
                    <h4 class="text-center">Linear Projects <i id="btnLinearProjects" class="fa fa-server"></i></h4>
                    <div id="lgndLinearProjectsDetail">
                        <svg height="60" width="100%">
                            <line x1="10" y1="10" x2="40" y2="10" style="stroke:black; stroke-width:2;"/>
                            <text x="50" y="15" style="font-family:sans-serif; font-size:16px;">AE</text>
                            <line x1="10" y1="40" x2="40" y2="40" style="stroke:black; stroke-width:2;"/>
                            <text x="50" y="45" style="font-family:sans-serif; font-size:16px;">ST</text>
                        </svg>
                    </div>
                </div>
                
                <div id="lgndEagleNest">
                    <h4 class="text-center">Armoires<i id="btnEagle" class="fa fa-server"></i></h4>
                    <div id="lgndEagleDetail">
                        <svg height="90">
                            <circle cx="25" cy="15" r="10" style="stroke-width: 4; stroke: deeppink; fill: chartreuse; fill-opacity:0.5;"/>
                            <text x="50" y="20" style="font-family: sans-serif; font-size: 16px;">Bon</text>
                            <circle cx="25" cy="45" r="10" style="stroke-width: 4; stroke: chartreuse; fill: chartreuse; fill-opacity:0.5;"/>
                            <text x="50" y="50" style="font-family: sans-serif; font-size: 16px;">Mauvais</text>
                            <circle cx="25" cy="75" r="10" style="stroke-width: 4; stroke: chartreuse; fill: chartreuse; fill-opacity:0.5;"/>
                            <text x="50" y="80" style="font-family: sans-serif; font-size: 16px;">Très Mauvais</text>
                        </svg>
                    </div>
                </div>
                <div id="lgndRaptorNest">
                    <h4 class="text-center">Points Lumineux <i id="btnRaptor" class="fa fa-server"></i></h4>
                    <div id="lgndRaptorDetail">
                        <svg height="90">
                            <circle cx="25" cy="15" r="10" style="stroke-width: 4; stroke: deeppink; fill: cyan; fill-opacity:0.5;"/>
                            <text x="50" y="20" style="font-family: sans-serif; font-size: 16px;">ACIER</text>
                            <circle cx="25" cy="45" r="10" style="stroke-width: 4; stroke: deeppink; stroke-dasharray: 5, 5; fill: cyan; fill-opacity:0.5;"/>
                            <text x="50" y="50" style="font-family: sans-serif; font-size: 16px;">BETON</text>
                            <circle cx="25" cy="75" r="10" style="stroke-width: 4; stroke: cyan; fill: cyan; fill-opacity:0.5;"/>
                            <text x="50" y="80" style="font-family: sans-serif; font-size: 16px;">CONDELABRE</text>
                        </svg>
                    </div>
                </div>
                <div id="lgndRaptorNest">
                    <h4 class="text-center">Foyers <i id="btnRaptor" class="fa fa-server"></i></h4>
                    <div id="lgndRaptorDetail">
                        <svg height="90">
                            <circle cx="25" cy="15" r="10" style="stroke-width: 4; stroke: deeppink; fill: cyan; fill-opacity:0.5;"/>
                            <text x="50" y="20" style="font-family: sans-serif; font-size: 16px;">HPL</text>
                            <circle cx="25" cy="45" r="10" style="stroke-width: 4; stroke: deeppink; stroke-dasharray: 5, 5; fill: cyan; fill-opacity:0.5;"/>
                            <text x="50" y="50" style="font-family: sans-serif; font-size: 16px;">SHP</text>
                            <circle cx="25" cy="75" r="10" style="stroke-width: 4; stroke: cyan; fill: cyan; fill-opacity:0.5;"/>
                            <text x="50" y="80" style="font-family: sans-serif; font-size: 16px;">LED</text>
                        </svg>
                    </div>
                </div>
                 
            </div>
            <div id="divProject" class="col-xs-12">
                <div id="divProjectLabel" class="text-center col-xs-12">
                    <h4 id="lblProject">DEPARTS</h4>
                </div>
                <div id="divProjectError" class="errorMsg col-xs-12"></div>
                <div id="divFindProject" class="form-group has-error">
                    <div class="col-xs-6">
                        <input type="text" id="txtFindProject" class="form-control" placeholder="ID RESEAU">
                    </div>
                    <div class="col-xs-6">
                        <button id="btnFindProject" class="btn btn-primary btn-block" disabled>Trouver Reseau</button>
                    </div>
                </div>
                <div id="divFilterProject" class="col-xs-12">
                    <div class="col-xs-4">
                        <input type='checkbox' name='fltReseau' value='AE' checked>AE
                        <input type='checkbox' name='fltReseau' value='ST' checked>ST
                    </div>
                    <div class="col-xs-4">
                    <button id="btnProjectFilterAll" class="btn btn-primary btn-block">Check All</button>

                        <button id="btnProjectFilterNone" class="btn btn-primary btn-block">Uncheck All</button>
                    </div>
                    <div class="col-xs-4">
                         
                        <button id="btnProjectFilter" class="btn btn-primary btn-block">Filter</button>
                    </div>
                </div>
                <button id="btnreseausurveys" class="btnSurveys btn btn-primary btn-block">Show Surveys</button>

                <div class="" id="divProjectData"></div>
            </div>
            <div id="divBUOWL" class="col-xs-12">
                <div id="divBUOWLLabel" class="text-center col-xs-12">
                    <h4 id="lblBUOWL">FOYERS</h4>
                </div>
                <div id="divBUOWLError" class="errorMsg col-xs-12"></div>
                <div id="divFindBUOWL" class="form-group has-error">
                    <div class="col-xs-6">
                        <input type="text" id="txtFindFoyer" class="form-control" placeholder="ID FOYER">
                    </div>
                    <div class="col-xs-6">
                        <button id="btnFindBUOWL" class="btn btn-primary btn-block" disabled>Trouver Foyer</button>
                    </div>
                </div>
                <div id="divFilterBUOWL" class="col-xs-12">
                    <div class="col-xs-4">
                        <input type='radio' name='fltFoyer' value='ALL' checked>All
                    </div>
                    <div class="col-xs-4">
                        <input type='radio' name='fltFoyer' value='SHP'>SHP
                    </div>
                    <div class="col-xs-4">
                        <input type='radio' name='fltFoyer' value='HPL'>HPL
                    </div>
                    <div class="col-xs-4">
                        <input type='radio' name='fltFoyer' value='LED'>LED
                    </div>
                </div>
                <button id="btnFoyerssurveys" class="btnSurveys btn btn-primary btn-block">Show Surveys</button>

                <div class="" id="divBUOWLData"></div>
            </div>
            <div id="divEagle" class="col-xs-12">
                <div id="divEagleLabel" class="text-center col-xs-12">
                    <h4 id="lblEagle">ARMOIRES</h4>
                </div>
                <div id="divEagleError" class="errorMsg col-xs-12"></div>
                <div id="divFindEagle" class="form-group has-error">
                    <div class="col-xs-6">
                        <input type="text" id="txtFindEagle" class="form-control" placeholder="ID ARMOIRE">
                    </div>
                    <div class="col-xs-6">
                        <button id="btnFindEagle" class="btn btn-primary btn-block" disabled>TROUVER ARMOIRE</button>
                    </div>
                </div>
                <div id="divFilterEagle" class="col-xs-12">
                    <div class="col-xs-4">
                        <input type='radio' name='fltArmoire' value='ALL' checked>All
                    </div>
                    <div class="col-xs-4">
                        <input type='radio' name='fltArmoire' value='BON'>BON
                    </div>
                    <div class="col-xs-4">
                        <input type='radio' name='fltArmoire' value='MAUVAIS'>MAUVAIS
                    </div> 
                    <div class="col-xs-4">
                        <input type='radio' name='fltArmoire' value='TRES MAUVAIS'>TRES MAUVAIS
                    </div>
                </div>
                <button id="btnarmoiresurveys" class="btnSurveys btn btn-primary btn-block">Show Surveys</button>

                <div class="" id="divEagleData"></div>
            </div>
            <div id="divRaptor" class="col-xs-12">
                <div id="divRaptorLabel" class="text-center col-xs-12">
                    <h4 id="lblRaptor">POINTS LUMINEUX</h4>
                </div>
                <div id="divRaptorError" class="errorMsg col-xs-12"></div>
                <div id="divFindRaptor" class="form-group has-error">
                    <div class="col-xs-6">
                        <input type="text" id="txtFindRaptor" class="form-control" placeholder="ID SUPPORT">
                    </div>
                    <div class="col-xs-6">
                        <button id="btnFindRaptor" class="btn btn-primary btn-block" disabled>Trouver Support</button>
                    </div>
                </div>
                <div id="divFilterRaptor" class="col-xs-12">
                    <div class="col-xs-3">
                        <input type='radio' name='fltPtLum' value='ALL' checked>All
                    </div>
                    <div class="col-xs-3">
                        <input type='radio' name='fltPtLum' value='BETON'>BETON
                    </div>
                    <div class="col-xs-3">
                        <input type='radio' name='fltPtLum' value='ACIER'>ACIER
                    </div>
                    <div class="col-xs-3">
                        <input type='radio' name='fltPtLum' value='CONDELABRE'>COND
                    </div>
                </div>
                <button id="btnptsLumsurveys" class="btnSurveys btn btn-primary btn-block">Show Surveys</button>

                <div class="" id="divRaptorData"></div>
            </div>
        </div>
        <div id="mapdiv" class="col-md-12"></div>
        <div id="dlgModal" class="modal">
                    <div id="dlgContent" class="modal-content col-sm-10 col-sm-offset-1 col-md-7 col-md-offset-4">
                        <span id="btnCloseModal" class="pull-right"><i class="fa fa-close fa-2x"></i></span>
                        <div id="tableData"></div>
                    </div>
        </div>
        <script>
            var mymap;
            var lyrOSM;
            var lyrWatercolor;
            var lyrTopo;
            var lyrImagery;
            var lyrOutdoors;
            var lyrArmoires;
            var lyrptslum;
            var lyrReseau;
            var lyrFoyer;
            // var lyrClientLinesBuffer;
            var lyrBUOWLbuffer;
            var jsnBUOWLbuffer;
            var lyrGBH;
            var lyrSearch;
            var lyrMarkerCluster;
            var mrkCurrentLocation;
            var fgpDrawnItems;
            var ctlAttribute;
            var ctlScale;
            var ctlMouseposition;
            var ctlMeasure;
            var ctlEasybutton;
            var ctlSidebar;
            var ctlLayers;
            var ctlStyle;
            var ctlLegend;
            var objBasemaps;
            var objOverlays;
            var arReseaux = [];
            var arFoyersID = [];
            var arArmoireIDs = [];
            var arPTSLUMIDs = [];
            
            $(document).ready(function(){
                
                //  ********* Map Initialization ****************
                
                mymap = L.map('mapdiv', {center:[35.89112, 8.55228], zoom:14, attributionControl:false});
                
                ctlSidebar = L.control.sidebar('side-bar').addTo(mymap);
                
                ctlEasybutton = L.easyButton('glyphicon-transfer', function(){
                   ctlSidebar.toggle(); 
                }).addTo(mymap);
                
                ctlAttribute = L.control.attribution().addTo(mymap);
                ctlAttribute.addAttribution('OSM');
                ctlAttribute.addAttribution('&copy; <a href="www.geomatics-engineering.com">Geomatics Engineering</a>');
                
                ctlScale = L.control.scale({position:'bottomleft', metric:false, maxWidth:200}).addTo(mymap);

                ctlMouseposition = L.control.mousePosition().addTo(mymap);
                
                ctlMeasure = L.control.polylineMeasure().addTo(mymap);
                
                //   *********** Layer Initialization **********
                
                lyrOSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
                lyrTopo = L.tileLayer.provider('OpenTopoMap');
                lyrImagery = L.tileLayer.provider('Esri.WorldImagery');
                lyrOutdoors = L.tileLayer.provider('Thunderforest.Outdoors');
                lyrWatercolor = L.tileLayer.provider('Stamen.Watercolor');
                mymap.addLayer(lyrOSM);
                
                fgpDrawnItems = new L.FeatureGroup();
                fgpDrawnItems.addTo(mymap);
                refresh_armoires();
                refresh_PtLum();
                refresh_Reseau();
                refresh_Foyers();
           
                // ********* Setup Layer Control  ***************
                
                objBasemaps = {
                    "Open Street Maps": lyrOSM,
                    "Topo Map":lyrTopo,
                    "Imagery":lyrImagery,
                    "Outdoors":lyrOutdoors,
                    "Watercolor":lyrWatercolor
                };
                
                objOverlays = {
                    // "Client Linears":lyrClientLines,
                    // "Burrowing Owl Habitat":lyrBUOWL,
                    // "Eagle Nest":lyrEagleNests,
                    // "Raptor Nest":lyrMarkerCluster,
                    // "GBH Rookeries":lyrGBH,
                    // "Drawn Items":fgpDrawnItems
                };
                
                ctlLayers = L.control.layers(objBasemaps, objOverlays).addTo(mymap);
                
                mymap.on('overlayadd', function(e){
                    var strDiv = "#lgnd"+stripSpaces(e.name);
                    $(strDiv).show();
                });
                
                mymap.on('overlayremove', function(e){
                    var strDiv = "#lgnd"+stripSpaces(e.name);
                    $(strDiv).hide();
                });
                
                ctlLegend = new L.Control.Legend({
                    position:'topright',
                    controlButton:{title:"Legend"}
                }).addTo(mymap);
                
                $(".legend-container").append($("#legend"));
                $(".legend-toggle").append($("<i class='legend-toggle-icon fa fa-server fa-2x' style='color:#000'></i>"));
                // ************ Location Events **************
                
                mymap.on('locationfound', function(e) {
                    console.log(e);
                    if (mrkCurrentLocation) {
                        mrkCurrentLocation.remove();
                    }
                    mrkCurrentLocation = L.circle(e.latlng, {radius:e.accuracy/2}).addTo(mymap);
                    mymap.setView(e.latlng, 14);
                });
                
                mymap.on('locationerror', function(e) {
                    console.log(e);
                    alert("Location was not found");
                })
                
            });

            //  ********* Foyers Functions

            $("#btnBUOWL").click(function(){
               $("#lgndBUOWLDetail").toggle(); 
            });
            
            
            function returnFoyer(json, latlng){
                var att = json.properties;
                if (att.vasque=='OUI') {
                    var clrFoyer = 'green';
                } else {
                    var clrFoyer = 'red';
                }
                arFoyersID.push(att.id_foyer.toString());
                return L.circle(latlng, {radius:25, color:clrFoyer,fillColor:'white', fillOpacity:0.5}).bindTooltip("<h4>ID: "+att.id_foyer+"</h4>Vasque: "+att.vasque);
            }
            function filterFoyer(json) {
                var att=json.properties;
                var optFilter = $("input[name=fltFoyer]:checked").val();
                if (optFilter=='ALL') {
                    return true;
                } else {
                    return (att.typ_lampe==optFilter);
                }
            }
            
            $("#txtFindFoyer").on('keyup paste', function(){
                var val = $("#txtFindFoyer").val();
                testLayerAttribute(arFoyersID, val, "ID Foyer", "#divFindBUOWL", "#divBUOWLError", "#btnFindBUOWL");
            });
            
            $("#btnFindBUOWL").click(function(){
                var val = $("#txtFindFoyer").val();
                var lyr = returnLayerByAttribute(lyrFoyer,'id_foyer',val);
                if (lyr) {
                    if (lyrSearch) {
                        lyrSearch.remove();
                    }
                    lyrSearch = L.geoJSON(lyr.toGeoJSON(), {style:{color:'red', weight:10, opacity:0.5, fillOpacity:0}}).addTo(mymap);
                    mymap.fitBounds(lyr.getBounds().pad(1));
                    var att = lyr.feature.properties;
                    $("#divBUOWLData").html("<h4 class='text-center'>Attributes</h4><h5>ID: "+att.id_foyer+"</h5><h5>Type: "+att.typ_lampe+"</h5><h5>Etat: "+att.etat_foyer+"</h5>");
                    $("#divBUOWLError").html("");
                    
                    fgpDrawnItems.clearLayers();
                    fgpDrawnItems.addLayer(lyr);
                    $(".btnSurveys").show();
                    
                 } else {
                    $("#divBUOWLError").html("**** ID Foyer introuvable ****");
                }
            });
            
            $("#lblBUOWL").click(function(){
                $("#divBUOWLData").toggle(); 
            });
            
            $("input[name=fltFoyer]").click(function(){
                // arHabitatIDs = [];
                // lyrBUOWL.refresh();
                refresh_Foyers();
            });
            function refresh_Foyers(){
                $.ajax({url:'loading_data.php',
                    data: {tbl: 'foyers', 
                    flds:'id_foyer, typ_lampe, etat_foyer, puissance'},
                    type: 'POST',                    
                success:function(response){
                        // alert(response);
                        arFoyersID=[];
                        jsnFoyer= JSON.parse(response);
                        if(lyrFoyer){
                            ctlLayers.removeLayer(lyrFoyer);
                            lyrFoyer.remove();
                        
                        }
                         
                        lyrFoyer = L.geoJSON(jsnFoyer,{pointToLayer:returnFoyer, filter:filterFoyer}).addTo(mymap);
                        ctlLayers.addOverlay(lyrFoyer, "Foyers");
                        arFoyersID.sort(function(a,b){return a-b});
                            $("#txtFindFoyer").autocomplete({
                            source:arFoyersID
                    });
                        console.log(JSON.parse(response));
                        lyrFoyer.bringToFront();
                    },
                    error:function(xhr, status, error){
                        alert("ERROR: "+error);
                       
                    }
                });
            }


            //Load surveys from database to the dashboard.

            $("#btnFoyerssurveys").click(function(){
                var search_id = $("#txtFindFoyer").val()
                var whr="id_foyer="+search_id
                $.ajax({
                    url:'php/load_table.php',
                    data:{tbl:"foyer_survey", 
                          title:'Surveys for Foyers '+search_id, 
                          flds:'"surveyor" AS "Surveyor", "date" AS "Survey Date", "created" AS "Created", "createdby" AS "CreatedBy","lastsurvey" AS "Last Survey"', 
                          order:'date DESC' 
                        //   ,where:whr
                        },
                    type:'POST',
                    success:function(response){
                        $("#tableData").html(response);
                        $("#dlgModal").show();
                    },
                    error:function(xhr, status, error){
                        $("#tableData").html("ERROR: "+error);
                        $("#dlgModal").show();
                    }
                });
            })
            $("#btnarmoiresurveys").click(function(){
                var search_id = $("#txtFindEagle").val()
                var whr="id="+search_id
                $.ajax({
                    url:'php/load_table.php',
                    data:{tbl:"armoire_survey", 
                            title:'Surveys for Armoire '+search_id, 
                            flds:'"id" AS "ID", "date" AS "Survey Date", "created" AS "Created", "createdby" AS "CreatedBy","lastsurvey" AS "Last Survey"', 
                            order:'date DESC' 
                        //   ,where:whr
                        },
                    type:'POST',
                    success:function(response){
                        $("#tableData").html(response);
                        $("#dlgModal").show();
                    },
                    error:function(xhr, status, error){
                        $("#tableData").html("ERROR: "+error);
                        $("#dlgModal").show();
                    }
                });
            })
            $("#btnptsLumsurveys").click(function(){
                var search_id = $("#txtFindRaptor").val()
                var whr="id="+search_id
                $.ajax({
                    url:'php/load_table.php',
                    data:{tbl:"pts_lums_survey", 
                            title:'Surveys for Armoire '+search_id, 
                            flds:'"id" AS "ID", "date" AS "Survey Date", "created" AS "Created", "createdby" AS "CreatedBy","lastsurvey" AS "Last Survey"', 
                            order:'date DESC' 
                        //   ,where:whr
                        },
                    type:'POST',
                    success:function(response){
                        $("#tableData").html(response);
                        $("#dlgModal").show();
                    },
                    error:function(xhr, status, error){
                        $("#tableData").html("ERROR: "+error);
                        $("#dlgModal").show();
                    }
                });
            });
            // $("#btnreseausurveys").click(function(){
            //     var search_id = $("#txtFindProject").val()
            //     var whr="id= "+search_id
            //     $.ajax({
            //         url:'load_table.php',
            //         data:{tbl:"reseaux_survey", 
            //                 title:'Surveys for Reseau '+search_id, 
            //                 flds:'"id" AS "ID", "date" AS "Survey Date", "surveyor" AS "Surveyor", "created" AS "Created", "createdby" AS "CreatedBy","lastsurvey" AS "Last Survey", "result" AS "Result"', 
            //                 order:'date DESC' 
            //             //   ,where:whr
            //             },
            //         type:'POST',
            //         success:function(response){
            //             $("#tableData").html(response);
            //             $("#dlgModal").show();
            //         },
            //         error:function(xhr, status, error){
            //             $("#tableData").html("ERROR: "+error);
            //             $("#dlgModal").show();
            //         }
            //     });
            // })

            $("#btnCloseModal").click(function(){
                $("#dlgModal").hide();
            })


            function displaySurveys(tbl ,id){
                $.ajax({
                    url:'php/load_surveys.php',
                    data:{tbl:tbl, id:id},
                    type:'POST',
                    success:function(response){
                        $("#tableData").html(response);
                        $(".btnEditSurvey").click(function(){
                            editSurvey(tbl,id, $(this).attr('data-id'));
                        });
                        $(".btnDeleteSurvey").click(function(){
                            deleteSurvey(tbl,id, $(this).attr('data-id'));
                        });
                        $("#dlgModal").show();
                    },
                    error:function(xhr, status, error){
                        $("#tableData").html("ERROR: "+error);
                        $("#dlgModal").show();
                    }
                });            
                }
                function editSurvey(tbl, id, survey_id){
                    alert("Editing "+tbl +" Survey "+survey_id+ " for constaint "+id);
                }
                 function deleteSurvey(tbl, id, survey_id){
                     if(confirm("Are you sure you want to delete survey "+survey_id+ " from "+tbl+ "?")){
                        $.ajax({
                        url:'delete_record.php',
                        data:{tbl:tbl, id:survey_id},
                        type:'POST',
                        success:function(response){
                            $("#tableData").html(response);
                            displaySurveys(tbl,id);
                        },
                        error:function(xhr, status, error){
                            $("#tableData").html("ERROR: "+error);
                            $("#dlgModel").show();
                        }
                    })
                     }
                }
            
                $("#btnreseausurveys").click(function(){
                    displaySurveys("reseaux_survey",$("#txtFindProject").val());
                });
            //      $("#btnptsLumsurveys").click(function(){
            //         displaySurveys("pts_lums_survey",$("#txtFindRaptor").val());
            //     });
            // // ************ Réseaux Linears **********
            
            // $("#btnptsLumsurveys").click(function(){
            //    $("#lgndLinearProjectsDetail").toggle(); 
            // });
            
            function styleReseaux(json) {
                var att = json.properties;
                switch (att.type) {
                    case 'AE':
                        return {color:'black'};
                        break;
                   
                    case 'ST':
                        return {color:'black', dashArray:"5,5"};
                        break;
                     
                    default:
                        return {color:'blue'}
                }
            }
            
            function processReseaux(json, lyr) {
                var att = json.properties;
                lyr.bindTooltip("<h4>Linear ID: "+att.id+"</h4>Type: "+att.type+"<br>Section: "+att.section);
                arReseaux.push(att.id.toString());
                // var jsnBuffer = turf.buffer(json, att.distance/1000, 'kilometers');
                // var lyrBuffer = L.geoJSON(jsnBuffer, {style:{color:'gray', dashArray:'5,5'}});
                // lyrReseau.addLayer(arReseaux);
            }
            
            function filterReseaux(json) {
                var arReseaux=[];
                $("input[name=fltReseau]").each(function(){
                    if (this.checked) {
                        arReseaux.push(this.value);
                    }
                });
                var att = json.properties;
                switch (att.type) {
                    case "AE":
                        return (arReseaux.indexOf('AE')>=0);
                        break;
                    case "ST":
                        return (arReseaux.indexOf('ST')>=0);
                        break; 
                   
                }
            }
            
            $("#txtFindProject").on('keyup paste', function(){
                var val = $("#txtFindProject").val();
                testLayerAttribute(arReseaux, val, "ID RESEAU", "#divFindProject", "#divProjectError", "#btnFindProject");
            });
            
            $("#btnFindProject").click(function(){
                var val = $("#txtFindProject").val();
                var lyr = returnLayerByAttribute(lyrReseau,'id',val);
                if (lyr) {
                    if (lyrSearch) {
                        lyrSearch.remove();
                    }
                    lyrSearch = L.geoJSON(lyr.toGeoJSON(), {style:{color:'red', weight:10, opacity:0.5}}).addTo(mymap);
                    mymap.fitBounds(lyr.getBounds().pad(1));
                    var att = lyr.feature.properties;
                    $("#divProjectData").html("<h4 class='text-center'>Attributes</h4><h5>Type: "+att.type+"</h5><h5>Distance: "+att.distance+ " m </h5>");
                    $("#divProjectError").html("");
                    
                    fgpDrawnItems.clearLayers();
                    fgpDrawnItems.addLayer(lyr);
                    $(".btnSurveys").show();

                    
                } else {
                    $("#divProjectError").html("**** ID Réseau introuvable ****");
                }
            });
            
            $("#lblProject").click(function(){
                $("#divProjectData").toggle(); 
            });
            
            $("#btnProjectFilterAll").click(function(){
                $("input[name=fltReseau]").prop('checked', true);
            });
            
            $("#btnProjectFilterNone").click(function(){
                $("input[name=fltReseau]").prop('checked', false);
            });
            
            $("#btnProjectFilter").click(function(){
                // arProjectIDs=[];
                // lyrClientLines.refresh();
                refresh_Reseau();
            });
            function refresh_Reseau(){
                $.ajax({url:'loading_data.php',
                    data: {tbl: 'reseaux', 
                    flds:'id, type, section, depart,distance'},
                    type: 'POST',                    
                success:function(response){
                        // alert(response);
                        arReseaux=[];
                        jsnreseau= JSON.parse(response);
                        if(lyrReseau){
                            ctlLayers.removeLayer(lyrReseau);
                            lyrReseau.remove();
                        }
                        lyrReseau = L.geoJSON(jsnreseau, {style:styleReseaux, 
                                                        onEachFeature:processReseaux, 
                                                          filter:filterReseaux}).addTo(mymap);
                        ctlLayers.addOverlay(lyrReseau, "Reseaux");
                        arReseaux.sort(function(a,b){return a-b});
                            $("#txtFindProject").autocomplete({
                            source:arReseaux
                    });
                        // console.log(JSON.parse(response));
                        lyrReseau.bringToFront();
                    },
                    error:function(xhr, status, error){
                        alert("ERROR: "+error);
                    }
            });
               }
            
            // *********  Armoires Functions *****************
            
            $("#btnEagle").click(function(){
               $("#lgndEagleDetail").toggle(); 
            });
            
            function returnArmoires(json, latlng){
                var att = json.properties;
                if (att.etatarmoi=='BON') {
                    var clrArmoire = 'green';
                } else {
                    var clrArmoire = 'red';
                }
                arArmoireIDs.push(att.id_armoire.toString());
                return L.circle(latlng, {radius:25, color:clrArmoire,fillColor:'white', fillOpacity:0.5}).bindTooltip("<h4>ID: "+att.id_armoire+"</h4>Etat: "+att.etatarmoi);
            }
            
            function filterArmoire(json) {
                var att=json.properties;
                var optFilter = $("input[name=fltArmoire]:checked").val();
                if (optFilter=='ALL') {
                    return true;
                } else {
                    return (att.etatarmoi==optFilter);
                }
            }
            
            $("#txtFindEagle").on('keyup paste', function(){
                var val = $("#txtFindEagle").val();
                testLayerAttribute(arArmoireIDs, val, "ID Armoire", "#divFindEagle", "#divEagleError", "#btnFindEagle");
            });
            
            $("#btnFindEagle").click(function(){
                var val = $("#txtFindEagle").val();
                var lyr = returnLayerByAttribute(lyrArmoires,'id_armoire',val);
                if (lyr) {
                    if (lyrSearch) {
                        lyrSearch.remove();
                    }
                    lyrSearch = L.circle(lyr.getLatLng(), {radius:100, color:'black', weight:10, opacity:0.5, fillOpacity:0}).addTo(mymap);
                    mymap.setView(lyr.getLatLng(), 14);
                    var att = lyr.feature.properties;
                    $("#divEagleData").html("<h4 class='text-center'>Attributes</h4><h5>Status: "+att.etatarmoi+"</h5>");
                    $("#divEagleError").html("");
                    
                    fgpDrawnItems.clearLayers();
                    fgpDrawnItems.addLayer(lyr);
                    $(".btnSurveys").show();

                    
                 } else {
                    $("#divEagleError").html("**** ID Armoire introuvable ****");
                }
            });
            
            $("#lblEagle").click(function(){
                $("#divEagleData").toggle(); 
            });
            
            $("input[name=fltArmoire]").click(function(){
               
                refresh_armoires();
            });

            function refresh_armoires(){
                    $.ajax({url:'loading_data.php',
                    data: {tbl: 'armoires', flds:"id, etatarmoi,zone,variateur"},
                    type: 'POST',
                    success:function(response){
                        arArmoireIDs=[];
                        // alert(response);
                        jsnArmoires= JSON.parse(response);
                        if(lyrArmoires){
                            ctlLayers.removeLayer(lyrArmoires);
                            lyrArmoires.remove();
                        }
                        lyrArmoires = L.geoJSON(jsnArmoires, {pointToLayer:returnArmoires, 
                                                filter:filterArmoire}).addTo(mymap);
                        ctlLayers.addOverlay(lyrArmoires, "Armoires");
                        arArmoireIDs.sort(function(a,b){return a-b});
                            $("#txtFindEagle").autocomplete({
                            source:arArmoireIDs
                    });
                        // console.log(JSON.parse(response));
                    },
                    error:function(xhr, status, error){
                        alert("ERROR: "+error);
                    }
                });
            }
            
            //  *********** Points Lumineux Functions
            
            $("#btnRaptor").click(function(){
               $("#lgndRaptorDetail").toggle(); 
            });
            
            function returnPtsLum(json, latlng){
                var att = json.properties;
                arPTSLUMIDs.push(att.id_poteau.toString());
                switch (att.materiaux) {
                    case 'BETON':
                        var radptslum = 5;
                        break;
                    case 'ACIER':
                        var radptslum = 5;
                        break;
                        case 'CONDELABLE':
                        var radptslum = 5;
                        break;
                    default:
                        var radptslum = 5;
                        break;
                }
                switch (att.type_supp) {
                    case 'MAT':
                        var optptsLum = {radius:radptslum, color:'black', fillColor:"white", fillOpacity:0.5};
                        break;
                    case 'FACADE':
                        var optptsLum = {radius:radptslum, color:'yellow', fillColor:'black', fillOpacity:0.5};
                        break;
                     
                }
                return L.circle(latlng, radptslum).bindPopup("<h4>ID Poteau: "+att.id_poteau+"</h4>Matériaux: "+att.materiaux+"<br>Depart: "+att.depart+"<br>Armoire: "+att.armoire+"<br>Type: "+att.type_supp);
            }
                
            function filterPtsLum(json) {
                var att=json.properties;
                var optFilter = $("input[name=fltPtLum]:checked").val();
                if (optFilter=='ALL') {
                    return true;
                } else {
                    return (att.materiaux==optFilter);
                }
            }
            
            $("#txtFindRaptor").on('keyup paste', function(){
                var val = $("#txtFindRaptor").val();
                testLayerAttribute(arPTSLUMIDs, val, "ID POTEAU", "#divFindRaptor", "#divRaptorError", "#btnFindRaptor");
            });
            
            $("#btnFindRaptor").click(function(){
                var val = $("#txtFindRaptor").val();
                var lyr = returnLayerByAttribute(lyrMarkerCluster,'id_poteau',val);
                if (lyr) {  
                    if (lyrSearch) {
                        lyrSearch.remove();
                    }
                    var att = lyr.feature.properties;
                    switch (att.materiaux) {
                        case 'BETON':
                            var radptslum = 5;
                            break;
                        case 'ACIER':
                            var radptslum = 5;
                            break;    
                        case 'CONDELABRE':
                            var radptslum = 5;
                            break;
                        default:
                            var radptslum = 3;
                            break;
                    }
                    lyrSearch = L.circle(lyr.getLatLng(), {radius:radptslum, color:'red', weight:10, opacity:0.5, fillOpacity:0}).addTo(mymap);
                    mymap.setView(lyr.getLatLng(), 14);
                    $("#divRaptorData").html("<h4 class='text-center'>Attributes</h4><h5>ID: "+att.id_poteau+"</h5><h5>Armoire: "+att.armoire+"</h5><h5>Départ: "+att.depart+"</h5>");
                    $("#divRaptorError").html("");
                    
                    fgpDrawnItems.clearLayers();
                    fgpDrawnItems.addLayer(lyr);
                    $(".btnSurveys").show();

                    
                 } else {
                    $("#divRaptorError").html("**** Support introuvable ****");
                }
            });
            
            $("#lblRaptor").click(function(){
                $("#divRaptorData").toggle(); 
            });
            
            $("input[name=fltPtLum]").click(function(){
                // arPTSLUMIDs=[];
                // lyrptslum.refresh();
                refresh_PtLum();
            });

            function refresh_PtLum(){
                $.ajax({url:'loading_data.php',
                    data: {tbl: 'points_lumineux', 
                    flds:"id, id_poteau, armoire,depart,materiaux,zone, type_supp"},
                    type: 'POST',                    
                success:function(response){
                        // alert(response);
                        arPTSLUMIDs=[];
                        jsnptslum= JSON.parse(response);
                        if(lyrMarkerCluster){
                            ctlLayers.removeLayer(lyrMarkerCluster);
                            lyrMarkerCluster.remove();
                            lyrptslum.remove();
                        }
                        lyrptslum = L.geoJSON(jsnptslum, {pointToLayer:returnPtsLum, 
                                                filter:filterPtsLum});
                        arPTSLUMIDs.sort(function(a,b){return a-b});
                            $("#txtFindRaptor").autocomplete({
                            source:arPTSLUMIDs
                    });
                    lyrMarkerCluster=L.markerClusterGroup();
                    lyrMarkerCluster.clearLayers();
                    lyrMarkerCluster.addLayer(lyrptslum);
                    lyrMarkerCluster.addTo(mymap);
                    ctlLayers.addOverlay(lyrMarkerCluster, "Points Lumineux");

                        // console.log(JSON.parse(response));
                    },
                    error:function(xhr, status, error){
                        alert("ERROR: "+error);
                    }
            });
               }
                

            //  *********  jQuery Event Handlers  ************
            
            $("#btnGBH").click(function(){
               $("#lgndGBHDetail").toggle(); 
            });
            
            $("#btnLocate").click(function(){
                mymap.locate();
            });
            
            $("#btnShowLegend").click(function(){
                $("#legend").toggle();
            });
            $("#btnBackToCMS").click(function(){
                window.location.replace("admin.php");
            });
            
            //  ***********  General Functions *********
            
            function LatLngToArrayString(ll) {
                return "["+ll.lat.toFixed(5)+", "+ll.lng.toFixed(5)+"]";
            }
            
            function returnLayerByAttribute(lyr,att,val) {
                var arLayers = lyr.getLayers();
                for (i=0;i<arLayers.length-1;i++) {
                    var ftrVal = arLayers[i].feature.properties[att];
                    if (ftrVal==val) {
                        return arLayers[i];
                    }
                }
                return false;
            }
            
            function returnLayersByAttribute(lyr,att,val) {
                var arLayers = lyr.getLayers();
                var arMatches = [];
                for (i=0;i<arLayers.length-1;i++) {
                    var ftrVal = arLayers[i].feature.properties[att];
                    if (ftrVal==val) {
                        arMatches.push(arLayers[i]);
                    }
                }
                if (arMatches.length) {
                    return arMatches;
                } else {
                    return false;
                }
            }
            
            function testLayerAttribute(ar, val, att, fg, err, btn) {
                if (ar.indexOf(val)<0) {
                    $(fg).addClass("has-error");
                    $(err).html("**** "+att+" NOT FOUND ****");
                    $(btn).attr("disabled", true);
                } else {
                    $(fg).removeClass("has-error");
                    $(err).html("");
                    $(btn).attr("disabled", false);
                }
            }
            
            function returnLength(arLL) {
                var total=0;
                
                for (var i=1;i<arLL.length;i++) {
                    total = total + arLL[i-1].distanceTo(arLL[i]);
                }
                
                return total;
                
            }
            
            function returnMultiLength(arArLL) {
                var total=0;
                
                for (var i=0; i<arArLL.length;i++) {
                    total = total + returnLength(arArLL[i]);
                }
                
                return total;
            }
            
            function stripSpaces(str) {
                return str.replace(/\s+/g, '');
            }
            
         </script>
    </body>
</html>