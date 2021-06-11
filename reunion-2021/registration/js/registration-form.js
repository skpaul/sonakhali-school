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

    $(".swiftNumeric").swiftNumericInput({ allowFloat: false, allowNegative: false });

    $('.district-combo').change(function(){

        var districtCombo = $(this);
        districtCombo.attr('disabled','disabled');
        var districtType = $(this).attr('data-districttype'); //districtType = "Present" or "Permanent"
        var thanaCombo = $('#' + districtType + 'Thana');
        thanaCombo.empty();
        var selectedDistrict = districtCombo.val();
      

        $.ajax({
            url: baseUrl + '/reunion-2021/registration/get-thanas.php?district=' + selectedDistrict,
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


    // //PresentThanaCode combo chane handler starts------->
    // $('#PresentThanaCode').change(function(){
    //     $('#PresentThanaName').val($("#PresentThanaCode option:selected").text());
    // });
    // //<----- PresentThanaCode combo chane handler starts

    // var isChecked =  $("input:radio[name='"+inputName+"']").is(":checked");
    function validationRule() {
        if (!ValidatePhoto("ApplicantPhoto", 100, 300, 300)) {
            return false;
        }
        return true;
    }

    $('#application-form').swiftSubmit({
        redirect: true
    }, validationRule, null, null, null, null);

}); //Document.ready//