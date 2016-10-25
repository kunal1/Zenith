// AUTHOR: JAGSIR SINGH
// DATE : 23 MARCH 2014

function loadCountries(){ 
    var $cnt = $('#hdnCountryId').val();
    
    $('#ddlCountry').find('option').remove().end();
    $('#lstCntry').find('option').remove().end();
    
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"getCountries"
            },
            success:function(msg){
                    msg = $.parseJSON(msg); 
                    for (var index in msg) 
                    {
                        $('#ddlCountry').append('<option value="'+ msg[index].countryId +'">' 
                                + msg[index].countryName + '</option>').val( msg[index].countryId);    
                        $('#lstCntry').append('<option value="'+ msg[index].countryName +'">' 
                                + msg[index].countryName + '</option>').val( msg[index].countryName);                            
                    }
                    if($cnt == "0")
                    {
                        $("#ddlCountry option:first").attr('selected','selected');                        
                    }
                    else
                    {      
                        $exists = false; 
                        $('#ddlCountry  option').each(function(){
                          if (this.value == $cnt) {
                            $exists = true;
                          }
                        });
                        if($exists)
                        {
                            $('#ddlCountry').val($cnt);
                        }
                        else
                        {
                            $("#ddlCountry option:first").attr('selected','selected');
                        }      
                    }
                    loadStates();
            },
            dataType:"text"
    });
 }
 
function loadStates(){  
    var $stt = $('#hdnStateId').val();
    $('#ddlStates').find('option').remove().end();
    $('#ddlCities').find('option').remove().end();
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"getStates",
                    cntryId:$("#ddlCountry").val()
            },
            success:function(msg){
                    msg = $.parseJSON(msg); 
                    for (var index in msg) 
                    {
                        $('#ddlStates').append('<option value="'+ msg[index].stateId +'">' 
                                + msg[index].state + '</option>').val( msg[index].stateId);
                    }
                    if($stt == 0) 
                    {
                        $("#ddlStates option:first").attr('selected','selected');
                    }
                    else
                    {      
                        $exists = false; 
                        $('#ddlStates  option').each(function(){
                          if (this.value == $stt) {
                            $exists = true;
                          }
                        });
                        if($exists)
                        {
                        $('#ddlStates').val($stt);
                        }
                        else
                        {
                            $("#ddlStates option:first").attr('selected','selected');
                        }
                    }
                    loadCities();
            },
            dataType:"text"
    });
}

function loadCities(){  
    var $cit = $('#hdnCityId').val();
    $('#ddlCities').find('option').remove().end();
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"getCities",
                    stId:$("#ddlStates").val()
            },
            success:function(msg){
                    msg = $.parseJSON(msg); 
                    for (var index in msg) 
                    {
                        $('#ddlCities').append('<option value="'+ msg[index].cityId +'">' 
                                + msg[index].city + '</option>').val( msg[index].cityId);                        
                    }
                    if($cit == "0") 
                    {
                        $("#ddlCities option:first").attr('selected','selected');
                    }
                    else
                    {    
                        $exists = false; 
                        $('#ddlCities  option').each(function(){
                          if (this.value == $cit) {
                            $exists = true;
                          }
                        });
                        if($exists)
                        {
                            $('#ddlCities').val($cit);
                        }
                        else
                        {
                            $("#ddlCities option:first").attr('selected','selected');
                        }
                          
                    }
        },
            dataType:"text"
    });
}

function updateBasic(){
    $usid = $('#hdUId').val();
    
    $BType = $('input[name=rdbBodyType]:checked').val();
    $Comp = $('input[name=rdbComplexion]:checked').val();
    $PType = $('input[name=rdbPhysicalStatus]:checked').val();
    $DHabit = $('input[name=rdbdrinkHabits]:checked').val();    
    $SHabit = $('input[name=rdbsmokeHabits]:checked').val();
    $EHabit = $('input[name=rdbeatingHabits]:checked').val();  
    $MStatus = $('#ddlMStatus').val();  
    $ht = $('#txtHeight').val();
    $wt = $('#txtWeight').val();
    $MTongue = $('#txtMotherTongue').val();
    $HColor = $('#txtHairColor').val();
    
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"updateBasicDet",
                    uid:$usid,
                    BodyT:$BType,
                    Complx:$Comp,
                    PhysicalSt:$PType,
                    DrinkH:$DHabit,
                    SmokeH:$SHabit,
                    EHabit:$EHabit,
                    MartialS:$MStatus,
                    Height:$ht,
                    Weight:$wt,
                    MotherT:$MTongue,
                    HairC:$HColor
                    
                },
            success:function(msg){
                   // msg = $.parseJSON(msg); 
                   // alert(msg);
                    
                    if(msg=="true")
                    {
                        $('#lblBodyType').text($BType);
                        $('#lblComplexion').text($Comp);
                        $('#lblPStatus').text($PType);
                        $('#lblMStatus').text($MStatus);
                        $('#lblWeight').text($wt);
                        $('#lblHeight').text($ht);
                        $('#lblSHabits').text($SHabit);
                        $('#lblEHabits').text($EHabit);
                        $('#lblDHabits').text($DHabit);
                        $('#lblMTongue').text($MTongue);
                        $('#lblHColor').text($HColor);

                        $('#simpleDivBasicDet').slideToggle("slow");
                        $('#editDivBasicDet').slideToggle("slow");
                        $('#lblMsg').html('Basic information updated!');                    
                    }
                    else{

                        msg = msg.substring(1, eval(msg.length - 1));
                        $('#errMotherT').html("");
                        $('#errHairColor').html("");
                        $('#errHeight').html("");
                        $('#errWeight').html("");

                        $.each(msg.split(", ").slice(0), function(index, item) {      
                              if(item=="motherT"){
                                  $('#errMotherT').html('Please enter valid values');
                              }
                              if(item == "hairC"){
                                  $('#errHairColor').html('Please enter valid values');
                              } 
                              if(item=="Height"){
                                  $('#errHeight').html('Please enter valid values');
                              }
                              if(item == "Weight"){
                                  $('#errWeight').html('Please enter valid values');
                              }
                            });

                    }
                    },
                dataType:"text"
    });
}

function updateLocations(){
    $usid = $('#hdUId').val();
    $cnt = $('#ddlCountry').val();
    $stt = $('#ddlStates').val();
    $cit = $('#ddlCities').val();
    $citizen = $('#txtCitizen').val();
    $resi = $('#txtResident').val();
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"updateLoc",
                    uid:$usid,
                    cntryId:$cnt,
                    sttId:$stt,
                    ctyid:$cit,
                    citiz:$citizen,
                    res:$resi
            },
            success:function(msg){
                if(msg=="true")
                {
                    $('#lblCitizen').text($citizen);
                    $('#lblResident').text($resi);
                    
                    $('#lblCountry').html($("#ddlCountry option:selected").text());
                    $('#lblState').html($("#ddlStates option:selected").text());
                    $('#lblCity').html($("#ddlCities option:selected").text());
                    $('#lblCitizen').html($citizen);
                    $('#lblResident').html($resi);
                    
                    $('#hdnCountryId').html($cnt);
                    $('#hdnStateId').html($stt);
                    $('#hdnCityId').html($cit);
                    
                    $('#simpleDivLoc').slideToggle("slow");
                    $('#editDivLoc').slideToggle("slow");
                    $('#lblMsg').html('Location information updated!');                    
                }
                else{

                    msg = msg.substring(1, eval(msg.length - 1));
                    $('#errCitizen').html("");
                    $('#errResident').html("");

                    $.each(msg.split(", ").slice(0), function(index, item) {      
                          if(item=="citizen"){
                              $('#errCitizen').html('Please enter valid values');
                          }
                          if(item == "resident"){
                              $('#errResident').html('Please enter valid values');
                          } 
                        });

                }
            },
            dataType:"text"
    });
}

function updateFamilyDetails(){
    $usid = $('#hdUId').val();
    $livWith = $('input[name=rdbLiv]:checked').val();
    $famType = $('input[name=rdbFamType]:checked').val();
    $famVal = $('input[name=rdbFamVal]:checked').val();
    $famStat = $('input[name=rdbFamStat]:checked').val();    
        
    $numSis = $('#txtNumSis').val();
    $numBro = $('#txtNumBro').val();
    $mrdSis = $('#txtMrdSis').val();
    $mrdBro = $('#txtMrdBro').val();
    $FOccu = $('#txtFatherOcc').val();
    $MOccu = $('#txtMotherOcc').val();
    
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"updateFamDet",
                    uid:$usid,
                    liveWith:$livWith,
                    fType:$famType,
                    fVal:$famVal,
                    fState:$famStat,
                    nSis:$numSis,
                    nBros:$numBro,
                    marriedSis:$mrdSis,
                    marriedBros:$mrdBro,
                    fatherOcc:$FOccu,
                    motherOcc:$MOccu
            },
            success:function(msg){
                if(msg=="true")
                {                      
                    $('#lblLivingW').html($livWith);
                    $('#lblFType').html($famType);
                    $('#lblFValue').html($famVal);
                    $('#lblFStat').html($famStat);
                    $('#lblNumSis').html($numSis);
                    $('#lblNumBros').html($numBro);
                    $('#lblMSis').html($mrdSis);
                    $('#lblMBros').html($mrdBro);
                    $('#lblFOcc').html($FOccu);
                    $('#lblMOcc').html($MOccu);
    
                    $('#simpleDivFamDet').slideToggle("slow");
                    $('#editDivFamDet').slideToggle("slow"); 
                    $('#lblMsg').html('Family details updated!');                    
                }
                else{

                    msg = msg.substring(1, eval(msg.length - 1));
                    $('#errNBro').html("");
                    $('#errNSis').html("");
                    $('#errMSis').html("");
                    $('#errMBro').html("");
                    $('#errFOcc').html("");
                    $('#errMOcc').html("");

                    $.each(msg.split(", ").slice(0), function(index, item) {      
                          if(item=="nBro"){
                              $('#errNBro').html('Please enter valid values');
                          }
                          if(item == "nSis"){
                              $('#errNSis').html('Please enter valid values');
                          }     
                          if(item=="mBro"){
                              $('#errMBro').html('Please enter valid values');
                          }
                          if(item == "mSis"){
                              $('#errMSis').html('Please enter valid values');
                          }     
                          if(item=="fatherOcc"){
                              $('#errFOcc').html('Please enter valid values');
                          }
                          if(item == "motherOcc"){
                              $('#errMOcc').html('Please enter valid values');
                          } 
                        });

                }
            },
            dataType:"text"
    });
}

function updateProfessionalDetails(){
    $usid = $('#hdUId').val();
    
    $edu = $('#txtEdu').val();
    $clg = $('#txtClg').val();
    $adeg = $('#txtADeg').val();
    $occp = $('#txtOccp').val();
    $empin = $('input[name=rdbEmpIn]:checked').val();  
    $ainc = $('#txtAInc').val();
    
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"updateProfDet",
                    uid:$usid,
                    educ:$edu,
                    colg:$clg,
                    adegree:$adeg,
                    occup:$occp,
                    empdin:$empin,
                    anninc:$ainc
            },
            success:function(msg){
                if(msg=="true")
                {                          
                    $('#lblEdu').html($edu);
                    $('#lblColg').html($clg);
                    $('#lblADeg').html($adeg);
                    $('#lblOccup').html($occp);
                    $('#lblEmpIn').html($empin);
                    $('#lblAIncome').html($ainc);
                    
                    $('#simpleDivProfDet').slideToggle("slow");
                    $('#editDivProfDet').slideToggle("slow"); 
                    $('#lblMsg').html('Professional details updated!');                    
                }
                else{

                    msg = msg.substring(1, eval(msg.length - 1));
                    $('#errEdu').html("");
                    $('#errColg').html("");
                    $('#errAdeg').html("");
                    $('#errOcc').html("");
                    $('#errAnnInc').html("");

                    $.each(msg.split(", ").slice(0), function(index, item) {      
                          if(item=="educ"){
                              $('#errEdu').html('Please enter valid values');
                          }
                          if(item == "colg"){
                              $('#errColg').html('Please enter valid values');
                          }     
                          if(item=="adeg"){
                              $('#errAdeg').html('Please enter valid values');
                          }
                          if(item == "occu"){
                              $('#errOcc').html('Please enter valid values');
                          }     
                          if(item=="anninc"){
                              $('#errAnnInc').html('Please enter valid values');
                          }
                        });

                }
            },
            dataType:"text"
    });
}

function updateHobbies(){
    $usid = $('#hdUId').val();
    $langArray = [];
    $("#spokenLangs option:selected").each(function () {
            var $this = $(this);
            if ($this.length) {
             $langArray.push($this.text());
            }
         });
    $selectedLangs = $langArray.join(', ');
         
    $chkHBArray = [];
    $("[name=chkHobbies]:checked").each(function() {
        $chkHBArray.push($(this).val());
    });        
    $selectedHobbies = $chkHBArray.join(', ');
    
    $chkIntArray = [];
    $("[name=chkInterests]:checked").each(function() {
        $chkIntArray.push($(this).val());
    });        
    $selectedInts = $chkIntArray.join(', ');
    
    $chkDSArray = [];
    $("[name=chkDressStyle]:checked").each(function() {
        $chkDSArray.push($(this).val());
    });        
    $selectedDS = $chkDSArray.join(', ');
        
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"updateHobbies",
                    uid:$usid,
                    hobs:$selectedHobbies,
                    ints:$selectedInts,
                    dS:$selectedDS,
                    langs:$selectedLangs
            },
            success:function(msg){
                if(msg)
                {                          
                    $('#lblHobbies').html($selectedHobbies);
                    $('#lblInts').html($selectedInts);
                    $('#lblDStyles').html($selectedDS);
                    $('#lblSLanguages').html($selectedLangs);
                    
                    $('#simpleDivHobbies').slideToggle("slow");
                    $('#editDivHobbies').slideToggle("slow"); 
                    $('#lblMsg').html('Hobbies and Interests updated!');                    
                }
            },
            dataType:"text"
    });
}

function updatePartnerPref(){
    $usid = $('#hdUId').val();
    $langArray = [];
    $("#lstCntry option:selected").each(function () {
            var $this = $(this);
            if ($this.length) {
             $langArray.push($this.text());
            }
         });
    $selectedCntrs = $langArray.join(', ');
         
   $fromAg = $('#ddlFromAge').val();
   $toAg = $('#ddlToAge').val();
        
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"updatePartnerPref",
                    uid:$usid,
                    fromAge:$fromAg,
                    toAge:$toAg,
                    contrs:$selectedCntrs
            },
            success:function(msg){
                if(msg)
                {                          
                    $('#lblFromAge').html($fromAg);
                    $('#lblToAge').html($toAg);
                    $('#lblCntry').html($selectedCntrs);
                    
                    $('#simpleDivPartPref').slideToggle("slow");
                    $('#editDivPartPref').slideToggle("slow"); 
                    $('#lblMsg').html('Partner Prefrences updated!');                    
                }
            },
            dataType:"text"
    });
}

function loadAges($selectId){
    for( var ind = 20; ind <= 50; ind++ ) 
    {
        $($selectId).append('<option value="'+ ind +'">' 
                                + ind + '</option>').val(ind);    
    }
}

function showHide(){
        $('#simpleDivBasicDet').show("slow");
        $('#editDivBasicDet').hide("slow");  
        $('#simpleDivLoc').show("slow");
        $('#editDivLoc').hide("slow");     
        $('#simpleDivFamDet').show("slow");
        $('#editDivFamDet').hide("slow"); 
        $('#simpleDivProfDet').show("slow");
        $('#editDivProfDet').hide("slow");     
        $('#simpleDivHobbies').show("slow");
        $('#editDivHobbies').hide("slow");     
        $('#simpleDivPartPref').show("slow");
        $('#editDivPartPref').hide("slow");  
}

function delAccount(){
    $usid = $('#hdUId').val();
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"delAccount",
                    uid:$usid
            },
            success:function(msg){
                if(msg)
                {            
                    location.href='../index.php';                
                }
            },
            dataType:"text"
    });
}

function popup(){
    $ssid = $('#hdnSearchUserId').val();
    $link = "viewGallary.php?sid=" + $ssid;
    window.open($link, 'Gallary', 'width=725,height=450,scrollbars=no,resizable=0,titlebar=0,menubar=0,status=0,toolbar=0');
}

function getContactDetails(){
    $usid = $('#hdUId').val();
    $contsId = $('#hdnSearchUserId').val();
    $.ajax({
            url:"../commonService.php",  
            type:"POST",
            data:{
                    data:"getContactDetails",
                    uid:$usid,
                    contId:$contsId
            },
            success:function(msg){
                    msg = $.parseJSON(msg);
                    $details="";
                    for (var index in msg) 
                    { 
                        $details += msg[index].email+ "<br />" +msg[index].phone+ "<br />";
                    }
                    $('#divHide').show("slow");
                    $('#divContact').html($details);
                    $('#divContShow').hide("slow");
            },
            dataType:"text"
    });
}

$(document).ready(function(){

    var $uid = $('#hdUId').val();
    var $sid = $('#hdnSearchUserId').val();
    
    $('#delAccount').click(function(e){      
            if (confirm("Delete Account?")){
                 delAccount();
                   // location.href='../index.php';
             }
             else
             {
                e.preventDefault();             
             }
    });
    
    if($uid == $sid){
        showHide();       
        loadCountries();
    //  -----------------------------------  BASIC DETAILS BUTTON CLICK STARTS -----------------------------------------
        $('#basicEdit').click(function(e){
            e.preventDefault();             
            showHide();
            
            $('#errMotherT').html("");
            $('#errHairColor').html("");
            $('#errHeight').html("");
            $('#errWeight').html("");
                          
            $("[name=rdbBodyType]").prop("checked", false);
            $("[name=rdbComplexion]").prop("checked", false);
            $("[name=rdbPhysicalStatus]").prop("checked", false);
            $("[name=rdbdrinkHabits]").prop("checked", false);
            $("[name=rdbsmokeHabits]").prop("checked", false);
            $("[name=rdbeatingHabits]").prop("checked", false);

            $('#txtHeight').val($('#lblHeight').text());
            $('#txtWeight').val($('#lblWeight').text());
            $('#txtMotherTongue').val($('#lblMTongue').text());
            $('#txtHairColor').val($('#lblHColor').text());


            $("[name=rdbBodyType]").filter("[value='"+$('#lblBodyType').text()+"']").prop("checked",true);        
            $("[name=rdbComplexion]").filter("[value='"+$('#lblComplexion').text()+"']").prop("checked",true);
            $("[name=rdbPhysicalStatus]").filter("[value='"+$('#lblPStatus').text()+"']").prop("checked",true);
            $("[name=rdbdrinkHabits]").filter("[value='"+$('#lblDHabits').text()+"']").prop("checked",true);
            $("[name=rdbsmokeHabits]").filter("[value='"+$('#lblSHabits').text()+"']").prop("checked",true);
            $("[name=rdbeatingHabits]").filter("[value='"+$('#lblEHabits').text()+"']").prop("checked",true);        

            $('#simpleDivBasicDet').slideToggle("slow");
            $('#editDivBasicDet').slideToggle("slow"); 

        });    
        $('#cancBasicDet').click(function(e){
            e.preventDefault();
            $('#simpleDivBasicDet').slideToggle("slow");
            $('#editDivBasicDet').slideToggle("slow");

        });
        $('#updBasicDet').click(function(e){
            e.preventDefault();
            updateBasic();
        });
    //  -----------------------------------  BASIC DETAILS CLICK ENDS -----------------------------------------


    //  -----------------------------------  LOCATION BUTTON CLICK STARTS -----------------------------------------
        $('#locEdit').click(function(e){
            e.preventDefault();        
            $cnt = $('#hdnCountryId').val();
            $stt = $('#hdnStateId').val();
            $cit = $('#hdnCityId').val();
            loadCountries();
            if($cnt != "0")
            {
                $('#ddlCountry').val($cnt);
                $('#ddlStates').val($stt);
                $('#ddlCities').val($cit);
            }           

            $('#txtCitizen').val($('#lblCitizen').text());
            $('#txtResident').val($('#lblResident').text());
            
            showHide();
            $('#errCitizen').html("");
            $('#errResident').html("");
            
            $('#simpleDivLoc').slideToggle("slow");
            $('#editDivLoc').slideToggle("slow"); 
        });    
        $('#cancDivLoc').click(function(e){
            e.preventDefault();
            $('#simpleDivLoc').slideToggle("slow");
            $('#editDivLoc').slideToggle("slow");

        });
        $('#updLoc').click(function(e){
            e.preventDefault();
            updateLocations();
        });
    //  -----------------------------------  LOCATION BUTTON CLICK ENDS -----------------------------------------


    //  -----------------------------------  FAMILY DETAILS BUTTON CLICK STARTS -----------------------------------------
        $('#famDetEdit').click(function(e){
            e.preventDefault();

            $("[name=rdbLiv]").prop("checked", false);
            $("[name=rdbFamType]").prop("checked", false);
            $("[name=rdbFamVal]").prop("checked", false);
            $("[name=rdbFamStat]").prop("checked", false);

            $("[name=rdbLiv]").filter("[value='"+$('#lblLivingW').text()+"']").prop("checked",true);        
            $("[name=rdbFamType]").filter("[value='"+$('#lblFType').text()+"']").prop("checked",true);
            $("[name=rdbFamVal]").filter("[value='"+$('#lblFValue').text()+"']").prop("checked",true);
            $("[name=rdbFamStat]").filter("[value='"+$('#lblFStat').text()+"']").prop("checked",true);

            $('#txtNumSis').val($('#lblNumSis').text());
            $('#txtNumBro').val($('#lblNumBros').text());
            $('#txtMrdSis').val($('#lblMSis').text());
            $('#txtMrdBro').val($('#lblMBros').text());
            $('#txtFatherOcc').val($('#lblFOcc').text());
            $('#txtMotherOcc').val($('#lblMOcc').text());

            showHide();
            
            $('#errNBro').html("");
            $('#errNSis').html("");
            $('#errMSis').html("");
            $('#errMBro').html("");
            $('#errFOcc').html("");
            $('#errMOcc').html("");
            
            $('#simpleDivFamDet').slideToggle("slow");
            $('#editDivFamDet').slideToggle("slow"); 

        });    
        $('#cancFamDet').click(function(e){
            e.preventDefault();
            $('#simpleDivFamDet').slideToggle("slow");
            $('#editDivFamDet').slideToggle("slow"); 

        });
        $('#updFamDet').click(function(e){
            e.preventDefault();
            updateFamilyDetails();
        });
    //  -----------------------------------  FAMILY DETAILS BUTTON CLICK ENDS -----------------------------------------


    //  -----------------------------------  PROFESSIONAL DETAILS BUTTON CLICK STARTS -----------------------------------------
        $('#profEdit').click(function(e){
            e.preventDefault();

            $("[name=rdbEmpIn]").prop("checked", false);

            $("[name=rdbEmpIn]").filter("[value='"+$('#lblEmpIn').text()+"']").prop("checked",true); 

            $('#txtEdu').val($('#lblEdu').text());
            $('#txtClg').val($('#lblColg').text());
            $('#txtADeg').val($('#lblADeg').text());
            $('#txtOccp').val($('#lblOccup').text());
            $('#txtAInc').val($('#lblAIncome').text());

            showHide();     
            $('#errEdu').html("");
            $('#errColg').html("");
            $('#errAdeg').html("");
            $('#errOcc').html("");
            $('#errAnnInc').html("");

            $('#simpleDivProfDet').slideToggle("slow");
            $('#editDivProfDet').slideToggle("slow"); 
        });    
        $('#cancProfDet').click(function(e){
            e.preventDefault();
            $('#simpleDivProfDet').slideToggle("slow");
            $('#editDivProfDet').slideToggle("slow"); 

        });    
        $('#updProfDet').click(function(e){
            e.preventDefault();
            updateProfessionalDetails();
        });

    //  -----------------------------------  PROFESSIONAL DETAILS BUTTON CLICK ENDS -----------------------------------------


    //  -----------------------------------  HOBBIES BUTTON CLICK STARTS -----------------------------------------
        $('#hobbiesEdit').click(function(e){
            e.preventDefault();
            showHide();     
            $('#simpleDivHobbies').slideToggle("slow");
            $('#editDivHobbies').slideToggle("slow"); 

            $("[name=chkHobbies]").prop("checked", false);
            $("[name=chkInterests]").prop("checked", false);
            $("[name=chkDressStyle]").prop("checked", false);
            $("#spokenLangs option").prop("selected", false);

            $hbs = $('#lblHobbies').html();
            $Ints = $('#lblInts').html();
            $Dstyles = $('#lblDStyles').html();
            $langs = $('#lblSLanguages').html();

            $.each($hbs.split(", ").slice(0), function(index, item) {
                $("[name=chkHobbies]").filter("[value='"+item+"']").prop("checked",true);            
            });
            $.each($Ints.split(", ").slice(0), function(index, item) {
                $("[name=chkInterests]").filter("[value='"+item+"']").prop("checked",true);            
            });
            $.each($Dstyles.split(", ").slice(0), function(index, item) {
                $("[name=chkDressStyle]").filter("[value='"+item+"']").prop("checked",true);            
            });
            $.each($langs.split(", ").slice(0), function(index, item) {
                $("#spokenLangs option").filter("[value='"+item+"']").prop("selected",true);            
            });
                
        });     
        $('#cancHobbies').click(function(e){
            e.preventDefault();
            $('#simpleDivHobbies').slideToggle("slow");
            $('#editDivHobbies').slideToggle("slow"); 

        });
        $('#updHobbies').click(function(e){
            e.preventDefault();
           updateHobbies();

        });
    //  -----------------------------------  HOBBIES DETAILS BUTTON CLICK ENDS -----------------------------------------


    //  -----------------------------------  PARTNER PREFRENCES BUTTON CLICK STARTS -----------------------------------------
        $('#partPrefEdit').click(function(e){
            e.preventDefault();
            showHide();     
            $("#lstCntry option").prop("selected", false);

            loadAges('#ddlFromAge');
            loadAges('#ddlToAge');

            $fa = $('#lblFromAge').html();
            $ta = $('#lblToAge').html();

            $('#ddlFromAge').val($fa);        
            $('#ddlToAge').val($ta);

            $cntrs = $('#lblCntry').html();

            $.each($cntrs.split(", ").slice(0), function(index, item) {
                $("#lstCntry option").filter("[value='"+item+"']").prop("selected",true);            
            });

            $('#simpleDivPartPref').slideToggle("slow");
            $('#editDivPartPref').slideToggle("slow"); 
                
        });     
        $('#cancPartPref').click(function(e){
            e.preventDefault();
            $('#simpleDivPartPref').slideToggle("slow");
            $('#editDivPartPref').slideToggle("slow"); 

        });
        $('#updPartPref').click(function(e){
            e.preventDefault();
           updatePartnerPref();

        });
    //  -----------------------------------  PARTNER PREFRENCES BUTTON CLICK ENDS -----------------------------------------
    }
    else{
        $('#divHide').hide();
        $('#btnCloseContact').click(function(e){
            e.preventDefault();
            $('#divHide').hide("slow");
            $('#divContShow').show("slow");
        });
        $('#viewContact').click(function(e){
            e.preventDefault();
            getContactDetails();
        });
        
        $('#viewGallary').click(function(e){
            e.preventDefault();
            popup();
        });
    }
});

