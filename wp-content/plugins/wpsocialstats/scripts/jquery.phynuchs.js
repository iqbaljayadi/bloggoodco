// 

jQuery(document).ready(function($){

	function phynuchs_save_settings(){

	    var enable = $('#phynuchs-enable-auto input[type="checkbox"]').is(':checked');
	    var parent = $('#phynuchs-enable-auto input[type="checkbox"]').parents('form');
	    if (enable) {
		enable="yes";
		alert("System will enable auto updates of your social stats");
		var phy_alert_str = "Auto updates enabled";
	    }  else {
		enable='no';
		alert("System will disable auto updates of your social stats");
		var phy_alert_str = "Auto updates disabled";
	    }

	    var post_str = '{"enable":"'+enable+'","hour":"00","minute":"00",';
	    post_str += '"type":"everyday"}';

		$.ajax({type:"POST", 
			url:phynuchs_ajax_url, 
			async:true,
			data:{'action':'save-auto-update-stat-options',
			      'phy-ajax-data':post_str}
			}).done(function(resp){
			    phynuchs_wait_stop(parent);

				if (resp != 'yes') {
					alert('Something Wrong!');
				    return;
				}

			    alert(phy_alert_str);
			 });
	}

	function phynuchs_retrive_settings(){
		
		$.ajax({type:"POST", 
			url:phynuchs_ajax_url, 
			async:true,
			data:{'action':'get-auto-update-stat-options',
			      'phy-ajax-data':'{}'}
			}).done(function(resp){
				
				console.log( resp );
				
				try {
					var myresp = eval('('+resp+')');

					if (myresp.enable=='yes')
						$('#phynuchs-enable-auto input[type="checkbox"]').attr('checked','checked');
					else
						$('#phynuchs-enable-auto input[type="checkbox"]').removeAttr('checked');
				    
				} catch (ex) {
					console.log(ex);
					alert("something wrong!");
				}
			   });
	}

	function phynuchs_wait(obj){
		var width = obj.innerWidth();
		var height = obj.innerHeight();

		$('<div id="phynuchs-ajax-loader" style="background: rgba(0, 0, 0, .5) url('+phynuchs_ajax_loader+') no-repeat center; width:'+width+'px;height:'+height+'px; position:absolute;"></div>').prependTo(obj);
	}

	function phynuchs_wait_stop(obj){
		$('div#phynuchs-ajax-loader', obj).remove();
	}


	$('#phynuchs-button').click(function(){
		var parent=$(this).parent();
		phynuchs_wait(parent);
		phynuchs_save_settings();
	});



	phynuchs_retrive_settings();
});