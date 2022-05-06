<?php include("includes/init.php");
      if (logged_in()) {
         $username=$_SESSION['username'];
         if (!verify_user_group($pdo, $username, "Tadaeem Editors")) {
            set_msg("User '{$username}' does not have permission to view this page");
            redirect('../index.php');
        }
    } else {
        set_msg("Please log-in and try again");
        redirect('../index.php');
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
        <link rel="stylesheet" href="src/plugins/Leaflet.PolylineMeasure.css">
        <link rel="stylesheet" href="src/plugins/easy-button.css">
        <link rel="stylesheet" href="src/css/font-awesome.min.css">
        <link rel="stylesheet" href="src/plugins/leaflet.awesome-markers.css">
        <link rel="stylesheet" href="src/plugins/MarkerCluster.css">
        <link rel="stylesheet" href="src/plugins/MarkerCluster.Default.css">
        <link rel="stylesheet" href="src/plugins/leaflet-legend.css">
        <link rel="stylesheet" href="src/jquery-ui.min.css">
        <link rel="stylesheet" href="src/leaflet-pm.css">
        <link rel="stylesheet" href="src/plugins/leaflet-sidebar-v2-master/css/leaflet-sidebar.min.css">
        <link rel="stylesheet" href="tadaeem_style.css">

        <script src="src/leaflet.js"></script>
        <script src="src/jquery-3.3.1.min.js"></script>
        <script src="src/plugins/L.Control.MousePosition.js"></script>
        <script src="src/plugins/Leaflet.PolylineMeasure.js"></script>
        <script src="src/plugins/easy-button.js"></script>
        <script src="src/plugins/leaflet-providers.js"></script>
        <script src="src/plugins/leaflet.ajax.min.js"></script>
        <script src="src/plugins/leaflet.awesome-markers.min.js"></script>
        <script src="src/plugins/leaflet.markercluster.js"></script>
        <script src="src/plugins/leaflet-legend.js"></script>
        <script src="src/jquery-ui.min.js"></script>
        <script src="src/turf.min.js"></script>
        <script src="src/leaflet-pm.min.js"></script>
        <script src="src/plugins/leaflet-sidebar-v2-master/js/leaflet-sidebar.min.js"></script>
        <script src="js/general_functions.js"></script>
        <script src="js/js_surveys.js"></script>
        <script src="js/armoires.js"></script>
        <script src="js/foyers.js"></script>
        <script src="js/pts_lumineux.js"></script>
        <script src="js/reseaux.js"></script>

        
    </head>
    <body>
        <div id="sidebar" class="leaflet-sidebar collapsed">

<!-- nav tabs -->
<div class="leaflet-sidebar-tabs">
    <!-- top aligned tabs -->
    <ul role="tablist">
        <li><a href="#home" role="tab"><i class="fa fa-home active"></i></a></li>
        <li><a href="#legend" role="tab"><i class="fa fa-server"></i></a></li>
        <li><a href="#reseaux" role="tab"><i class="fa fa-gavel"></i></a></li>
        <li><a href="#ptlums" role="tab"><i class="fa fa-cubes"></i></a></li>
        <li><a href="#foyers" role="tab"><i class="fa fa-snowflake-o "></i></a></li>
        <li><a href="#armoires" role="tab"><i class="fa fa-tree"></i></a></li>
        

    </ul>

    <!-- bottom aligned tabs -->
    <ul role="tablist">
        <li><a href="#settings"><i class="fa fa-gear"></i></a></li>
    </ul>
</div>

<!-- panel content -->
<div class="leaflet-sidebar-content">
    <div class="leaflet-sidebar-pane" id="home">
   
        <h1 class="leaflet-sidebar-header">
            Home
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
        <button id='btnLocate' class='btn btn-primary btn-block'>Locate</button>
        <button id="btnZoomTadaeem" class='btn btn-primary btn-block'>Zoom to Project</button>
        <button id="btnReturnToCMS" class='btn btn-primary btn-block'>Return to CMS</button>

         
    </div>

    <div class="leaflet-sidebar-pane" id="legend">
        <h1 class="leaflet-sidebar-header">Legend
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
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
    </div>
    <div class="leaflet-sidebar-pane" id="reseaux">
        <h1 class="leaflet-sidebar-header">Reseaux
            <button id="btnAddReseau" class="btn btn-success"><i class="fa fa-plus"></i></button>
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
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
                <div class="" id="divProjectData">
                    <form class="form-horizontal" id="formReseau">
                        <div class="form-group">
                            <label for="id" class="control-label col-sm-3">ID Reseau</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control inpReseau" name="id" id="Id_reseau" placeholder="ID SUPPORT" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="control-label col-sm-3">Type</label>
                            <div class="col-sm-9">
                                <select class="form-control inpReseau" name="type" id="type_reseau" disabled>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="section" class="control-label col-sm-3">Section</label>
                            <div class="col-sm-9">
                                <select class="form-control inpReseau" name="section" id="section_reseau" disabled>
                                
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="section" class="control-label col-sm-3">Last Survey</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control inpReseau" name="lastsurvey" id="reseau_lastsurvey" placeholder="Last Survey" readonly>
                            </div>
                            <div class="col-sm-2">
                                <span id="btnToggleReseauGeometry"><i class="fa fa-globe fa-2x" title="Show feature geometry"></i></span>
                            </div>
                        </div>
                        <div id="ReseauGeoJSON" class="form-group featureGeometry">
                                <label for="geojson" class="control-label col-sm-3">
                                    <span id="btnEditReseauGeometry"><i class="fa fa-pencil fa-2x" title="Edit feature geometry"></i></span>GeoJSON:
                                </label>
                                <div class="col-sm-9">
                                    <textarea class="form-control inpReseau" name="geojson" id="reseau_geojson" placeholder="GeoJSON" disabled></textarea>
                                </div>
                        </div>
                        <div id="reseauMetaData" class="col-xs-9"></div>
                        <div class="col-xs-6">
                            <span id="btnEditReseau"><i class="fa fa-pencil fa-2x"></i></span>
                            <span id="btnDeleteReseau"><i class="fa fa-trash fa-2x pull-left" title="Delete feature"></i></span>
                        </div>
                    </form>
                    <button id="submitReseau" class="btn btn-primary btn-submit btn-block">Submit</button>
                    <button id="btnreseauUpdate" class="btnSurveys btn btn-warning btn-submit btn-block">Update Depart</button>
                    <button id="btnreseauInsert" class="btnSurveys btn btn-success btn-submit btn-block">Insert Depart</button>
                    <button id="btnreseausurveys" class="btnSurveys btn btn-primary btn-submit btn-block">Show Survey</button>
                </div>
            </div>
    </div> 
    <div class="leaflet-sidebar-pane" id="ptlums">
        <h1 class="leaflet-sidebar-header">Points Lumineux
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
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
                <div class="" id="divRaptorData">
                    <form class="form-horizontal" id="formPtLums">
                            <div class="form-group">
                                <label for="id_ptlum" class="control-label col-sm-3">ID Support</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpSupports" name="id_poteau" id="Id_poteau" placeholder="ID SUPPORT" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="control-label col-sm-3">Armoire</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpSupports" name="type" id="armoire" placeholder="Type" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="materiaux" class="control-label col-sm-3">Materiaux</label>
                                <div class="col-sm-9">
                                    <select class="form-control inpSupports" name="materiaux" id="materiaux" disabled>

                                    </select>
                                </div>
                            </div>
                             <div class="form-group">
                                <label for="depart" class="control-label col-sm-3">Last Survey</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpSupports" name="lastsurvey" id="last_survey" placeholder="Last Survey" readonly>
                                </div>
                            </div>

                           
                            <div id="poteauMetaData"></div>
                            <div class="col-xs-6">
                                <span id="btnEditSupports"><i class="fa fa-pencil fa-2x" title="Edit this feature"></i></span>
                                <span id="btnDeleteSupports"><i class="fa fa-trash fa-2x pull-left"></i></span>
                            </div>

                        </form>
                        <button id="submitPoteau" class="btn btn-primary btn-submit btn-block">Submit</button>
                        <button id="btnptsLumsurveys" class="btnSurveys btn btn-primary btn-submit btn-block">Show Survey</button>
                </div>
            </div>   
    </div>
    <div class="leaflet-sidebar-pane" id="foyers">
        <h1 class="leaflet-sidebar-header">Foyers
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
        <div id="divBUOWL" class="col-xs-12">
                <div id="divBUOWLLabel" class="text-center col-xs-12">
                    <h4 id="lblBUOWL">FOYERS</h4>
                </div>
                <div id="divBUOWLError" class="errorMsg col-xs-12"></div>
                <div id="divFindBUOWL" class="form-group has-error">
                    <div class="col-xs-6">
                        <input type="text" id="txtFindBUOWL" class="form-control" placeholder="ID FOYER">
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
                <div class="" id="divBUOWLData">
                    <form class="form-horizontal" id="formFoyers">
                            <div class="form-group featureID">
                                <label for="id_foyer" class="control-label col-sm-3">ID Foyer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpFoyer" name="id_foyer" id="Id_foyer" placeholder="ID Foyer" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="control-label col-sm-3">Catégorie</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpFoyer" name="typ_foyer" id="typ_foyer" placeholder="Type Foyer" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="depart" class="control-label col-sm-3">Type Lampe</label>
                                <div class="col-sm-9">
                                    <select class="form-control inpFoyer" name="typ_lampe" id="type_lampe" disabled>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="depart" class="control-label col-sm-3">Last Survey</label>
                                <div class="col-sm-9">
                                    <input type="date" class="form-control inpFoyer" name="lastsurvey" id="last_survey" placeholder="Last Survey" readonly>
                                </div>
                            </div>
                            <div id="FoyerGeoJSON" class="form-group">
                                <label for="geojson" class="control-label col-sm-3">GeoJSON:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control inpFoyer" name="geojson" id="foyer_geojson" placeholder="GeoJSON" disabled></textarea>
                                </div>
                            </div>
                            <div id="foyerMetaData"></div>
                            <div class="col-xs-6">
                                <span id="btnEditFoyer"><i class="fa fa-pencil fa-2x"></i></span>
                                <span id="btnDeleteFoyer"><i class="fa fa-trash fa-2x pull-left"></i></span>
                            </div>

                    </form>
                    <div  id="divBUOWLaffected"></div>

                <button id="submitFoyer" class="btn btn-primary btn-submit btn-block">Submit</button>
                <button id="btnFoyerssurveys" class="btnSurveys btn btn-primary btn-submit btn-block">Show Survey</button>

            </div>
        </div>
    </div>
    <div class="leaflet-sidebar-pane" id="armoires">
        <h1 class="leaflet-sidebar-header">Armoires
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
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
                <div class="" id="divEagleData">
                <form class="form-horizontal" id="formArmoires">
                            <div class="form-group featureID">
                                <label for="id_armoire" class="control-label col-sm-3">ID Armoire</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpArmoire" name="id_armoire" id="Id_armoire" placeholder="ID ARMOIRE" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type" class="control-label col-sm-3">Zone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpArmoire" name="zone" id="zone" placeholder="Zone" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="depart" class="control-label col-sm-3">Etat Armoire</label>
                                <div class="col-sm-9">
                                    <select class="form-control inpArmoire" name="etatarmoi" id="etat_armoire" readonly>
                                    
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="depart" class="control-label col-sm-3">Last Survey</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control inpArmoire" name="lastsurvey" id="last_survey" placeholder="Last Survey" readonly>
                                </div>
                            </div>
                            <div id="ArmoireGeoJSON" class="form-group">
                                <label for="geojson" class="control-label col-sm-3">GeoJSON:</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control inpArmoire" name="geojson" id="armoire_geojson" placeholder="GeoJSON" disabled></textarea>
                                </div>
                            </div>
                            <div id="armoireMetaData"></div>
                            <div class="col-xs-6">
                                <span id="btnEditArmoire"><i class="fa fa-pencil fa-2x"></i></span>
                                <span id="btnDeleteArmoire"><i class="fa fa-trash fa-2x pull-left"></i></span>
                            </div>
                            </form>
                            <button id="submitArmoire" class="btn btn-primary btn-submit btn-block">Submit</button>
                            <button id="btnarmoiresurveys" class="btnSurveys btn btn-primary btn-submit btn-block">Show Survey</button>

                </div>
            </div>
            <div class="leaflet-sidebar-pane" id="settings">
   
        <h1 class="leaflet-sidebar-header">
            Settings
            <span class="leaflet-sidebar-close"><i class="fa fa-caret-left"></i></span>
        </h1>
        <div id="loginInfo">
            <button id="btnLogout" class="btn btn-primary btn-block">Logout</button>
        </div>
        <button id='btnLocate' class='btn btn-primary btn-block'>Locate</button>
        <button id="btnZoomTadaeem" class='btn btn-primary btn-block'>Zoom to Project</button>

         
    </div>

    </div>
</div>
</div>
        <div id="mapdiv" class="col-md-12"></div>
        <div id="dlgModal" class="modal">
                    <div id="dlgContent" class="modal-content col-sm-10 col-sm-offset-1 col-md-7 col-md-offset-4">
                        <span id="btnCloseModal" class="pull-right"><i class="fa fa-close fa-2x"></i></span>
                        <div id="tableData"></div>
                        <form id="formSurvey">
                            <div class="col-xs-12">
                                <div class="form-group">
                                    <label for="survey_id" class="control-label col-sm-3">ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control inpSurvey" name="id" id="survey_id" placeholder="ID" readonly>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="survey_surveyor" class="control-label col-sm-3">Surveyor</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control inpSurvey" name="surveyor" id="survey_surveyor" placeholder="Surveyor" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="survey_surveydate" class="control-label col-sm-3">Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" class="form-control inpSurvey" name="date" id="survey_date" placeholder="Survey Date">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="survey_result" class="control-label col-sm-3">Result</label>
                                    <div class="col-sm-9">
                                        <select class="form-control inpSurvey" name="result" id="survey_result">
                                            <option value="AE">AE</option>
                                            <option value="ST">ST</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="survey_createdby" class="control-label col-sm-3">Created By</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control inpSurvey" name="createdby" id="survey_createdby" placeholder="Created By">
                                    </div>
                                </div>
                                
                                <div id="formSurveyButtons"></div>
                            </div>
                        </form>
                    </div>
        </div>
        <script>
           var user;
            $.ajax({
                url:'php/return_user.php',
                success:function(response){
                    if (response.substring(0,5)=="ERROR") {
                        alert(response);
                    } else {
                        user=JSON.parse(response);
                        alert("User logged in as "+user.firstname+" "+user.lastname);
                    }
                }
            });
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
                
                mymap = L.map('mapdiv', {center:[35.89112, 8.55228], zoom:14, attributionControl:false, zoomControl:false});
                
                ctlSidebar = L.control.sidebar('sidebar').addTo(mymap);

                ctlAttribute = L.control.attribution({position:'bottomright'}).addTo(mymap);
                ctlAttribute.addAttribution('OSM');
                ctlAttribute.addAttribution('&copy; <a href="http://geomatics-engineering.com">Geomatics Engineering</a>');
                
                ctlScale = L.control.scale({position:'bottomright', metric:false, maxWidth:200}).addTo(mymap);

                ctlMouseposition = L.control.mousePosition({position:'bottomright'}).addTo(mymap);
                
                
                //   *********** Layer Initialization **********
                
                lyrOSM = L.tileLayer.provider('OpenStreetMap.Mapnik');
                lyrTopo = L.tileLayer.provider('OpenTopoMap');
                lyrImagery = L.tileLayer.provider('Esri.WorldImagery');
                lyrOutdoors = L.tileLayer.provider('Thunderforest.Outdoors');
                lyrWatercolor = L.tileLayer.provider('Stamen.Watercolor');
                mymap.addLayer(lyrOSM);
                
                 
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
                
                
                $(".legend-container").append($("#legend"));
                $(".legend-toggle").append($("<i class='legend-toggle-icon fa fa-server fa-2x' style='color:#000'></i>"));
                // ************ Location Events **************
                
                ctlZoom = L.control.zoom({position:'topright'}).addTo(mymap);
                // define toolbar options
                var options = {
                position: 'topright', // toolbar position, options are 'topleft', 'topright', 'bottomleft', 'bottomright'
                drawMarker: true, // adds button to draw markers
                drawPolyline: true, // adds button to draw a polyline
                drawRectangle: false, // adds button to draw a rectangle
                drawPolygon: true, // adds button to draw a polygon
                drawCircle: false, // adds button to draw a cricle
                cutPolygon: false, // adds button to cut a hole in a polygon
                editMode: false, // adds button to toggle edit mode for all layers
                removalMode: false, // adds a button to remove layers
                };
                
                // add leaflet.pm controls to the map
                mymap.pm.addControls(options);

                // listen to when a new layer is created
                mymap.on('pm:create', function(e) {
                    var jsn = e.layer.toGeoJSON().geometry;
                    if(isShowing("btnreseauInsert") && e.shape=="Line"){
                        if(confirm("Are you sure you want to add this geometry?")){
                            jsn={type:"MultiLineString",coordinates:[jsn.coordinates]};
                            $("#reseau_geojson").val(JSON.stringify(jsn));
                            var jsn=returnFormDate("inpReseau");
                            jsn.tbl="reseaux";
                            delete jsn.id;
                            insertRecord(jsn, function(){
                                refresh_Reseau();
                                $("#formReseau").hide();
                                $("#btnreseauInsert").hide();
                                $("#txtFindProject").val("");
                            });
                        }

                    }else{

                    }
                    // e.shape; // the name of the shape being drawn (i.e. 'Circle')
                    // e.layer; // the leaflet layer created
                    // console.log(e.layer.toGeoJSON());
                    // var jsn = e.layer.toGeoJSON().geometry;
                // alert("Type: "+e.shape+"\n Geometry: "+JSON.stringify(jsn));
            
              
                });
                
                ctlMeasure = L.control.polylineMeasure({position:'topright'}).addTo(mymap);


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
            $("#txtFindBUOWL").on('keyup paste', function(){
                var val = $("#txtFindBUOWL").val();
                testLayerAttribute(arFoyersID, val, "ID Foyer", "#divFindBUOWL", "#divBUOWLError", "#btnFindBUOWL");
            });
            
            $("#btnFindBUOWL").click(function(){
        
                findFoyer($("#txtFindBUOWL").val());

            });
            
            $("#lblBUOWL").click(function(){
                $("#divBUOWLData").toggle(); 
            });
            
            $("input[name=fltFoyer]").click(function(){
                
                refresh_Foyers();
            });
            
            
            // ************ Réseaux Linears **********
            
            $("#btnAddReseau").click(function(){
                alert("Adding a new feature?");
                $("#txtFindProject").val("New");
                $("#Id_reseau").val("New");
                $("#type_reseau").val("");
                $("#section_reseau").val("");
                $("#reseau_lastsurvey").val();
                $("#reseau_geojson").val("");
                $("#reseauMetaData").html("");
                $(".inpReseau").attr("disabled",false);
                $("#Id_reseau").attr("disabled",true);
                $("#reseau_geojson").attr("disabled",true);
                $("#reseau_lastsurvey").attr("readonly",false);
                $("#ReseauGeoJSON").hide();
                $("#btnreseauInsert").show();
                $("#btnreseauUpdate").hide();
                $("#btnEditReseau").hide();
                $("#btnDeleteReseau").hide();
                $("#formReseau").show();
            });
            $("#btnreseauInsert").click(function(){
                if($("#reseau_geojson").val()==""){
                    alert("No geometry has been added");
                }else if (($("#type_reseau").val()=="")||
                          ($("#section_reseau").val()=="")||
                          ($("#reseau_lastsurvey").val()=="")){
                              alert("Please fill out all fields");
                          }else{
                            //   alert("Sending data to database");
                            var jsn = returnFormDate("inpReseau");
                            jsn.tbl="reseaux";
                            delete jsn.id;
                            insertRecord(jsn, function(){
                                refresh_Reseau();
                                $("#formReseau").hide();
                                $("#btnreseauInsert").hide();
                                $("#textFindReseau").val();
                            });
                          }
                // alert("Adding new feature to the database");
            });

            function insertRecord(jsn, callback){
                delete jsn.id;
                // alert("Inserting the following data into "+jsn.tbl+"\n\n"+JSON.stringify(jsn));
                $.ajax({
                    url:'php/insert_record.php',
                    data:jsn,
                    type:'POST',
                    success:function(response){
                        if(response.substr(0,5)=="ERROR"){
                            alert(response);
                        }else{
                            // alert("New record added to " +jsn.tbl+"\n\n "+response);
                            alert("New record added to " +jsn.tbl+"\n\n ");
                            callback();
                            
                        }
                    },
                    error: function(xhr, status, error){
                        alert("AJAX Error: "+error);
                    }
                })
            }

            $("#btnLinearProjects").click(function(){
               $("#lgndLinearProjectsDetail").toggle(); 
            });
            
            $("#txtFindProject").on('keyup paste', function(){
                var val = $("#txtFindProject").val();
                testLayerAttribute(arReseaux, val, "ID DEPART", "#divFindProject", "#divProjectError", "#btnFindProject");
            });
            
            $("#btnFindProject").click(function(){
                findReseau($("#txtFindProject").val());
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
                 
                refresh_Reseau();
            });

            $("#btnToggleReseauGeometry").click(function(){
                $("#ReseauGeoJSON").toggle();
            })

            $("#btnEditReseau").click(function(){
                $(".inpReseau").attr("disabled",false);
                $("#Id_reseau").attr("readonly",true);
                $("#reseau_lastsurvey").attr("readonly",false);
                $("#reseau_geojson").attr("disabled",true);
                $("#btnreseauUpdate").show();
                $("#ReseauGeoJSON").show(); 


                // alert("Editing resesau "+$("#txtFindProject").val()+"?")            

            });
            $("#btnEditReseauGeometry").click(function(){
                if(isShowing("btnreseauUpdate")){
                    // alert("Start editing Reseau layer.");
                     var jsnMulti=JSON.parse($("#reseau_geojson").val());
                    // alert(JSON.stringify(jsnMulti));
                     var jsnSingle={type:'LineString',
                                    coordinates:jsnMulti.coordinates[0]};
                    // alert(JSON.stringify(jsnSingle));
                    var lyrEdit=L.geoJSON(jsnSingle).addTo(mymap);
                    lyrEdit.pm.enable();
                    mymap.on('contextmenu',function(){
                        if(confirm("Are you sure you want to update the geometry for this feature?")){
                            // $("#reseau_geojson").attr("disabled",false);
                            var jsnEdited=lyrEdit.toGeoJSON();
                            jsnEdited=jsnEdited.features[0].geometry;
                            jsnEdited={type:'MultiLineString',coordinates:[jsnEdited.coordinates]};
                            alert(JSON.stringify(jsnEdited));
                            $("#reseau_geojson").val(JSON.stringify(jsnEdited));
                            lyrEdit.pm.disable();
                            mymap.off('contextmenu');
                            // $("#reseau_geojson").attr("disabled",true);
                        }
                    })
                }else if(isShowing("btnreseauInsert")){
                    mymap.pm.enableDraw('Line',{finishOn:'contextmenu'});
                    alert("Creating new Geometry");
            }else{
                alert("Editing not enabled");
            }
                
            });
                // lyrEdit.remove();
            
                    

            

            $("#btnreseauUpdate").click(function(){
                var jsn = returnFormDate('inpReseau');
                jsn.tbl="reseaux";
                // alert("Updating Reseau record " + jsn.id+" with \n\n" + JSON.stringify(jsn));
                alert("Updating Reseau record " + jsn.id+" with \n\n");
                updateRecord(jsn, function(){
                    refresh_Reseau();
                    $("#formReseau").hide();
                    $("#txtFindProject").val("");
                    lyrSearch.remove();
                });
                $(".inpReseau").attr("disabled",true);

            })
            
            $("#btnDeleteReseau").click(function(){
                var id=$("#txtFindProject").val();
                if(confirm("Are you sure we want to delete resesau "+id+" ?")){
                    deleteRecord("reseaux",id);
                    $("#formReseau").hide();
                    $("#reseauMetaData").html("");
                    $("#txtFindProject").val("");
                    $("#btnreseausurveys").hide();

                    lyrSearch.remove();
                    // lyrEdit.remove();
                }            
            });
            
            $("#btnEditArmoire").click(function(){
                $(".inpArmoire").attr("readonly",false)
                $("#Id_armoire").attr("readonly",true)
                alert("Editing armoires"+$("#txtFindEagle").val()+"?")
            });
            
            $("#btnDeleteArmoire").click(function(){
                alert("Deleting armoires "+$("#txtFindEagle").val()+"?");
                var id=$("#txtFindEagle").val();
                if(confirm("Are you sure we want to delete armoire "+id+" ?")){
                    deleteRecord("armoires",id);
                    $("#formArmoires").hide();
                    $("#armoireMetaData").html("");
                    $("#txtFindEagle").val("");
                    $("#btnarmoiresurveys").hide();

                    lyrSearch.remove();
                }
           
            });
            $("#btnEditSupports").click(function(){
                $(".inpSupports").attr("readonly",false)
                $(".inpSupports").attr("disabled",false)
                $("#Id_poteau").attr("readonly",true)
                alert("Editing Supports"+$("#txtFindRaptor").val()+"?")
            });
            
            $("#btnDeleteSupports").click(function(){
                alert("Deleting Supports"+$("#txtFindRaptor").val()+"?")            
            });
            $("#btnEditFoyer").click(function(){
                $(".inpFoyer").attr("readonly",false)
                $(".inpFoyer").attr("disabled",false)
                // $(".inpFoyer").attr("readonly",true)
                alert("Editing Supports"+$("#txtFindRaptor").val()+"?")
            });
            
            $("#btnDeleteFoyer").click(function(){
                alert("Deleting Supports"+$("#txtFindRaptor").val()+"?")            
            });
            
            function deleteRecord(tbl, id){
                // alert("Deleting "+id+" from "+tbl);
                $.ajax({
                    url:'php/delete_record.php',
                    data:{tbl:tbl, id:id},
                    type:'POST',
                    success:function(response){
                        if(response.substr(0,5)=="ERROR"){
                            alert(response);
                        }else{
                            alert("Record "+id+" deleted from "+tbl+"\n\n "+response);
                            switch(tbl){
                                case "reseaux":
                                    refresh_Reseau();
                                    break;
                                // case "points_lumineux":
                                //     refresh_PtLum();
                                //     break;
                                // case "foyers":
                                //     refresh_Foyers();
                                case "armoires":
                                    refresh_armoires();

                            }
                        }
                    },
                    error: function(xhr, status, error){
                        alert("ERROR: "+error)
                    }
                })

            }
            function updateRecord(jsn, callback){
                $.ajax({
                    url:'php/update_record.php',
                    data:jsn,
                    type:'POST',
                    success:function(response){
                        if(response.substr(0,5)=="ERROR"){
                            alert(response);
                        }else{
                            // alert("Record " +jsn.id+" in " +jsn.tbl+" updated" +"\n\n "+response);
                            alert("Record " +jsn.id+" in " +jsn.tbl+" updated" +"\n\n ");
                            callback();
                            
                        }
                    },
                    error: function(xhr, status, error){
                        alert("ERROR: "+error)
                    }
                })
            }
            
            // *********  Armoires Functions *****************
            
            $("#btnEagle").click(function(){
               $("#lgndEagleDetail").toggle(); 
            });
            $("#txtFindEagle").on('keyup paste', function(){
                var val = $("#txtFindEagle").val();
                testLayerAttribute(arArmoireIDs, val, "ID Armoire", "#divFindEagle", "#divEagleError", "#btnFindEagle");
            });


            
            $("#btnFindEagle").click(function(){
               
                findArmoire($("#txtFindEagle").val());

            });

            $("#lblEagle").click(function(){
                $("#divEagleData").toggle(); 
            });
            
            $("input[name=fltArmoire]").click(function(){
               
                refresh_armoires();
            });
            //  *********** Points Lumineux Functions
            $("#btnRaptor").click(function(){
               $("#lgndRaptorDetail").toggle(); 
            });
            $("#txtFindRaptor").on('keyup paste', function(){
                var val = $("#txtFindRaptor").val();
                testLayerAttribute(arPTSLUMIDs, val, "ID POTEAU", "#divFindRaptor", "#divRaptorError", "#btnFindRaptor");
            });
            
            $("#btnFindRaptor").click(function(){
                findPtsLum($("#txtFindRaptor").val());
                

            });
            
            $("#lblRaptor").click(function(){
                $("#divRaptorData").toggle(); 
            });
            
            $("input[name=fltPtLum]").click(function(){
                 
                refresh_PtLum();
            });

            $("#btnCloseModal").click(function(){
                $("#dlgModal").hide();
            })

            
            $("#btnreseausurveys").click(function(){
                changeOptions("survey_result","reseaux_survey","result")
                displaySurveys("reseaux_survey",$("#txtFindProject").val());
            });
            $("#btnFoyerssurveys").click(function(){
                displaySurveys("foyer_survey",$("#txtFindBUOWL").val());
            });
            $("#btnptsLumsurveys").click(function(){
                displaySurveys("pts_lums_survey",$("#txtFindRaptor").val());
            });
            $("#btnarmoiresurveys").click(function(){
                changeOptions("survey_result","armoire_survey","result")
                displaySurveys("armoire_survey",$("#txtFindEagle").val());
            });

            //  *********  jQuery Event Handlers  ************
            
            $("#btnGBH").click(function(){
               $("#lgndGBHDetail").toggle(); 
            });
            
            $("#btnLocate").click(function(){
                mymap.locate();
            });
            
            $("#btnZoomTadaeem").click(function(){
                mymap.setView([35.89112, 8.55228],14);
            });
            
            $("#btnReturnToCMS").click(function(){
                window.location.replace("admin.php");

            });

            changeOptions("type_reseau","reseaux","type");
            changeOptions("section_reseau","reseaux","section");
            changeOptions("etat_armoire","armoires","etatarmoi");
            changeOptions("materiaux","points_lumineux","materiaux");
            changeOptions("type_lampe","foyers","typ_lampe");

            $("#btnLogout").click(function(){
                // window.location="../logout.php";

            })
        
         </script>
    </body>
</html>