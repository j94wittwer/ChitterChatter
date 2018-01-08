/**
 * chat JavaScript Flie. Lädt neue Nachrichten, sendet neue und andere Kleinigkeiten
 *
 * Silas Meier
 * 1.0
 * 18.12.2017
 */

$(document).ready(function(){
	change_favicon("/img/WLM_logo.svg.png");
	var documentTitle = document.title;
	var changeTitle = false;
	var newMessageCounter = 0;
	$('#sendmessage').click(function(){
		sendmessage();
	});


	$('#arrow').click(function(){
		$('#chat').animate({ scrollTop: $('#chat')[0].scrollHeight }, 600);
	});
	
	$(document).keypress(function(e) {
		if(e.which == 13) {
			sendmessage();
			e.preventDefault();
		}
	});
	$(".chatbody").scroll(function(){
		showArrow();
	});
	
	setInterval(function(){
		$.ajax({url: "../resources/getmessage.php", success: function(result){
			if(result == 0){ //Wenn keine neue Nachricht vorhanden ist, wird 0 zurück gegeben von der getmessage.php datei und es wird nicht gescrollt.
			}else{
				$(".chatbody").append(result);
				if(changeTitle == true){
					newMessageCounter++;
				}
				changeTabTitle(true);
				scrollPrevention();
				if(result.indexOf('arno.jpg') != -1){
					playSound('referee.mp3');
				}else if(result.indexOf('nyan_cat.gif') != -1){
					playSound('nyan.mp3');
				}else{
					playSound('Speech On.wav');
				}
			}
		}});
	},100);
	
	window.onfocus = function() {
		changeTitle = false;
		newMessageCounter=0;
		changeTabTitle(false);
	};
	window.onblur = function() {
		changeTitle = true;
	};
	
	
	function sendmessage(){
		var message = $('#message').val();
		if(message == ''){}
		else{
		$.ajax({
            url     : '../resources/sendmessage.php',
            method  : 'post',
            data    : { 'message': message },
            success : function( response ) {
            }
        });
		scrollToBottom();
		$('#message').val("");
		}
	}

	function playSound($filename){
		var audio = new Audio('../sound/'+$filename+'');
		audio.play();
	}
	
	function showArrow(){
		if(($('#chat').scrollTop() + 100) < ($('#chat')[0].scrollHeight - $('#chat').height())){
			$('#arrow').css('display','block');
		}else{
			$('#arrow').css('display','none');
		}
	}
	
	function scrollPrevention(){
		if(($('#chat').scrollTop() + 200) > ($('#chat')[0].scrollHeight - $('#chat').height()) || $('#chat').scrollTop() == 0){
			scrollToBottom();
		}
	}
	
	function scrollToBottom(){
		$('#chat').scrollTop($('#chat')[0].scrollHeight);
	}
	
	function changeTabTitle(bool){
		if(newMessageCounter > 0 && bool == true){	
			document.title = '('+newMessageCounter+') ' + documentTitle;
			change_favicon("../img/favicon.png");
		
		}else{
			document.title = documentTitle;
			change_favicon("../img/WLM_logo.svg.png");
		}
	}
	
	function change_favicon(img) {
		var favicon = document.querySelector('link[rel="shortcut icon"]');
		
		if (!favicon) {
			favicon = document.createElement('link');
			favicon.setAttribute('rel', 'shortcut icon');
			var head = document.querySelector('head');
			head.appendChild(favicon);
		}
		
		favicon.setAttribute('type', 'image/png');
		favicon.setAttribute('href', img);
	}
});	