function refresh_Foyers(){
    $.ajax({url:'php/loading_data1.php',
        data: {tbl: 'foyers', 
        flds:'id_foyer, typ_foyer, typ_lampe, etat_foyer'},
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
                $("#txtFindBUOWL").autocomplete({
                source:arFoyersID
        });
            // console.log(JSON.parse(response));
            // lyrFoyer.bringToFront();
        },
        error:function(xhr, status, error){
            alert("ERROR: "+error);
        }
    });
}

function findFoyer(val) {
    returnLayerByAttribute1("foyers",'id_foyer',val, function(lyr){
    if (lyr) {
        if (lyrSearch) {
            lyrSearch.remove();
        }
        var att = lyr.feature.properties;
            switch (att.typ_lampe) {
                case 'SHP':
                    var radRaptor = 25;
                    break;
                case 'HPL':
                    var radRaptor = 20;
                    break;
                    case 'LED':
                    var radRaptor = 15;
                    break;
                default:
                    var radRaptor = 10;
                    break;
        }
        
        lyrSearch = L.circle(lyr.getLatLng(), {radius:radRaptor, color:'red', weight:10, opacity:0.5, fillOpacity:0}).addTo(mymap);
        mymap.setView(lyr.getLatLng(), 25);
        var att = lyr.feature.properties;
        $("#Id_foyer").val(att.id_foyer);
        $("#typ_foyer").val(att.typ_foyer);
        $("#typ_lampe").val(att.typ_lampe);
        $("#foyerMetaData").html("Created" +att.created + " by" + att.createdby +"<br>Modified "+att.modified+" by "+att.modifiedby);
        $("#formFoyers").show();
        
        $.ajax({
                url:'php/loading_data1.php',
                data: {tbl: 'foyers', 
                flds:'id_foyer, typ_lampe, etat_foyer, puissance'},
                type: 'POST',                    
            success:function(response){
             },
            error:function(xhr, status, error){
                $("#divBUOWLaffected").html("ERROR: "+error);
            }
        });
        
    $("#divBUOWLError").html("");

    $("#btnFoyerssurveys").show();

    } else {
            $("#divBUOWLError").html("**** Habitat ID not found ****");
        }
    });
                    
}

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