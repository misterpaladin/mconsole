<!-- BEGIN MEGA MENU -->
<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
<div class="hor-menu collapse in">
	<ul id="main-menu" class="nav navbar-nav" data-ajax="/mconsole/users/{{ Auth::id() }}/menus">
        @foreach ($mconsole_menu as $menu)
            @if ($menu->visible)
    			<li class="menu-dropdown classic-menu-dropdown main-menu-item" data-key="{{ $menu->key }}">
    				@if (count($menu->child) == 0)
                        @if (isset($menu->url))
                            <a href="/mconsole/{{ $menu->url }}">{{ (trans('mconsole::' . $menu->translation) == $menu->translation) ? $menu->name : trans('mconsole::' . $menu->translation) }}<span class="arrow"></span></a>
                        @else
                            <a href="javascript:;">{{ (trans('mconsole::' . $menu->translation) == $menu->translation) ? $menu->name : trans('mconsole::' . $menu->translation) }}<span class="arrow"></span></a>
                        @endif
    				@else
                        @if (isset($menu->url))
                            <a href="/mconsole/{{ $menu->url }}">{{ (trans('mconsole::' . $menu->translation) == $menu->translation) ? $menu->name : trans('mconsole::' . $menu->translation) }}<span class="arrow"></span></a>
                        @else
                            <a href="javascript:;">{{ (trans('mconsole::' . $menu->translation) == $menu->translation) ? $menu->name : trans('mconsole::' . $menu->translation) }}<span class="arrow"></span></a>
                        @endif
    					<ul class="dropdown-menu pull-left">
    						@foreach ($menu->child as $child)
    					        @if ($child->visible)
                                    <li>
        					            <a href="/mconsole/{{ $child->url }}" class="nav-link">{{ (trans('mconsole::' . $child->translation) == $child->translation) ? $child->name : trans('mconsole::' . $child->translation) }}</a>
        					        </li>
                                @endif
    				        @endforeach
    				    </ul>
    				@endif
    			</li>
            @endif
		@endforeach
        @if (Auth::user()->role->widget || Auth::user()->role->key == 'root')
            <li class="menu-dropdown classic-menu-dropdown toggle-blade-helper">
                <a href="javascript:;"><i class="fa fa-magic"></i></a>
            </li>
        @endif
	</ul>
</div>
<!-- END MEGA MENU -->
