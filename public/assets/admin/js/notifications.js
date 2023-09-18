function load_notifications(url, user_id)
{
		$('.navbar-notification .niceScroll').scroll(function(e)
		{
			var scrollbarheight = $(this)[0].scrollHeight;
			var topheight = $(this).scrollTop();
			var outerheight = $(this).outerHeight();
			
			if(scrollbarheight - topheight === outerheight)
			{
				var counter = $('.navbar-notification .niceScroll').attr('counter');
				$.ajax({
					type: 'POST',
					url: url,
					data:
					{
						user_id: user_id,
						count: counter,
						type: 'load'
					},
					datatype: 'json',
					success: function (data)
					{
						if(data.success)
						{
							//console.log('take: ' + data.take);
							//console.log('skip: ' + data.skip);
							//console.log('count: ' + data.count);
							
							//var count = $("#notifications_count").text();
							//$("#notifications_count").text(parseInt(count)+data.count);
							
							$("#notifications").append(data.html);
							$('.navbar-notification .niceScroll').attr('counter', parseInt(counter) + data.take);
						}
					}
				});
			}
		});
}

function realtime_notifications(url, user_id)
{
	var counter = $('.navbar-notification .niceScroll').attr('counter');
	$.ajax({
		type: 'POST',
		url: url,
		data:
		{
			user_id: user_id,
			count: counter,
			type: 'new',
		},
		datatype: 'json',
		success: function (data)
		{
			if(data.success)
			{
				if(!$("#notifications_count").length)
				{
					$('.dropdown.navbar-notification .dropdown-toggle').append('<span id="notifications_count" class="count label label-danger rounded">');
				}
				
				$("#notifications_count").text(data.count);
				$("#notifications").html(data.html);
				$('.navbar-notification .niceScroll').attr('counter', data.count);
			}
			
			
		}
	});
}