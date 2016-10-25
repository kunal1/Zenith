$(document).ready(function(){
    $('#divForms').hide();
    $('#divRecord').show();
    $('#addNewOffer').click(function(e){
        e.preventDefault();
        $('#divRecord').slideToggle("slow");
        $('#divForms').slideToggle("slow");
        $('#txtTitle').val('');
        $('#txtDays').val('');
        $('#txtPrice').val('');
        $('#hdnSpeId').val(0);
    
        $('#btnOffer').val('Save');
    });
    
    $('#cancOffer').click(function(e){
        e.preventDefault();
        $('#divRecord').slideToggle("slow");
        $('#divForms').slideToggle("slow");       
    });
    
    $('#btnOffer').click(function(e){
        e.preventDefault();
        if($('#hdnSpeId').val() == "0"){
            saveOffers();
        }
        else
        {
            UpdateOffers();
        }
            
    });
    
});

function saveOffers(){
    $title = $('#txtTitle').val();
    $daysA = $('#txtDays').val();
    $priceA = $('#txtPrice').val();
   
    $.ajax({
            url:"../zenithAdmin/offerService.php",  
            type:"POST",
            data:{
                    data:"svOffer",
                    special:$title,
                    daysAllowed:$daysA,
                    price:$priceA
                    
            },
            success:function(speId){
                if(speId)
                {                    
                    $('#divRecord').slideToggle("slow");
                    $('#divForms').slideToggle("slow");    
                    $('#lblMsg').html('Offers information added!');   
                    
                    $newOffer = "<div class='form-group col-md-5'>";
                         $newOffer += "<div class='form-group col-md-12'>";
                             $newOffer += "<label class='col-md-6 control-label'>Title:</label>";
                             $newOffer += "<div class='col-md-6'>";
                             $newOffer += "<label id='lblTitle_'" + speId + "' class='control-label' style='font-weight:normal;'>" + $title + "</label>";
                             $newOffer += "</div>";
                         $newOffer += "</div>";

                         $newOffer += "<div class='form-group col-md-12'>";
                             $newOffer += "<label class='col-md-6 control-label'>Days Allowed:</label>";
                             $newOffer += "<div class='col-md-6'>";
                             $newOffer += "<label id='lblDays_'" + speId + "' class='control-label' style='font-weight:normal;'>" + $daysA + "</label>";
                             $newOffer += "</div>";
                         $newOffer += "</div>";


                         $newOffer += "<div class='form-group col-md-12'>";
                             $newOffer += "<label class='col-md-6 control-label'>Price:</label>";
                             $newOffer += "<div class='col-md-6'>";
                             $newOffer += "$ ";
                             $newOffer += "<label id='lblPrice_'" + speId + "' class='control-label' style='font-weight:normal;'>" + $priceA + "</label>";
                             $newOffer += " CA";
                             $newOffer += "</div>";
                         $newOffer += "</div>";


                         $newOffer += "<div  class='form-group col-md-12'>";
                         $newOffer += "<label class='col-md-4 control-label'>&nbsp;</label>";
                         $newOffer += "<div class='col-md-8'>";
                         $newOffer += "<input type='submit' id='updOffer_'" + speId + "' onclick='showOfferUpdate(" + speId + "); return false;' value='Edit' class='btn btn-success' />&nbsp;&nbsp;&nbsp;";
                         $newOffer += "<input type='submit' id='delOffer_'" + speId + "' onclick='deleteTheOffer(" + speId + "); return false;' value='Delete' class='btn btn-success' />";
                         $newOffer += "</div>";            
                         $newOffer += "</div>";

                         $newOffer += "<div  class='form-group col-md-12'>";
                             $newOffer += "<hr/>";
                         $newOffer += "</div>";    

                    $newOffer += "</div>";    

                    $newOffer += "<div class='form-group col-md-1' >";
                    $newOffer += "</div>";   
                    $('#divRecord').append($newOffer);
                }
            },
            dataType:"text"
    });
}

function UpdateOffers(){
    $OfferId = $('#hdnSpeId').val();
    $title = $('#txtTitle').val();
    $daysA = $('#txtDays').val();
    $priceA = $('#txtPrice').val();
    
    $.ajax({
            url:"../zenithAdmin/offerService.php",  
            type:"POST",
            data:{
                    data:"updOffer",
                   specialId:$offerId,
                    special:$title,
                    daysAllowed:$daysA,
                    price:$priceA
                    
            },
            success:function(msg){
                if(msg)
                {
                    $('#lblTitle_' + $offerId).html($title);
                    $('#lblDays_' + $offerId).html($daysA);
                    
                    
                    $('#lblPrice_' + $offerId).html($priceA);
                    
                    
                    $('#divRecord').slideToggle("slow");
                    $('#divForms').slideToggle("slow");    
                    $('#lblMsg').html('Offers information updated!');                    
                }
            },
            dataType:"text"
    });
}

function showOfferUpdate($specialId,$title,$days,$price){
    $('#hdnSpeId').val($specialId);    
    $('#txtTitle').val($title);
    $('#txtDays').val($days);
    $('#txtPrice').val($price);
    
            
    $('#divRecord').slideToggle("slow");
    $('#divForms').slideToggle("slow");
    $('#btnOffer').val('Update');
}


function deleteTheOffer($specialId)
{
    if(confirm('Confirm delete!')){
        $.ajax({
                url:"../zenithAdmin/offerService.php",  
                type:"POST",
                data:{
                        data:"delOffer",
                        offerId:$specialId
                },
                success:function(msg){
                    if(msg)
                    {
                        $('#divReco_' + $specialId).remove();
                        $('#lblMsg').html('Offer deleted!');                    
                    }
                },
                dataType:"text"
        });
        
    }
}

