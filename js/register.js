$(function(){
	$('#submit').button();

	$('#register').submit(function(){
		
		
		
		$.post('/ajax/register.php', $(this).serialize(), function(data){
			if((data)==1){
				alert('Congratulations, you have successfully registered.\nYou can now login with the username and password you supplied.');
				window.location = '/index.php';
			}
			else {
				alert(data);
			}
		})
		return false;
	})
})