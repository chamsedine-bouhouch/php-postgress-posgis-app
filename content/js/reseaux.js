function refresh_Reseau(){
    $.ajax({url:'php/loading_data1.php',
        data: {tbl: 'reseaux', 
        flds:'id, type, section, depart'},
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

function findReseau(val) {
    returnLayerByAttribute1("reseaux",'id',val, function(tbl){
    if (tbl) {
        if (lyrSearch) {
            lyrSearch.remove();
        }
        lyrSearch = L.geoJSON(tbl.toGeoJSON(), {style:{color:'red', weight:10, opacity:0.5}}).addTo(mymap);
        mymap.fitBounds(tbl.getBounds().pad(1));
        var att = tbl.feature.properties;
        $("#Id_reseau").val(att.id);
        $("#type_reseau").val(att.type);
        $("#section_reseau").val(att.section);
        $("#reseau_lastsurvey").val(att.lastsurvey);
        $("#reseau_geojson").val(JSON.stringify(tbl.feature.geometry));
        // $("#reseau_geojson").val(tbl.feature.geometry);
        $("#reseauMetaData").html("Created" +att.created + " by" + att.createdby +"<br>Modified "+att.modified+" by "+att.modifiedby);
        $("#ReseauGeoJSON").hide();
        $("#formReseau").show();
        $.ajax({
                url:'php/loading_data1.php',
                data: {tbl: 'reseaux', 
                flds:'id, type, section, depart'},
                type: 'POST',                    
            success:function(response){
                // $("#divBUOWLaffected").html(response);
            },
            error:function(xhr, status, error){
                // $("#divBUOWLaffected").html("ERROR: "+error);
            }
        });
        
    $("#divProjectError").html("");

    $("#btnreseauInsert").hide();
    $("#btnreseausurveys").show();
    $("#btnEditReseau").show();
    $("#btnDeleteReseau").show();

} else {
    $("#divProjectError").html("**** Armoire ID not found ****");
}
});
            
}

function styleReseaux(json) {
    var fld = json.properties;
    switch (fld.type) {
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

function processReseaux(json, tbl) {
    var fld = json.properties;
    tbl.bindTooltip("<h4>Linear ID: "+fld.id+"</h4>Type: "+fld.type+"<br>Section: "+fld.section);
    arReseaux.push(fld.id.toString());
     
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