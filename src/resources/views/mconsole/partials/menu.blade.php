<!-- BEGIN MEGA MENU -->
<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
<div class="hor-menu collapse in">
	<ul class="nav navbar-nav">
		@foreach ($mconsole_menu as $menu)
			<li class="menu-dropdown classic-menu-dropdown ">
				@if (!isset($menu->child))
					<a href="/mconsole/{{ $menu->url }}">{{ $menu->name }}</a>
				@else
					<a href="#">{{ $menu->name }}</a>
					<ul class="dropdown-menu pull-left">
						@foreach ($menu->child as $child)
					        <li>
					            <a href="/mconsole/{{ $child->url }}" class="nav-link">{{ $child->name }}</a>
					        </li>
				        @endforeach
				    </ul>
				@endif
			</li>
		@endforeach
	</ul>
</div>
<!-- END MEGA MENU -->
