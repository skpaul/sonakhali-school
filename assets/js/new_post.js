
$(function(){
    $("#city").on('input propertychange', function() {
        var cityTextbox = $("#city");
        var typedText = cityTextbox.val();
        if(typedText==''){
            $("#city-suggestion").hide();
            return;
        }
        var data = new FormData();
        data.append("text",typedText);
        $.ajax({
            url : baseUrl + 'lib/get_city_suggestion.php',
            type : "post",
            data: data,
            processData:false,
            contentType:false,
            success:function(response){
                console.log(response);
                var suggestionContainer = $("#city-suggestion");
                suggestionContainer.empty();
                $response = $.parseJSON(response);
                $.each($response.rows, function(){
                    suggestionContainer.append('<div class="item">'+ this.city_name +'</div>');
                })
                suggestionContainer.show();
            },
            error:function(a,b,c){
                console.log("error");
            }
        });
    });

    $.fn.extend({

        blurIfNot : function(options, handler)
        {
            var defaults =
            {
                except : [],
                maxParent : null // A DOM element within which
                                 // a matching element may be found
            };
            var opt = $.extend({}, defaults, options);
            var time = new Date().getTime();
            
            this.each(function()
            {
                var thisInp = $(this);
                thisInp[0].blurIfNot = {};
                time += 1000000000000;
                
                var except = opt.except;
                
                if ($.isFunction(opt.except))
                { except = opt.except.call(thisInp[0]); }
                
                function fire_blur_event(_tar, evt, mousedown)
                {
                    var proceed = true;
                    
                    for (var i in except)
                    {
                        if (_tar.is(thisInp) ||
                        _tar.closest(except[i], opt.maxParent).length)
                        {
                            proceed = false;
                            break;
                        }
                    }
                    if (proceed)
                    {
                        thisInp[0].blurIfNot.focus = false;
                        handler.call(thisInp[0], evt);
                    }
                    else if (mousedown)
                    {
                        $('html').one('mouseup', function(e)
                        {
                            thisInp[0].focus();
                        });
                    }
                }
                
                if (!thisInp[0].blurIfNot.isset)
                {
                    $('html').mousedown(function(e)
                    {
                        if (thisInp[0].blurIfNot.focus)
                        {
                            var tar = $(e.target);
                            
                            if (!tar.is('input'))
                            { fire_blur_event(tar, e, true); }
                        }
                    });
                    
                    $(window).blur(function(e)
                    {
                        if (thisInp[0].blurIfNot.focus)
                        {
                            thisInp[0].blurIfNot.focus = false;
                            handler.call(thisInp[0], e);
                        }
                    });
                }
                else
                {   // to be able to update the input event if you have
                    // created new inputs dynamically
                    $('input').off('focus.blufIfNot' + time);
                }
                
                $('input').on('focus.blurIfNot' + time, function(e)
                {
                    var tar = $(e.target);
                    
                    if (tar[0] == thisInp[0])
                    { thisInp[0].blurIfNot.focus = true; }
                    
                    else if (thisInp[0].blurIfNot.focus)
                    { fire_blur_event(tar, e); }
                });
                
                thisInp[0].blurIfNot.isset = true;
            });
            return this;
        }
    });

 $('#city').blur(function(){
     
 });

 $(document).on("click",".item", function(){
    $("#city").val('dddd');
    $("#city-suggestion").hide();
 });
 
    $('#city').blurIfNot(
        {
            except : [
                $('#city-suggestion')
            ]
           
        },
        
function(e)
{
    $("#city-suggestion").hide();
});
   
})


