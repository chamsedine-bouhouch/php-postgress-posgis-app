function displaySurveys(tbl ,id){
    $.ajax({
        url:'php/load_surveys.php',
        data:{tbl:tbl, id:id},
        type:'POST',
        success:function(response){
            $("#formSurvey").hide();
            $("#tableData").html(response);
            $("#tableData").append("<button id='btnInsertSurvey' class='btn btn-success'>Add New Survey</button>");
            $("#btnInsertSurvey").click(function(){
                insertSurvey(tbl, id);
             })
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
    

    function submitSurveys(tbl, id){
        var jsnFormData=returnFormDate('inpSurvey');
        jsnFormData.tbl=tbl;
        delete jsnFormData.id;
        alert("Updating survey "+survey_id+ " in "+tbl +"\n\n"+JSON.stringify(jsnFormData));
        $.ajax({
            url:'php/insert_record.php',
            data:jsnFormData,
            type:'POST',
            success:function(response){
                if(response.substring(0,5)=="ERROR"){
                    alert(response);
                }else{
                    alert(response);
                    displaySurveys(tbl,id);
            }
        },
            error:function(xhr,status, error){
                $("#tableData").html("ERROR: "+error);
                $("#dlgModal").show();
            }

        })
    }
    
    function editSurvey(tbl, id, survey_id){
        alert("Editing "+tbl +" Survey "+id+ " for constaint "+survey_id);
        returnRecordsByID(tbl, id, function(jsn){
        if(jsn){
                $("#survey_id").val(id);
                $("#survey_surveyor").val(jsn.surveyor);
                $("#survey_date").val(jsn.date);
                $("#survey_createdby").val(jsn.result);
                $("#survey_createdby").val(jsn.createdby);
                $("#tableData").html("");
                $("#formSurveyButtons").html("<button id='btnUpdateSurvey' class='btn btn-warning col-sm-offset-4'>Update</button><button id='btnCancelSurvey' class='btn btn-danger col-sm-offset-1'>Cancel</button>");
                $("#btnUpdateSurvey").click(function(e){
                    e.preventDefault();
                    updateSurveys(tbl, survey_id);
                    displaySurveys(tbl, id);
                });
                $("#btnCancelSurvey").click(function(e){
                    e.preventDefault();
                    displaySurveys(tbl, id);
                });
                $("#formSurvey").show();
            }else{
                alert("Could not find record "+survey_id+" in table"+tbl);
            }
        });
       
    }
    function updateSurveys(tbl, survey_id){
        var jsnFormData=returnFormDate('inpSurvey');
        jsnFormData.tbl=tbl;
        alert("Updating survey "+survey_id+ " in "+tbl +"\n\n"+JSON.stringify(jsnFormData));
        $.ajax({
            url:'php/update_record.php',
            data:jsnFormData,
            type:'POST',
            success:function(response){
                if(response.substring(0,5)=="ERROR"){
                    alert(response);
                }else{
                    alert(response);
                    displaySurveys(tbl,survey_id);
            }
        },
            error:function(xhr,status, error){
                $("#tableData").html("ERROR: "+error);
                $("#dlgModal").show();
            }

        })
    }

    function insertSurvey(tbl, id){
        alert("Insert new record for survey_id " + id + " in table "+tbl);
        $("#survey_id").val(id);
        $("#survey_surveyor").val(user.firstname + " " +user.lastname);
        $("#survey_date").val(returnCurrentDate());
        $("#survey_result").val("");
        $("#survey_createdby").val("");
        $("#tableData").html("");
        $("#formSurveyButtons").html("<button id='btnSubmitSurvey' class='btn btn-success col-sm-offset-4'>Submit</button><button id='btnCancelSurvey' class='btn btn-danger col-sm-offset-1'>Cancel</button>");
        $("#btnSubmitSurvey").click(function(e){
            // e.preventDefault();
            submitSurveys(tbl, id);
         });
        $("#btnCancelSurvey").click(function(e){
            e.preventDefault();
            displaySurveys(tbl, id);
        });
        $("#formSurvey").show();
        }
    

     function deleteSurvey(tbl, id, survey_id){
         if(confirm("Are you sure you want to delete survey "+survey_id+ " from "+tbl+ "?")){
            $.ajax({
            url:'php/delete_record.php',
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

    function submitSurvey(tbl, id){
        var jsnFormData=returnFormData('inpSurvey');
        jsnFormData.tbl=tbl;
        delete jsnFormData.id;
        $.ajax({
            url:'php/insert_record.php',
            data:jsnFormData,
            type:'POST',
            success:function(response){
                if (response.substring(0,5)=="ERROR") {
                    alert(response);
                } else {
                    displaySurveys(tbl, id);
                }
            },
            error:function(xhr, status, error){
                $("#tableData").html("ERROR: "+error);
                $("#dlgModal").show();
            }
        })
    }