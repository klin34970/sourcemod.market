@foreach($notifications as $notification)
<a href="{{ URL::route('notifications.view', ['id' => $notification->id]) }} " class="media {{ $notification->view == 0 ? 'to-see' : '' }}">
	<div class="media-object pull-left">
		<i class="{{ $notification->icon }}"></i>
	</div>
	<div class="media-body">
		<span class="media-text">
			{{ $notification->text }}
		</span>
		<!-- Start meta icon -->
		<span class="media-meta">{{ $notification->last_time->diffForHumans() }}</span>
		<!--/ End meta icon -->
	</div><!-- /.media-body -->
</a><!-- /.media -->
@endforeach