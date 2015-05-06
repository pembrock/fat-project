$(document).ready(function(){
	$('.send').click(function(){
		var name = $('.addComment').find('input').val();
		var text = $('.addComment').find('textarea').val();
		
		if(name != "" && text != ""){
			$.ajax({
				type: "POST",
				url: "http://test-form/test/addComment.php",
				data: {name: name, text: text},
				success: function(e){
					if (e == "ok")
				$('.addComment').find('input').val('');
				$('.addComment').find('textarea').val('');
				
				var d = new Date();

				var month = d.getMonth()+1;
				var day = d.getDate();

				var cur_date = ((''+day).length<2 ? '0' : '') + day + '-' +
							 ((''+month).length<2 ? '0' : '') + month + '-' +
							 d.getFullYear();
				
				var dt = new Date();
				var cur_time = dt.getHours() + ":" + dt.getMinutes();
				
				var app = "<div class='comment'><div class='commentInfo'><span class='name'>" + name + "</span><span class='time'>" + cur_time + "</span><span class='date'>" + cur_date + "</span></div><div>" + text + "</div></div>";
				
				$('.wrap').prepend(app);
				
				$('.addComment').find('input').attr('value', '');
				$('.addComment').find('textarea').val('');
				}
			});
		}
		else
			alert("Заполнены не все поля");
	});
});