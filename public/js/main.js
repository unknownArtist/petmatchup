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

$(document).ready(function(){
        $("#statecan").hide();
        $this = $("#Country");
        $this.change(function(){

            
            if($this.val() == "1")
            {

                $('#state').show();
                $('#statecan').hide();
            }
            if($this.val() == "0")
            {
                $('#state').hide();
                $('#statecan').show();
            }    
        });
    });
