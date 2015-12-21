$(document).ready(function(){
	var left = $('#box').position().left;
	var top = $('#box').position().top;
	var width = $('#box').width();
	
	$('#search_box').keyup(function(){
		var value = $(this).val();
		
		if(value != ''){
			$('#vyhledavac_result').show();
			$.post('vyhledavac.php', {value: value}, function(data){
				$('#vyhledavac_result').html(data);
			});
		} else {
			$('#vyhledavac_result').hide();
		}
		
	});
	
});