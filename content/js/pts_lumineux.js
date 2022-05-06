function refresh_PtLum(){
    $.ajax({url:'php/loading_data1.php',
        data: {tbl: 'points_lumineux', 
        flds:"id, id_poteau, armoire,depart,materiaux"},
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

         },
        error:function(xhr, status, error){
            alert("ERROR: "+error);
        }
    });
}

function findPtsLum(val) {
    returnLayerByAttribute1("points_lumineux",'id_poteau',val, function(lyr){
    if (lyr) {
        if (lyrSearch) {
            lyrSearch.remove();
        }
        var att = lyr.feature.properties;
            switch (att.materiaux) {
                case 'ACIER':
                    var colorptsLum = "red";
                    break;
                case 'BETON':
                    var colorptsLum = "black";
                    break;
                    case 'CONDELABRE':
                    var colorptsLum = "blue";
                    break;
                default:
                    var colorptsLum = "gray";
                    break;
        }
        
        lyrSearch = L.circle(lyr.getLatLng(), {radius:20, color:colorptsLum, weight:10, opacity:0.5, fillOpacity:0}).addTo(mymap);
        mymap.setView(lyr.getLatLng(), 25);
        var att = lyr.feature.properties;
        $("#Id_poteau").val(att.id_poteau);
        $("#armoire").val(att.armoire);
        $("#materiaux").val(att.materiaux);
        $("#poteauMetaData").html("Created" +att.created + " by" + att.createdby +"<br>Modified "+att.modified+" by "+att.modifiedby);
        $("#formPtLums").show();
        
        $.ajax({
                url:'php/loading_data1.php',
                data: {tbl: 'points_lumineux', 
                flds:'id_poteau, zone, armoire, materiaux'},
                type: 'POST',                    
            success:function(response){
             },
            error:function(xhr, status, error){
                $("#divRaptorError").html("ERROR: "+error);
            }
        });
        
    $("#divRaptorError").html("");

    $("#btnptsLumsurveys").show();

    } else {
            $("#divRaptorError").html("**** Habitat ID not found ****");
        }
    });
                    
}

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
    return L.circle(latlng, optptsLum).bindPopup("<h4>ID Poteau: "+att.id+"</h4>Matériaux: "+att.materiaux+"<br>Depart: "+att.depart+"<br>Armoire: "+att.armoire+"<br>Type: "+att.type_supp);
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