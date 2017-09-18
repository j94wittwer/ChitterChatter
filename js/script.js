$(document).ready(function(){
	$('.openinfodiv').click(function(){
		$('.infodiv').toggle();
	});
	$('.back').click(function(){
		$('.infodiv').toggle();
	});
	$('#pass1').keyup(function(){
		checkValue();
	});
	$('#pass2').keyup(function(){
		checkValue();
	});
	
	function checkValue(){
		setTimeout(function(){
			var pass1 = $('#pass1').val();
			var pass2 = $('#pass2').val();
			if(pass1 === pass2){
				$('#pass2').css("border-color","green");
				$('button').removeAttr('disabled');
			}else{
				$('#pass2').css("border-color","red");
				$('button').attr('disabled','disabled');
			}
		}, 10);
	}
});