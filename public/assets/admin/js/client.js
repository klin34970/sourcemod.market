$(function() 
{
	var user_id = $("meta[name='user_id']").attr("content");
	var user_url = $("meta[name='user_url']").attr("content");
	var socket = io.connect('https://sourcemod.devsapps.com:10001');

	if(user_id > 0)
	{
		socket.emit('user_info', 
		{
			id: user_id,
			location: user_url,
		});

		socket.on('user_' + user_id, function(sdata) 
		{
			realtime_notifications('/ajax/notifications/list', user_id);
		});

		load_notifications('/ajax/notifications/list', user_id);
	}

	socket.on('users', function(sdata) 
	{
		var sum = 0;
		$.each(sdata, function(index, value)
		{
			if(value != null)
			{
				if(value.online)
				{
					$('.page-users-list #' + value.id).removeClass('bg-danger').addClass('bg-success');
					$('.page-scripts #' + value.id).removeClass('img-bordered-danger').addClass('img-bordered-success');
					$('.page-users #' + value.id).removeClass('img-bordered-danger').addClass('img-bordered-success');
					$('.page-community-replies #' + value.id).removeClass('img-bordered-danger').addClass('img-bordered-success');
					sum++;
				}
				else
				{
					$('.page-users-list #' + value.id).removeClass('bg-success').addClass('bg-danger');
					$('.page-scripts #' + value.id).removeClass('img-bordered-success').addClass('img-bordered-danger');
					$('.page-users #' + value.id).removeClass('img-bordered-success').addClass('img-bordered-danger');
					$('.page-community-replies #' + value.id).removeClass('img-bordered-success').addClass('img-bordered-danger');
				}
			}
		});
		
		$('#counter_online').html(sum);
	});
});
	