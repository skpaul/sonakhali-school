function ValidatePhoto(fileInputId, maximumKB, requiredHeight, requiredWidth){
        
    // debugger;
    var fileName = $("#"+ fileInputId +"").val();

    var title = $("#"+ fileInputId +"").attr("title");

    if(fileName =='')
    {
        $.sweetModal({
            content:  title + " required.",
            icon: $.sweetModal.ICON_WARNING
        });
        //showPhotoError('Please select a photo.');
        return false;
    }

    var fileInput = $("#"+ fileInputId + "")[0];
    var selectedFile = fileInput.files[0];
    
    var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpeg|.jpg)$/;

    var arrFileName = fileName.split("\\");

    var fileNameee = arrFileName[arrFileName.length-1]; 
    //fileNameSpan.html(arrFileName[arrFileName.length-1]);

    //check whether it is .jpeg or .jpg ---->
    if (!regex.test(fileName.toLowerCase())) {
        $.sweetModal({
            content: title + "invalid. Please select a .jpg file.",
            icon: $.sweetModal.ICON_WARNING
        });
       // showPhotoError('Please select a .jpg file.');
       return false;
    }
    //<---- check whether it is .jpeg or .jpg

    var fileSizeInByte = selectedFile.size;
    var Units = new Array('Bytes', 'KB', 'MB', 'GB');
    var unitPosition = 0;
    while (fileSizeInByte > 900) {
        fileSizeInByte /= 1024; unitPosition++;
    }

    var finalSize = (Math.round(fileSizeInByte * 100) / 100);
    var finalUnitName = Units[unitPosition];

    var fileSizeAndUnit = finalSize + ' ' + finalUnitName;

    //Check file size ----->
    if (finalUnitName != 'KB') {
        $.sweetModal({
            content: title + " size is too large. Maximum size is 100 kilobytes.",
            icon: $.sweetModal.ICON_WARNING
        });
       // showPhotoError('Photo size is too large. Maximum size is 100 kilobytes.');              
       return false;
    }
    else{
        if(finalSize > maximumKB){ 
            $.sweetModal({
                content: title + " size is too large. Maximum size is 100 kilobytes.",
                icon: $.sweetModal.ICON_WARNING
            });
           // showPhotoError('Photo size is too large. Maximum size is 100 kilobytes.');
           return false;
        }
    }

    /*Checks whether the browser supports HTML5*/
    if (typeof (FileReader) != "undefined") {
        var reader = new FileReader();
        //Read the contents of Image File.
        reader.readAsDataURL(fileInput.files[0]);

        reader.onload = function (e) {
            //Initiate the JavaScript Image object.
            var image = new Image();
            //Set the Base64 string return from FileReader as source.
            image.src = e.target.result;
           
            image.onload = function () {  
                if (this.width != requiredWidth) {
                    $.sweetModal({
                        content: title + " width invalid. Width must be " + requiredWidth + " pixel.",
                        icon: $.sweetModal.ICON_WARNING
                    });
                   // showPhotoError('Invalid photo width. Width must be 300 pixel.');
                   return false;
                }                 
                if (this.height != requiredHeight) {
                    $.sweetModal({
                        content: title + " height invalid. Height must be "+ requiredHeight  + " pixel.",
                        icon: $.sweetModal.ICON_WARNING
                    });
                    //showPhotoError('Invalid photo height. Height must be 300 pixel.');
                    return false;
                }
            };
        }
    }

    return true;
}


$(function(){

    $('.district-combo').change(function(){

        var districtCombo = $(this);
        districtCombo.attr('disabled','disabled');
        var districtType = $(this).attr('data-districttype'); //districtType = "Present" or "Permanent"
        var thanaCombo = $('#' + districtType + 'Thana');
        thanaCombo.empty();
        var selectedDistrict = districtCombo.val();
      

        $.ajax({
            url: baseUrl + '/court-higher/written/application-form/get-thanas.php?district=' + selectedDistrict,
            type: "GET",
            success:function(response){
               // console.log(response);
                var $response = $.parseJSON(response);
                var thanas = $response.data;
                thanaCombo.append('<option value="0">select thana</option>');
                $.each(thanas, function(){
                    thanaCombo.append('<option value="' + this.thana_name + '">' + this.thana_name + '</option>');
                })
            },
            complete:function(){
                districtCombo.removeAttr('disabled');
            }
        });
    });
    
    $(".educationDetailsToggle").change(function(e){
        if($(this).is(":checked")){
            $(this).closest("article").find(".toggleVisibleWrapper").removeClass("hidden");
        }
        else{
            // $(this).closest("article").find(".toggleVisibleWrapper").hide();
            $(this).closest("article").find(".toggleVisibleWrapper").addClass("hidden");
        }
    });

    //higherEducationResultType
    $(".higherEducationResultType").change(function(){
        var combo  = $(this);
        var resultType = combo.val();
        var container = combo.closest("article").find(".dynamicContent");
        if(resultType == ""){
            container.empty();
            return;
        }
        var examName = combo.closest("article").find(".examName").val();
        if(examName == ""){
            combo.val('');
            alert("Select an examination"); return;
        }
        var url = baseUrl + '/autocompletes/dynamic-content.php?result-type='+ resultType +'&exam-name=' + examName;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "html",
            success: function(response) {
                // console.log(response);
                container.empty().html(response);
                $('input.passingYear').datepicker({
                    language: 'en',
                    dateFormat: "yyyy", 
                    autoClose:true,
                    showOn: "button",
                    minView: 'years',
                    view:"years"
                });
                

                $("input.passingYear, input.totalMarks, input.obtainedMarks").swiftNumericInput({ allowFloat: false, allowNegative: false });

                $('input.examConcludedDate').datepicker({
                    language: 'en',
                    dateFormat: "dd-mm-yyyy", 
                    autoClose:true
                });

            },
            error: function(a,b,c){
                alert("Failed to load data from server. Please try again.");
                combo.val('');
            }
        });
    });


    $("input.country" ).autocomplete({
        // source:  baseUrl + 'autocompletes/board-university-institutes.php?extra=asdf'
        source: function(request, response) {
            var src= baseUrl + '/autocompletes/countries.php?extra=asdf';
            //var $this = this.element;
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                },
                success: function(data) {
                    response(data);
                }
            });
        } //source ends
    });

    $("input.universityName" ).autocomplete({
        // source:  baseUrl + 'autocompletes/board-university-institutes.php?extra=asdf'
        source: function(request, response) {
            var src= baseUrl + '/autocompletes/board-university-institutes.php?extra=asdf';
            //var $this = this.element;
            //var id = $this.closest(".dynamic-education-container").find("input.idRollRegi").val();
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                },
                success: function(data) {
                    response(data);
                    //passingYear
                }
            });
        } //source ends
    });


    $(".sscResultType").change(function(e){
        var selectedValue = $(this).val();
        if(selectedValue=="Division"){
            $(".sscDivisionDetails").removeClass("hidden");
            $(".sscGradeDetails").addClass("hidden");
        }
        else if(selectedValue=="Grade"){
            $(".sscDivisionDetails").addClass("hidden");
            $(".sscGradeDetails").removeClass("hidden");
        }
        else{
            $(".sscDivisionDetails").addClass("hidden");
            $(".sscGradeDetails").addClass("hidden");
        }
    });

    $(".hscResultType").change(function(e){
        var selectedValue = $(this).val();
        if(selectedValue=="Division"){
            $(".hscDivisionDetails").removeClass("hidden");
            $(".hscGradeDetails").addClass("hidden");
        }
        else if(selectedValue=="Grade"){
            $(".hscDivisionDetails").addClass("hidden");
            $(".hscGradeDetails").removeClass("hidden");
        }
        else{
            $(".hscDivisionDetails").addClass("hidden");
            $(".hscGradeDetails").addClass("hidden");
        }
    });

    //remove red border
    $("input[type=text]").on('input propertychange paste', function() {
        $(this).removeClass("error");
    });

    $("select").on('change propertychange paste', function() {
        $(this).removeClass("error");
    });

    $("textarea").on('input propertychange paste', function() {
        $(this).removeClass("error");
    });

    $("input[type=radio]").change(function(){
        $(this).closest("div.radio-group").removeClass("error");
    });

    $(".swiftInteger").swiftNumericInput({ allowFloat: false, allowNegative: false });
    $(".swiftFloat").swiftNumericInput({ allowFloat: true, allowNegative: false });
    $('.swiftDate').datepicker({
        language: 'en',
        dateFormat: 'dd-mm-yyyy',
        autoClose: true
    })

    $('.swift-date').datepicker({
        language: 'en',
        dateFormat: 'dd-mm-yyyy',
        autoClose: true
    })

    //Allow user to select only year from datepicker
    $('.swiftYear').datepicker({
        language: 'en',
        dateFormat: "yyyy", 
        autoClose:true,
        showOn: "button",
        minView: 'years',
        view:"years"
    })

    // var m = moment("29/02/2004", "DD-MM-YYYY");
    // //alert(m.isValid());
    
    // var a = moment("29/12/2004", "DD-MM-YYYY");
    // var b = moment("27/12/2004", "DD-MM-YYYY");
    
    // var diffDuration = moment.duration(a.diff(b));
    
    // alert(diffDuration.years()); // 8 years
    // alert(diffDuration.months()); // 5 months
    // alert(diffDuration.days()); // 2 days

    $("#ApplicantPhoto").change(function(){
        var isValid = ValidatePhoto("ApplicantPhoto", 100, 300,300);
        if(isValid){
            var fileInput = this;
            if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    //$('#photo-preview').attr('src', e.target.result);
                   $('#ApplicantPhotoImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(fileInput.files[0]);
            }
        }
    });

    $("#ApplicantSignature").change(function(){
        var fileInput = this;
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                //$('#photo-preview').attr('src', e.target.result);
               $('#ApplicantSignatureImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(fileInput.files[0]);
            ValidatePhoto("ApplicantSignature", 100,80,300);
        }
    });

    // //PresentThanaCode combo chane handler starts------->
    // $('#PresentThanaCode').change(function(){
    //     $('#PresentThanaName').val($("#PresentThanaCode option:selected").text());
    // });
    // //<----- PresentThanaCode combo chane handler starts

    $('.obtained-marks').on('input',function(e){
        var obtainedMarks =$.trim($(this).val());
        if(obtainedMarks == ''){
            $('#' + degreeName + '_percentage_of_marks').val('');
            return;
        }

        if(isNaN(obtainedMarks)) return;
        obtainedMarks = parseInt(obtainedMarks);

        var degreeName = $(this).attr('data-marks-degree-name');
        var totalMarks = parseInt($('#' + degreeName + '_total_marks').val());

        var percentage_of_marks = (obtainedMarks*100)/totalMarks ;
    
        var percentage_of_marks_textbox = $('#' + degreeName + '_percentage_of_marks');
       
        percentage_of_marks = parseFloat(percentage_of_marks).toFixed(2)
        $('#' + degreeName + '_percentage_of_marks').val(percentage_of_marks);

    });

    // var isChecked =  $("input:radio[name='"+inputName+"']").is(":checked");

    $("input:radio[name='isEngaged']").change(function(){
        var selectedValue =  $(this).val();
        if(selectedValue=="yes"){
            $(".natureOfEngagementField").removeClass("hidden");
            $(".placeOfEngagementField").removeClass("hidden");
        }
        else{
            $(".natureOfEngagementField").addClass("hidden");
            $(".placeOfEngagementField").addClass("hidden");

        }
    });

    //isDismissed
    // $("input:radio[name='degreeObtainedFrom']").change(function(){
    $(".degreeObtainedFrom").change(function(){
        var selectedValue =  $(this).val();
    //    console.log($(this).closest("article").html());

        if(selectedValue=="Other"){
            $(this).closest("article").find(".otherCountryName").removeClass("hidden");
            $(this).closest("article").find(".hasEquivalentCertificate").removeClass("hidden");
        }
        else{
            $(this).closest("article").find(".otherCountryName").addClass("hidden");
            $(this).closest("article").find(".hasEquivalentCertificate").addClass("hidden");
        }
    });

    $("input:radio[name='isConvicted']").change(function(){
        var selectedValue =  $(this).val();
        if(selectedValue=="yes"){
            $(".convictionDateField").removeClass("hidden");
            $(".convictionParticularsField").removeClass("hidden");
        }
        else{
            $(".convictionDateField").addClass("hidden");
            $(".convictionParticularsField").addClass("hidden");
        }
    });


    $("select[name=idType]").change(function(){
        var selectedValue = $(this).val();
        var label = $(".field.nidNo").find("label");
        var newLabel = selectedValue + " No."
        label.html(newLabel);
    })
  
    $("input.presentDistrict_NONEED" ).autocomplete({
        // source:  baseUrl + 'autocompletes/districts.php'
        source: function(request, response) {
            var src= baseUrl + '/autocompletes/districts.php';
            var $this = this.element;
            $this.addClass("textbox-spinner");
            $this.closest("article").find(".label-spinner").removeClass("hidden");
            $this.closest("section").find("input.presentThana").val('');
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                    $this.removeClass("textbox-spinner");
                    $this.closest("article").find(".label-spinner").addClass("hidden");
                }
            });
        } //source ends
    });
    
    $("input.presentThana_NONEED" ).autocomplete({
        source: function(request, response) {
            var src= baseUrl + '/autocompletes/thanas.php?extra=asdf';
            var $this = this.element;
            $this.addClass("textbox-spinner");
            $this.closest("article").find(".label-spinner").removeClass("hidden");
            var districtName = $this.closest("section").find("input.presentDistrict").val();
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                    district : districtName
                },
                success: function(data) {
                    response(data);
                    $this.removeClass("textbox-spinner");
                    $this.closest("article").find(".label-spinner").addClass("hidden");
                }
            });
        } //source ends
    });
  
    $("input.permanentDistrict_NONEED" ).autocomplete({
        // source:  baseUrl + 'autocompletes/districts.php'
        source: function(request, response) {
            var src= baseUrl + '/autocompletes/districts.php';
            var $this = this.element;
            $this.addClass("textbox-spinner");
            $this.closest("article").find(".label-spinner").removeClass("hidden");
            $this.closest("section").find("input.permanentThana").val('');
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term
                },
                success: function(data) {
                    response(data);
                    $this.removeClass("textbox-spinner");
                    $this.closest("article").find(".label-spinner").addClass("hidden");
                }
            });
        } //source ends
    });
    
    $("input.permanentThana_NONEED" ).autocomplete({
        source: function(request, response) {
            var src= baseUrl + '/autocompletes/thanas.php?extra=asdf';
            var $this = this.element;
            $this.addClass("textbox-spinner");
            $this.closest("article").find(".label-spinner").removeClass("hidden");
            var districtName = $this.closest("section").find("input.permanentDistrict").val();
            $.ajax({
                url: src,
                dataType: "json",
                data: {
                    term : request.term,
                    district : districtName
                },
                success: function(data) {
                    response(data);
                    $this.removeClass("textbox-spinner");
                    $this.closest("article").find(".label-spinner").addClass("hidden");
                }
            });
        } //source ends
    });

    // Handle payment section
    // $(".paymentChannel").closest('.field').hide();
    // $(".bankName").closest('.field').hide();
    // $(".branchName").closest('.field').hide();
    // $(".feeAmount").closest('.field').hide();
    // $(".draftOrSlipNo").closest('.field').hide();
    // $(".paymentSlipScanCopy").closest('.field').hide();
    $("input[name=hasPaidPreviously]").change(function(e){
        let selectedValue = $(this).val();
        if(selectedValue.toLowerCase() == 'yes'){
            // $(".paymentChannel").closest('.field').show();
            // $(".paymentDetail").closest('.field').show();        
            $(".paymentChannel").closest('.field').removeClass('hidden');
            $(".bankName").closest('.field').removeClass('hidden');        
            $(".branchName").closest('.field').removeClass('hidden');        
            $(".feeAmount").closest('.field').removeClass('hidden');        
            $(".draftOrSlipNo").closest('.field').removeClass('hidden');        
            $(".paymentSlipScanCopy").closest('.field').removeClass('hidden');        
        } else {
            // $(".paymentChannel").val('').closest('.field').hide();
            // $(".paymentDetail").val('').closest('.field').hide();
            $(".paymentChannel").val('').closest('.field').addClass('hidden');
            $(".bankName").val('').closest('.field').addClass('hidden');
            $(".branchName").val('').closest('.field').addClass('hidden');
            $(".feeAmount").val(0).closest('.field').addClass('hidden');
            $(".draftOrSlipNo").val('').closest('.field').addClass('hidden');
            $(".paymentSlipScanCopy").val('').closest('.field').addClass('hidden');
        }
    });

    function validationRule() {
        if ($("select[name=contactNo]").val() != $("select[name=reContactNo]").val()) {
            $.sweetModal({
                content: 'Contact number did not match.',
                icon: $.sweetModal.ICON_WARNING
            });
            $("select[name=contactNo]").addClass('error');
            $("select[name=reContactNo]").addClass('error');

            return false;
        }

        if (isNewApplicant == "yes") {
            if (!ValidatePhoto("ApplicantPhoto", 100, 300, 300)) {
                return false;
            }

            if (!ValidatePhoto("ApplicantSignature", 100, 80, 300)) {
                return false;
            }
        }

        var checked = $('#DeclarationApproval').is(':checked');
        if (!checked) {
            $.sweetModal({
                content: 'Please provide your consent in the declaration section.',
                icon: $.sweetModal.ICON_WARNING
            });
            return false;
        }
        return true;
    }

    // function validationRule() {
    //     if(validationFailed){
    //         return false;
    //     }

    //     //other wise return true.
    //     return true;
    // }

    
    
    $('form').swiftChanger(null); //Or use null

    $('#application-form').swiftSubmit({
        redirect: true
    }, validationRule, null, null, null, null);



}); //Document.ready//