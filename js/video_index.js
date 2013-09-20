$(function(){
	$('.video img').click(function(){
		$('.show_details').remove();
		var n = $(this).parent().attr('id');
		if(n%8==0){
			var x = n;
		}
		else {
			var x = n - (n%8) + 8;
			while(!$('.video#'+x).length){
				x = x-1;
			}
			}
		$('.video#'+x).after('<div class="show_details"></div>')
		$('.show_details').hide().html($(this).parent().html())
			.find('div').show()
			.parent().find('img.video_cover').attr({
				width: "200",
				height: "300"
				})
			.parent().slideToggle()
			.find('button.video_order').button({
				icons :{primary: "ui-icon-cart"}
				})
			.click(function(){
				var path = '/ajax/insert_transitem.php?type=purchase&video_id='+$(this).attr('id')+'&price='+$(this).attr('data-price');
				$('.trans_confirm').load(path).dialog('open');
			}).parent()
			.find('button.video_rent').button({
				icons :{primary: "ui-icon-clock"}
				})
			.click(function(){
				var path = '/ajax/insert_transitem.php?type=rent&video_id='+$(this).attr('id')+'&price='+$(this).attr('data-price');
				$('.trans_confirm').load(path).dialog('open');
		});

	});

			
	$('div.trans_confirm').dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Video Added",
		buttons: {
			"Continue Browsing": function(){
				$(this).dialog('close');
			},
			"Go to Checkout": function(){
				window.location = "/order/checkout.php";
			}
		}
	});

	
	
	$('.offset#prev').button({
		icons :{primary: "ui-icon-seek-prev"}
		})
	$('.offset#next').button({
		icons :{secondary: "ui-icon-seek-next"}
		})		
	
})