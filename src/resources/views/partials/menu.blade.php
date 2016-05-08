<!-- BEGIN MEGA MENU -->
<!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
<!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
<div class="hor-menu collapse in">
	<ul id="main-menu" class="nav navbar-nav" data-ajax="/mconsole/users/{{ Auth::id() }}/menus">
        @foreach ($mconsole_menu as $menu)
            @if ($menu->visible)
    			<li class="menu-dropdown classic-menu-dropdown main-menu-item" data-key="{{ $menu->key }}">
    				@if (count($menu->menus) == 0)
                        @if (isset($menu->url))
                            <a href="/mconsole/{{ $menu->url }}">{{ $menu->name }}<span class="arrow"></span></a>
                        @else
                            <a href="javascript:;">{{ $menu->name }}<span class="arrow"></span></a>
                        @endif
    				@else
                        @if (isset($menu->url))
                            <a href="/mconsole/{{ $menu->url }}">{{ $menu->name }}<span class="arrow"></span></a>
                        @else
                            <a href="javascript:;">{{ $menu->name }}<span class="arrow"></span></a>
                        @endif
    					<ul class="dropdown-menu pull-left">
    						@foreach ($menu->menus as $child)
    					        @if ($child->visible)
                                    @if (count($child->menus) > 0)
                                        <li class="dropdown-submenu" data-key="{{ $child->key }}">
        					                <a href="/mconsole/{{ $child->url }}" class="nav-link nav-toggle">{{ $child->name }}</a>
                                            <ul class="dropdown-menu">
                                                @foreach ($child->menus as $subChild)
                                                    <li data-key={{ $subChild->key }}>
                                                        <a href="{{ $subChild->url }}" class="nav-link ">{{ $subChild->name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
            					        </li>
                                    @else
                                        <li data-key="{{ $child->key }}">
                                            @if (isset($child->url))
            					                <a href="/mconsole/{{ $child->url }}" class="nav-link nav-toggle">{{ $child->name }}</a>
                                            @else
                                                <a href="javascript:;" class="nav-link nav-toggle">{{ $child->name }}</a>
                                            @endif
            					        </li>
                                    @endif
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
