function checkAvailability(){
	$("#loaderIcon").show();
	
	$.ajax({
		type:"POST",
		url:"check_availability.php",
		cache:false,
		data:{
			type:1,
			username:$("#username").val(),
		},
		success:function(data){
			$("#user-availability-status").html(data);
			$("#loaderIcon").hide(1000);
		}
	});
}
