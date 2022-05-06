function refresh_armoires(){
    $.ajax({url:'php/loading_data1.php',
    data: {tbl: 'armoires', flds:"id, id_armoire, etatarmoi,zone,variateur"},
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

function returnArmoires(json, latlng){
    var att = json.properties;
    if (att.etatarmoi=='BON') {
        var clrArmoire = 'green';
    } else {
        var clrArmoire = 'red';
    }
    arArmoireIDs.push(att.id.toString());
    return L.circle(latlng, {radius:25, color:clrArmoire,fillColor:'white', fillOpacity:0.5}).bindTooltip("<h4>ID: "+att.id+"</h4>Etat: "+att.etatarmoi);
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
function findArmoire(val) {
    returnLayerByAttribute1("armoires",'id',val, function(lyr){
    if (lyr) {
        if (lyrSearch) {
            lyrSearch.remove();
        }
        var att = lyr.feature.properties;
            switch (att.etatarmoi) {
                case 'BON':
                    var colorArmoi = 'green';
                    break;
                case 'MAUVAIS':
                    var colorArmoi = 'red';
                    break;
                    case 'TRES MAUVAIS':
                    var colorArmoi = 'blackred';
                    break;
                default:
                    var colorArmoi = 'blue';
                    break;
        }
        
        lyrSearch = L.circle(lyr.getLatLng(), {radius:20, color:colorArmoi, weight:10, opacity:0.5, fillOpacity:0}).addTo(mymap);
        mymap.setView(lyr.getLatLng(), 25);
        var att = lyr.feature.properties;
        $("#Id_armoire").val(att.id_armoire);
        $("#zone").val(att.zone);
        $("#etat_armoire").val(att.etatarmoi);
        $("#armoireMetaData").html("Created" +att.created + " by" + att.createdby +"<br>Modified "+att.modified+" by "+att.modifiedby);
        $("#formArmoires").show();
        
        
        $.ajax({
                url:'php/loading_data1.php',
                data: {tbl: 'armoires', 
                flds:'id, id_armoire, zone, etat_foyer, puissance'},
                type: 'POST',                    
            success:function(response){
             },
            error:function(xhr, status, error){
                $("#divEagleError").html("ERROR: "+error);
            }
        });
        
    $("#divEagleError").html("");

    $("#btnarmoiresurveys").show();

    } else {
            $("#divEagleError").html("**** Habitat ID not found ****");
        }
    });
                    
}

//Must define a findArmoire function so we can use it to the btnFindEagle button.

