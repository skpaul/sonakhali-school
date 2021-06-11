/*
SwiftChanger

Description:
This plugin enables to switch between differen formSections within a form.
This is useful in a large form.
Using this plugin, you can split a large form into smaller section using .formSection class. 

*/


(function ($) {
    $.fn.swiftChanger = function(validationRules) {
        // this.find(prevButtonClassName).bind("click.swiftChanger",function(event){
        $(".goToPrevSection").bind("click.swiftChanger",function(event){
            event.preventDefault();
            var section = $(this.closest('.formSection'));
            section.css("display", "none");
            section.prev().css("display", "block");

            $element = $(section).prev().find("p:first-child");
            $('html,body').animate({
                scrollTop: $element.offset().top - 50
            }, 1000);
        });

        
      
        $(".goToNextSection").bind("click.swiftChanger",function(event){
            event.preventDefault();
            var section = $(this.closest('.formSection'));
           
            section.css("display", "none");
            section.next().css("display", "block");
          
            $element = $(section).next().find("p:first-child");
            $('html,body').animate({
                scrollTop: $element.offset().top - 50
            }, 1000);

        });

        $("#showPreview").click(function(e){
            var form = $("form");
            $('label.required').removeClass("required").addClass("white-required");
            $(".formSection", form).each(function(index, formSection) {
                $formSection  = $(formSection);
                $formSection.show(); //show all formSections
    
                var allFormControls = $(".formControl", $formSection);
    
                $(allFormControls).each(function(index, currentControl ) {
                    $currentControl = $(currentControl);
                    if($currentControl.hasClass("sectionNavigation")){
                        $currentControl.hide();
                    }

                    if(!$currentControl.hasClass("dontEnable")){
                        // $currentControl.attr("disabled", "disabled");
                        // $currentControl.css('pointer-events', 'none').css('');
                        $currentControl.css({'pointer-events':'none', 'border':'transparent', 'padding':'0', '-webkit-appearance': 'none', '-moz-appearance': 'none', 'text-indent': '1px'});
                       
                        //label.required::after
                    }
                });
            });
    
            $(".sectionNavigation").hide();
            $("#submitSection").show();
        });
    
        $("#closePreview").click(function(e){
            var form = $("form");
            $('label.white-required').addClass("required").removeClass("white-required");

            $(".formSection", form).each(function(index, element ) {
                $element  = $(element);
                var allFormControls = $(".formControl", $element);
                $(allFormControls).each(function(index, currentControl ) {
                   
                   
                    if($(currentControl).hasClass("dontEnable")){
                        //lagbe
                    }
                    else{
                        //   $currentControl.removeClass("previewMode");
                        $(this).css({'pointer-events':'', 'border':'1px solid rgba(172, 168, 168, 0.5)','padding':'5px 10px', '-webkit-appearance': '', '-moz-appearance': '', 'text-indent': '0px'});
                    }
                });
            });
    
            $("form .formSection:not(:last)").hide();
            $("#submitSection").hide();
            $(".sectionNavigation").show();
        });
    
    };
}(jQuery));



























