@foreach ($mconsole_menu as $menu)
	<a href="#" class="menu-item">{{ $menu->name }}</a>
	@if (isset($menu->child))
		<div class="menu-bundle">
			@foreach ($menu->child as $child)
			<a href="/mconsole/{{ $child->url }}" class="menu-item @if (Request::is($child->link)) active @endif">{{ $child->name }}</a>
			@endforeach
		</div>
	@endif
@endforeach