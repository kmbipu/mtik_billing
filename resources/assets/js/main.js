(function() {

    "use strict";

	var site_url = $("meta[name='site-url']").attr('content');

	
	$("document").ready(function(){
		
		
		$("#select-router-for-pools").change(function(){
			
		   var r_id = $(this).val();
		   var e = $("#load-pools-by-router");
		   e.html("<option value=''>Select Pool</option>");

		   if(r_id=='' || r_id==undefined)
				return;									
		   $.ajax({
		      url: site_url+'/admin/pools/get-by-router/'+r_id,
			  type: 'GET',
		      dataType: 'json',
		      success: function(data) {
				 
				 var html = "<option value=''>Select Pool</option>";
		         for(var i=0;i<data.length;i++){
					html += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
				 }
				 e.html(html);
		      },
			  error: function(xhr){
				alert("Unable to load pools. Reload and try again.")
			  }		      
		   });				
			
		})
		
		
		$("#select-router-for-plans").change(function(){
			
		   var r_id = $(this).val();
		   var e = $("#load-plans-by-router");
		   e.html("<option value=''>Select Plan</option>");

		   if(r_id=='' || r_id==undefined)
				return;									
		   $.ajax({
		      url: site_url+'/admin/plans/get-by-router/'+r_id,
			  type: 'GET',
		      dataType: 'json',
		      success: function(data) {
				 
				 var html = "<option value=''>Select Plan</option>";
		         for(var i=0;i<data.length;i++){
					html += "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
				 }
				 e.html(html);
		      },
			  error: function(xhr){
				alert("Unable to load plans. Reload and try again.")
			  }		      
		   });				
			
		})
		
		
		
		
	
	
	
	});  

})();