$(function(){
	$('#submit').button();
	
	$('#login').submit(function(){
		
		$.post('/ajax/login.php', $(this).serialize(), function(data){
			if((data)==1){
				window.location="index.php";
			}
			else {
				$('#error').html('Login Failed, please try again.');
				$('#login input[name=password]').val('').focus();
			}
		})
		return false;
	})
})