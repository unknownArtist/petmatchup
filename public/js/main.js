$(document).ready(function(){
	
	$("button").click(function (){
    
        $("#captcha").show("fast");
        $("button").hide();
    });

    $("submit").click(function(){
    	
    	$("#captcha").hide("fast");
    	$("button").hide("fast");
   
    });

});