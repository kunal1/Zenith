
function closeTicket($ticketId){    
    $('#lblMsg').html(''); 
    if(confirm('Are you sure to close?'))
    {
        $.ajax({
                url:"../ticketsService.php",  
                type:"POST",
                data:{
                        data:"closeT",
                        tId:$ticketId
                },
                success:function(msg){
                    $('#divRec_' + $ticketId).slideToggle("slow");
                    $('#lblMsg').html('Ticket closed'); 
                },
                dataType:"text"
        });
    }
}

function loadDepartments(){ 
    
    $('#ddlDepartments').find('option').remove().end();
    
    $.ajax({
            url:"../ticketsService.php",  
            type:"POST",
            data:{
                    data:"getDepartments"
            },
            success:function(msg){
                    msg = $.parseJSON(msg); 
                    for (var index in msg) 
                    {
                        $('#ddlDepartments').append('<option value="'+ msg[index].departmentId +'">' 
                                + msg[index].department + '</option>').val( msg[index].departmentId);                           
                    }
                        $("#ddlDepartments option:first").attr('selected','selected'); 
            },
            dataType:"text"
    });
 }
 
function saveTicket(){
    $('#lblMsg').html(''); 
    $usid = $('#hdUId').val();
    $depId = $('#ddlDepartments').val();     
    $sub = $('#txtSubject').val();
    $msg = $('#txtMessage').val();
    $subDate = new Date($.now());
    $subDate = getNewFormat($subDate.toLocaleString());
        
    $.ajax({
            url:"../ticketsService.php",  
            type:"POST",
            data:{
                    data:"saveTicket",
                    userId:$usid,
                    subject:$sub,
                    submitDate:$subDate,
                    departmentId:$depId,
                    message:$msg
            },
            success:function(newTicketId){
                if($.isNumeric($.parseJSON(newTicketId)))
                {
                  newTicketId = $.parseJSON(newTicketId);
                    $newRec = "<div id='divRec_" + newTicketId + "'>";
                        $newRec += "<div class='form-group'>";
                            $newRec += "<label class='col-md-4 control-label'>Ticket Id:</label>";
                            $newRec += "<div class='col-md-8'>";
                                $newRec += "<label id='lblTId_' class='control-label' style='font-weight:normal;'>" + newTicketId + "</label>";
                            $newRec += "</div>";        
                        $newRec += "</div>";  


                        $newRec += "<div class='form-group'>";
                            $newRec += "<label class='col-md-4 control-label'>Subject:</label>";
                            $newRec += "<div class='col-md-8'>";
                                $newRec += "<label id='lblSub_" + newTicketId + "' class='control-label' style='font-weight:normal;'>" + $sub + "</label>";
                            $newRec += "</div>";        
                        $newRec += "</div>";  

                        $newRec += "<div class='form-group'>";
                            $newRec += "<label class='col-md-4 control-label'>Department:</label>";
                            $newRec += "<div class='col-md-8'>";
                                $newRec += "<label id='lblDep_" + newTicketId + "' class='control-label' style='font-weight:normal;'>" + $("#ddlDepartments option:selected").text() + "</label>";
                            $newRec += "</div>";        
                        $newRec += "</div>"; 

                        $newRec += "<div class='form-group'>";
                            $newRec += "<label class='col-md-4 control-label'>Submit Date:</label>";
                            $newRec += "<div class='col-md-8'>";
                                $newRec += "<label id='lblDate_" + newTicketId + "' class='control-label' style='font-weight:normal;'>" + $subDate + "</label>";
                            $newRec += "</div>";        
                        $newRec += "</div>";    

                        $newRec += "<div  class='form-group'>";
                            $newRec += "<label class='col-md-4 control-label'>&nbsp;</label>";
                            $newRec += "<div class='col-md-8'>";
                                $newRec += " <a href='#' id='btnClose' onclick='closeTicket(" + newTicketId + ");return false;' class='btn btn-success'>Close</a>&nbsp;&nbsp;&nbsp;";
                                $newRec += "<a href='ticketReply.php?ticketId=" + newTicketId + "' id='btnReply' class='btn btn-success'>Reply</a>";
                            $newRec += "</div>";            
                        $newRec += "</div>";

                        $newRec += "<div class='form-group'>";
                            $newRec += "<hr />";
                        $newRec += "</div>"; 
                    $newRec += "</div>"; 
                    $('#divRecords').append($newRec);
                    $('#divForm').slideToggle("slow");
                    $('#divRecords').slideToggle("slow"); 
                    $('#lblMsg').html('Ticket saved'); 
                }
                else
                {
                    newTicketId = newTicketId.substring(1, eval(newTicketId.length - 1));
                    $('#errSubject').html("");

                    $.each(newTicketId.split(", ").slice(0), function(index, item) {      
                          if(item=="subject"){
                              $('#errSubject').html('Please enter valid values');
                          }
                        });
                }
            },
            
            error: function (er) {
                alert('error');
                alert($.parseJSON(er));
            },
            dataType:"text"
    });
 }
 
$(document).ready(function(){
    loadDepartments();
    $('#divForm').hide();
    $('#divRecords').show();
    
    $('#addNew').click(function(e){
        e.preventDefault();
        $('#divForm').slideToggle("slow");
        $('#divRecords').slideToggle("slow");  
        $("#ddlDepartments option:first").attr('selected','selected');     
        $('#txtSubject').val("");
        $('#txtMessage').val("");
        $('#errSubject').html("");
    });
    
    $('#btnCancel').click(function(e){
        e.preventDefault();
        $('#divForm').slideToggle("slow");
        $('#divRecords').slideToggle("slow");    
    });
    
    $('#btnSave').click(function(e){
        e.preventDefault();
        saveTicket();
    });
});

function getNewFormat(d){
    $all = d.split(' ');
    $dates = $all[0].split('/');
    
    $newDate = $dates[2] + "-" + $dates[0] + "-"+ $dates[1];
    return $newDate + " " + $all[1]; 
}