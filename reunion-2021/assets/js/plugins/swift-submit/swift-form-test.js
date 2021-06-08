﻿//form-express 	: It's a handy tool to quickly submit the html form.
//author		: Saumitra Kumar Paul. skpaul@gmail.com.
//Copyright		: You are free to use it anywhere anytime. But a thank-giving mail is appretiatable.
//Last update   : 29th March, 2021

// This plugin handles-
// form onsubmit event of JavaScript and 
// $('form').submit of JQuery.


(function ($) {
    $.fn.swiftSubmit = function (options,validationRules, onBeforeSend, onSuccess, onError, onComplete) {

       // var $Selector = this.selector;
        var $This = $(this);
        var $Form = $(this);
        

        var settings = $.extend({
            format: "auto",
            form: "",
            action: "", //submit url
            method: "POST",
            redirect: false, // whether it will return to other page
            redirectURL: ""
           // resetForm: true
        }, options);

        var $ActionUrl;
        if (settings.action == "") {
            $ActionUrl = $Form.attr('action');

            var buttonFormAction = $This.attr('formaction');
            if (typeof buttonFormAction != "undefined") {
                $ActionUrl = $ActionUrl + "/" + buttonFormAction;
            }
        }
        else {
            $ActionUrl = settings.action;
        }

        var $DefaultButtonText = "";

        function ResetForm(HtmlForm) {
            HtmlForm.trigger('reset');
            $('select.resetIt', HtmlForm).each(function () {
                // $(this).select2("val", "");
                var defaultValue = $(this).attr('data-default-value');
                var defaultText = $(this).attr('data-default-text');
                $(this).empty().append('<option value="' + defaultValue + '">' + defaultText + '</option>');
            });

            $('select.emptyIt', HtmlForm).empty();

            $(HtmlForm).find('input:visible:first').focus();
        }

        function IsMobileNumberValid(mobileNumber) {
            mobileNumber = mobileNumber.trim();
        
            if (mobileNumber == '') { return false; }
            if (isNaN(mobileNumber)) { return false; }
        
            if (mobileNumber.length < 10) { return false; }
        
            var operatorCodes = ["013", "014" ,"015", "016", "017", "018", "019"];
        
            //if the number is 1711781878, it's length must be 10 digits
            if (mobileNumber.startsWith("1")) {
                if (mobileNumber.length != 10) { return false; }
                var firstTwoDigits = mobileNumber.substr(0, 2); //returns 17, 18 etc,
                var operatorCode = "0" + firstTwoDigits; //Make first two digits a valid operator code with adding 0.
                if (!operatorCodes.includes(operatorCode)) { return false; }
                return true;
            }
        
            if (mobileNumber.startsWith("01")) {
                //if the number is 01711781878, it's length must be 11 digits
                if (mobileNumber.length != 11) { return false; }
                var operatorCode = mobileNumber.substr(0, 3); //returns 017, 018 etc,
                if (!operatorCodes.includes(operatorCode)) { return false; }
                return true;
            }
        
            if (mobileNumber.startsWith("8801")) {
                //if the number is 8801711781878, it's length must be 13 digits
                if (mobileNumber.length != 13) { return false; }
                var operatorCode = mobileNumber.substr(2, 3); //returns 017, 018 etc,
                if (!operatorCodes.includes(operatorCode)) { return false; }
                return true;
            }
        
            return false;
        }

        var $currentMessage;
        function ValidatePhoto(fileInputControl, maximumKB, requiredHeight, requiredWidth){
                

            // var fileName = $("#"+ fileInputId +"").val();
            var fileName = fileInputControl.val();

            // var title = $("#"+ fileInputId +"").attr("title");
            var title = fileInputControl.attr("data-swift-title");

            if(fileName ==''){
                $currentMessage = "<strong>" + title + "</strong>" + " required.";
                showError($currentMessage, fileInputControl);
                return false;
            }

            // var fileInput = $("#"+ fileInputId + "")[0];
            var fileInput = fileInputControl[0];
            var selectedFile = fileInput.files[0];
            
            var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpeg|.jpg)$/;

            var arrFileName = fileName.split("\\");

            var fileNameee = arrFileName[arrFileName.length-1]; 
            //fileNameSpan.html(arrFileName[arrFileName.length-1]);

            //check whether it is .jpeg or .jpg ---->
            if (!regex.test(fileName.toLowerCase())) {
                $currentMessage = "<strong>" + title + "</strong>" + " invalid. Please select a .jpg file.";
                showError($currentMessage, fileInputControl);
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
                $currentMessage = "<strong>" + title + "</strong>" + " size is too large. Maximum size is 100 kilobytes.";
                showError($currentMessage, fileInputControl);
                return false;
            }
            else{
                if(finalSize > maximumKB){ 
                    $currentMessage = "<strong>" + title + "</strong>" + " size is too large. Maximum size is 100 kilobytes.";
                    showError($currentMessage, fileInputControl);
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
                            $currentMessage =  "<strong>" + title + "</strong>" + " width invalid. Width must be " + requiredWidth + " pixel.";
                            showError($currentMessage, fileInputControl);
                            return false;
                        }                 
                        if (this.height != requiredHeight) {
                            $currentMessage = "<strong>" + title + "</strong>" + " height invalid. Height must be "+ requiredHeight  + " pixel.";
                            showError($currentMessage, fileInputControl);
                            return false;
                        }
                    };
                }
            }

            return true;
        }


        var $SubmitButton = $This.find('.form-submit-button');

        var $ButtonType = $SubmitButton.attr('type');
        // if (typeof $ButtonType !== typeof undefined && $ButtonType !== false) {
        //     $ButtonType = "button";
        // }
        // if ($ButtonType !== typeof undefined && $ButtonType !== false) {
        //     $ButtonType = "button";
        // }

        //Note: No need this click event handler.
        //$This.on('click', function (event) {
        //  //Note:: Don't use preventDefault. It will not trigger HTML5 form validation attributes.
        //  //event.preventDefault();
        //});

        function showError($message, $element){
            $.sweetModal({
                content: $message,
                icon: $.sweetModal.ICON_WARNING
            });

            $element.addClass("error");

            $('html,body').animate({
                scrollTop: $element.offset().top - 50
            }, 1000);
        }
  
        $Form.on('submit', function (event) {
            event.preventDefault();
            event.stopPropagation();
            var formErrorMessage="";
            var hasError = false;
            // var $currentElement;
            // var $currentMessage;
            
            $('.validate').each(function(i, obj) {

                var $this = $(this);
                var $currentElement = $this;

                // var title = $this.attr("title"); 
                // var label = $this.closest('.field').find('label').html();

                var title = $this.attr("data-swift-title");

                var requirementType = $this.attr('data-swift-required');
                var dataType = $this.attr("data-swift-datatype");
                var value = $this.val(); //$.trim();

                if($this.parent('.field').hasClass("hidden")){
                    return;
                }

                var isRequired = $this.attr('data-swift-required');
                if (isRequired !== false && typeof isRequired !== typeof undefined) {
                    if($this.is(':checkbox')){
                        var checked = $this.is(':checked');
                        if (!checked) {
                            hasError = true;
                            $currentMessage = "<strong>" + title + "</strong>" + " required.";
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }

                    if(isRequired == "required" && value == ""){
                        hasError = true;
                        // console.log($this.attr('name'));
                        $currentMessage = "<strong>" + title + "</strong>" + " required.";
                        showError($currentMessage, $currentElement);
                        return false;
                    }
                }

                var dataType = $this.attr("data-swift-datatype");
                if (dataType !== false && typeof dataType !== typeof undefined) {
                    var length = $.trim(value).length;
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        switch (dataType) {
                            case "email":
                                var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                if(!re.test(value)){
                                    hasError = true;
                                    $currentMessage= title + " invalid." ;
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }                                
                                break;
                            case "mobile":
                                if(!IsMobileNumberValid(value)){
                                    hasError = true;
                                    $currentMessage = "<strong>" + title + "</strong>"  + " invalid." ;
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }
                                break;
                            case "integer":
                            case "float":
                            case "double":
                            case "decimal":
                                if(isNaN(value)){
                                    hasError = true;
                                    $currentMessage= "<strong>" + title + "</strong>"  + " must be a valid number.";
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }
                                break;
                            case "date":
                                var dateValue = moment(value, "DD-MM-YYYY");
                                if(!dateValue.isValid()){
                                    hasError = true;
                                    $currentMessage= "<strong>" + title + "</strong>"  + " invalid." ;
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }
                                
                                break;
                            default:
                                // hasError = true;
                                // $currentMessage= "Datatype undefined for " + "<strong>" + title + "</strong>" + ".";
                                // return false;
                                break;
                        }
                    }
                }

                var minLength = $this.attr("data-swift-minlen");
                if (minLength !== false && typeof minLength !== typeof undefined) {
                    var length = $.trim(value).length;
                    minLength = parseInt(minLength);
                    
                    //if required, must be valid. If optional and no data then skip otherwise must be valid.
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        if(length < minLength){
                            hasError = true;
                            console.log($this.attr('name'));
                            $currentMessage = "<strong>" + title + "</strong>"  + " must be equal or greater than " + minLength + " characters.";
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }
                }

                var maxLength = $this.attr("data-swift-maxlen");
                if (maxLength !== false && typeof maxLength !== typeof undefined) {
                    var length = $.trim(value).length;
                    maxLength = parseInt(maxLength);
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        if(length > maxLength){
                            hasError = true;
                            console.log($this.attr('name'));
                            $currentMessage = "<strong>" + title + "</strong>"  + " must be equal or less than "+ maxLength +" characters.";
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }
                }

                var exactLength = $this.attr("data-swift-exactlen");
                if (exactLength !== false && typeof exactLength !== typeof undefined) {
                    var length = $.trim(value).length;
                    exactLength = parseInt(exactLength);
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        if(length !== exactLength){
                            hasError = true;
                            console.log($this.attr('name'));
                            $currentMessage = "<strong>" + title + "</strong>"  + " must have "+ exactLength +" characters." ;
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }
                }

                var minValue = $this.attr("data-swift-minval");
                if (minValue !== false && typeof minValue !== typeof undefined) {
                    //Specific datatype is must for minimum value validation. 
                    if (dataType !== false && typeof dataType === typeof undefined) {
                        hasError = true;
                        $currentMessage= "Datatype undefined for " + "<strong>" + title + "</strong>" + ".";
                        showError($currentMessage, $currentElement);
                        return false;
                    }

                    var length = $.trim(value).length;
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        if(dataType == "integer" || dataType == "float" || dataType == "double" || dataType == "decimal"){
                            if(isNaN(value)){
                                hasError = true;
                                $currentMessage= "<strong>" + title + "</strong>"  + " must be a valid number.";
                                showError($currentMessage, $currentElement);
                                return false;
                            }
                        }
                        
                        switch (dataType){
                            case "integer":
                                value = parseInt(value);
                                minValue = parseInt(minValue);
                                break;
                            case "float":
                            case "double":
                            case "decimal":
                                value = parseFloat(value);
                                minValue = parseFloat(minValue);
                                break;
                            case "date":
                                var value = moment(value, "DD-MM-YYYY");
                                if(!value.isValid()){
                                    hasError = true;
                                    $currentMessage= "<strong>" + title + "</strong>"  + " invalid." ;
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }
                                minValue = moment(minValue, "DD-MM-YYYY");
                                break;
                            default: 
                                hasError = true;
                                $currentMessage= "Datatype undefined for " + "<strong>" + title + "</strong>"  + ".";
                                showError($currentMessage, $currentElement);
                                return false;
                        }
                        
                        if(value < minValue){
                            hasError = true;
                            $currentMessage= "<strong>" + title + "</strong>"  + " must be equal or greater than " + minValue + ".";
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }
                }

                var maxValue = $this.attr("data-swift-maxval");
                if (maxValue !== false && typeof maxValue !== typeof undefined) {
                    //Specific datatype is must for maximum value validation. 
                    if (dataType !== false && typeof dataType === typeof undefined) {
                        hasError = true;
                        $currentMessage= "Datatype undefined for " + title + ".";
                        showError($currentMessage, $currentElement);
                        return false;
                    }

                    var length = $.trim(value).length;
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        if(dataType == "integer" || dataType == "float" || dataType == "double" || dataType == "decimal"){
                            if(isNaN(value)){
                                hasError = true;
                                $currentMessage= "<strong>" + title + "</strong>"  + " must be a valid number.";
                                showError($currentMessage, $currentElement);
                                return false;
                            }
                        }
                        
                        switch (dataType){
                            case "integer":
                                value = parseInt(value);
                                maxValue = parseInt(maxValue);
                                break;
                            case "float":
                            case "double":
                            case "decimal":
                                value = parseFloat(value);
                                maxValue = parseFloat(maxValue);
                                break;
                            case "date":
                                var value = moment(value, "DD-MM-YYYY");
                                if(!value.isValid()){
                                    hasError = true;
                                    $currentMessage= title + " invalid." ;
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }
                                maxValue = moment(maxValue, "DD-MM-YYYY");
                                break;
                            default: 
                                hasError = true;
                                $currentMessage= "Datatype undefined for " + "<strong>" + title + "</strong>" + ".";
                                showError($currentMessage, $currentElement);
                                return false;
                        }
                        
                        if(value > maxValue){
                            hasError = true;
                            $currentMessage= "<strong>" + title + "</strong>"  + " must be equal or less than " + maxValue + ".";
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }
                }

                var exactValue = $this.attr("data-swift-exactval");
                if (exactValue !== false && typeof exactValue !== typeof undefined) {
                    //Specific datatype is must for exactimum value validation. 
                    if (dataType !== false && typeof dataType === typeof undefined) {
                        hasError = true;
                        $currentMessage= "Datatype undefined for " + title + ".";
                        showError($currentMessage, $currentElement);
                        return false;
                    }

                    var length = $.trim(value).length;
                    if(isRequired == "required" || (isRequired == "optional" && length>0)){
                        if(dataType == "integer" || dataType == "float" || dataType == "double" || dataType == "decimal"){
                            if(isNaN(value)){
                                hasError = true;
                                $currentMessage= "<strong>" + title + "</strong>"  + " must be a valid number.";
                                showError($currentMessage, $currentElement);
                                return false;
                            }
                        }
                        
                        switch (dataType){
                            case "integer":
                                value = parseInt(value);
                                exactValue = parseInt(exactValue);
                                break;
                            case "float":
                            case "double":
                            case "decimal":
                                value = parseFloat(value);
                                exactValue = parseFloat(exactValue);
                                break;
                            case "date":
                                var value = moment(value, "DD-MM-YYYY");
                                if(!value.isValid()){
                                    hasError = true;
                                    $currentMessage= "<strong>" + title + "</strong>"  + " invalid." ;
                                    showError($currentMessage, $currentElement);
                                    return false;
                                }
                                exactValue = moment(exactValue, "DD-MM-YYYY");
                                break;
                            default: 
                                hasError = true;
                                $currentMessage= "Datatype undefined for " + "<strong>" + title + "</strong>"  + ".";
                                showError($currentMessage, $currentElement);
                                return false;
                        }
                        
                        if(value != exactValue){
                            hasError = true;
                            $currentMessage= "<strong>" + title + "</strong>"  + " must be equal to " + exactValue + ".";
                            showError($currentMessage, $currentElement);
                            return false;
                        }
                    }
                }

                if($this.hasClass("photo")){
                    var maxSizeInKb = $this.attr("data-swift-maxkb");
                    var requiredHeight = $this.attr("data-swift-height");
                    var requiredWidth = $this.attr("data-swift-width");
                    if (!ValidatePhoto($this, parseInt(maxSizeInKb), parseInt(requiredHeight), parseInt(requiredWidth))) {
                        hasError = true;
                        //NOTE: $currentMessage has been set inside the ValidatePhoto()
                        return false;
                    }
                }

                if($this.hasClass("signature")){
                 
                    var maxSizeInKb = $this.attr("data-swift-maxkb");
                    var requiredHeight = $this.attr("data-swift-height");
                    var requiredWidth = $this.attr("data-swift-width");
                    if (!ValidatePhoto($this, parseInt(maxSizeInKb), parseInt(requiredHeight), parseInt(requiredWidth))) {
                        hasError = true;
                        //NOTE: $currentMessage has been set inside the ValidatePhoto()
                        return false;
                    }
                }

                $currentElement.removeClass("error");
            });

          
            // if(hasError){              
            //     $.sweetModal({
            //         content: $currentMessage,
            //         icon: $.sweetModal.ICON_WARNING
            //     });

            //     $currentElement.addClass("error");

            //     $('html,body').animate({
            //         scrollTop: $currentElement.offset().top - 50
            //     }, 1000);

            //     return;
            // }
            // else{
            //     $currentElement.removeClass("error");
            // }

            if (hasError) {
                hasError=false;
                return;
            }

            if (validationRules) {
                if (validationRules() == false) {
                    return;
                }
            }

            var formData = new FormData(this);

            switch (settings.format) {
                case 'auto':
                    SubmitFormAsAuto(formData);
                    break;
                case 'json':
                    SubmitFormAsJson();
                    break;
                default:
                    console.log('Form not configured properly.\n Please use format="auto" format="json".');
                    break;
            }
        });

        function beforeSendFunction() {
            if (onBeforeSend) {
                onBeforeSend();
            }
            else {
                if ($ButtonType == 'button') {
                    $DefaultButtonText = $SubmitButton.html();
                    $SubmitButton.html('Working…');
                    $SubmitButton.attr('disabled', 'disabled');
                }
                else {
                    $DefaultButtonText = $SubmitButton.val();
                    $SubmitButton.val('Working…');
                    $SubmitButton.attr('disabled', 'disabled');
                }
            }
        }

        function successFunction(response) {
            if (onSuccess) {
                onSuccess(response);
            }
            else {
                var $response;
                try {
                    $response = $.parseJSON(response);
                }
                catch(err) {
                    console.log(response);
                    console.log("Error Code: 12547. Details: " + err);
                    $SubmitButton.removeAttr('disabled');
                    return false;
                }
               
                if($response.issuccess == typeof undefined){
                    $SubmitButton.removeAttr('disabled');
                    alert("Problem in saving data. Please try again.");
                    return false;
                }
              
            
                if($response.issuccess){
                    // $('#submit-spinner').hide();
                    if (settings.resetForm) {
                        ResetForm($Form);
                    }
    
                    if (settings.redirect == true) {
                        if (settings.redirectURL == "") {
                            window.location = $response.redirecturl;
                        }
                        else{
                            window.location = settings.redirectURL;
                        }
                    }
                    else{
                        //if don't redirect to another url,
                        //only then show popup alert.

                        $.sweetModal({
                            content: $response.message,
                            icon: $.sweetModal.ICON_WARNING
                        });

                        $SubmitButton.removeAttr('disabled');
                        if ($ButtonType == 'button') {
                            $SubmitButton.html($DefaultButtonText);
                        }
                        else {
                            $SubmitButton.val($DefaultButtonText);
                        }
                    }
                }
                else{
                    $.sweetModal({
                        content: $response.message,
                        icon: $.sweetModal.ICON_WARNING
                    });

                    $SubmitButton.removeAttr('disabled');
                    if ($ButtonType == 'button') {
                        $SubmitButton.html("Try again");
                    }
                    else {
                        $SubmitButton.val("Try again");
                    }
                }
            }
           
        }

        function errorFunction(xhr, status, error) {
            $('#submit-spinner').hide();
            if (onError) {
                onError(xhr, status, error);
            }
            else {
                HandleError(xhr, status, error);
            }
        }

        function completeFunction() {
            // $('#submit-spinner').hide();
            if (onComplete) {
                onComplete();
            }
            else {
                // $SubmitButton.removeAttr('disabled');
                // if ($ButtonType == 'button') {
                //     $SubmitButton.html($DefaultButtonText);
                // }
                // else {
                //     $SubmitButton.val($DefaultButtonText);
                // }
            }
        }

        function SubmitFormAsAuto(formData) {
            $.ajax({
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                type: settings.method,
                url: $ActionUrl,
                beforeSend: beforeSendFunction,
                success: successFunction,
                error: errorFunction,
                complete: completeFunction
            });
        }

        function SubmitFormAsJson() {
            var $JsonData = ConvertHtmlFormToJson($Form); //all input variables        

            $.ajax({
                data: JSON.stringify($JsonData),
                type: settings.method,
                url: $ActionUrl,
                contentType: 'application/json; charset=utf-8',
                dataType: 'json',
                beforeSend: beforeSendFunction,
                success: successFunction,
                error: errorFunction,
                complete: completeFunction
            });
        }

        function ConvertHtmlFormToJson(selector) {
            var ary = $(selector).serializeArray();
            var obj = {};
            for (var a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
            return obj;
        }

        function HandleError(jqXHR, textStatus, errorThrown) {
            var message = "Failed to execute.\n";
            switch (textStatus) {
                case "timeout":
                    message += "Operation timeout. Pleasy try again.";
                    message += "\n " + jqXHR.statusText + ' (' + jqXHR.status + ')';
                    break;
                case "error":
                    message += "An error ouccured.";
                    message += "\n " + jqXHR.statusText + ' (' + jqXHR.status + ')';
                    break;
                case "abort":
                    message += "Request aborted.";
                    message += "\n " + jqXHR.statusText + ' (' + jqXHR.status + ')';
                    break;
                case "parsererror":
                    message += "Parser error.";
                    message += "\n " + jqXHR.statusText + ' (' + jqXHR.status + ')';
                    break;
                default:
                    message += "An unexpected error occured.";
                    message += "\n " + jqXHR.statusText + ' (' + jqXHR.status + ')';
                    break;
            }

            $.sweetModal({
                content: message,
                icon: $.sweetModal.ICON_WARNING
            });

            console.log(jqXHR.status); //statusText: "Not Found"
            console.log(jqXHR.statusText); //statusText: "Not Found"
            console.log(textStatus);
            console.log(errorThrown);

        }
    };

}(jQuery));