<!-- BEGIN MEGA MENU -->
<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
<div class="hor-menu collapse in">
	<ul class="nav navbar-nav">
		@foreach ($mconsole_menu as $menu)
			<li class="menu-dropdown classic-menu-dropdown ">
				@if (!isset($menu->child))
					<a href="/mconsole/{{ $menu->url }}">{{ (trans('mconsole::' . $menu->translation) == $menu->translation) ? $menu->name : trans('mconsole::' . $menu->translation) }}<span class="arrow"></span></a>
				@else
					<a href="#">{{ trans('mconsole::' . $menu->translation) }}<span class="arrow"></span></a>
					<ul class="dropdown-menu pull-left">
						@foreach ($menu->child as $child)
					        <li>
					            <a href="/mconsole/{{ $child->url }}" class="nav-link">{{ (trans('mconsole::' . $child->translation) == $child->translation) ? $child->name : trans('mconsole::' . $child->translation) }}</a>
					        </li>
				        @endforeach
				    </ul>
				@endif
			</li>
		@endforeach
	</ul>
</div>
<!-- END MEGA MENU -->
