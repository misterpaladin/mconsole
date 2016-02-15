@foreach (Config::get('mconsole.menu') as $menu)
	<a href="#" class="menu-item">{{ $menu['name'] }}</a>
	@if (isset($menu['children']))
		<div class="menu-bundle">
			@foreach ($menu['children'] as $child)
			<a href="/mconsole/{{ $child['link'] }}" class="menu-item @if (Request::is($child['link'])) active @endif">{{ $child['name'] }}</a>
			@endforeach
		</div>
	@endif
@endforeach