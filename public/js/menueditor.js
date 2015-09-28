/************************************************************/
/************************************************************/
/************************************************************/

var me = function () {
	
	if ( typeof(Editor_menu_options) != "object" || typeof(Menu_data) !=	"object" )
		return;
		
	me.$me				= $(".menueditor");
	me.$jsonarea		= $("[name=json]");
	me.load();
};

me.tmpl = {
	
	"button-box" 			: "<div class='me-button-box'></div>",
	"container" 			: "<ol class='me-container me-list'></ol>",
	"button-add" 			: "<div class='me-green-button me-add-item'>Добавить меню</div>",
	"button-sepp" 			: "<div class='me-green-button me-add-sepp'>Добавить разделитель</div>",
	"sepparator" 			: "<li class='me-item me-sepparator'><div class='me-item-parent'><div class='mei-drag'></div><div class='mei-remove'></div></div></li>",
	"item"					: "<li class='me-item'><div class='me-item-parent'><div class='mei-drag'></div><input class='mei-visible' type='checkbox'><div class='mei-name'></div><div class='mei-edit'></div><div class='mei-remove'></div><div class='mei-form'></div></div><ol class='me-list'></ol></li>",
	"form-hidden"			: "<input type='hidden'>",
	"form-input"			: "<div class='mei-form-item'><input type='text' class='mei-form-input'></div>",
	"form-checkbox"			: "<label class='mei-form-item mei-form-checkbox'><input type='checkbox'></label>",
	"form-select"			: "<div class='mei-form-item'><select class='mei-form-select'></select></div>",
	"form-select-option"	: "<option></option>"

};

me.load = function () {
	me.options	=  Editor_menu_options;
	me.data		=  Menu_data;
	me.build();
};

me.build = function () {

	me.set();

	me.to( me.data, me.$container );

};

me.to = function ( array, $box ) {

	var $el;

	for (var key in array) {

		$box.each( function () {

			$el = me.buildItem.call( this, array[key] );

			if ( typeof array[key].child != "undefined" ) {
				me.to( array[key].child, $el.find(".me-list") );
			}

		});

	}

}

me.addSepp = function () {

	var $el = $( me.tmpl["sepparator"] );

	me.$container.append( $el );

};

me.buildItem = function ( obj ) {
	
	obj = obj || false;

	if ((typeof obj == "string") && (obj == "sepparator")) {

		var $item		= $( me.tmpl["sepparator"] );

	} else {

		var $item		= $( me.tmpl["item"] );
		var $form		= $(".mei-form", $item);
		var $visible	= $(".mei-visible", $item);

		var $field, $input, i;

		if (obj) $visible.attr("checked", obj.visible);

		for ( var key in me.options.forms ) {

			$field = $( me.tmpl["form-" + me.options.forms[ key ].type ] );
			
			/** HIDDEN */
			if ( me.options.forms[ key ].type == "hidden" ) {
				
				$field.attr( "name", key );
				if (obj) 
					$field.val( obj.fields[ key ] );
				else if (me.options.forms[ key ].default)
					$field.val( me.options.forms[ key ].default );

			}

			/** INPUT */
			if ( me.options.forms[ key ].type == "input" ) {

				$input = $field.find( ".mei-form-input" );
				
				$input.attr( "name", key );
				$field.prepend( me.options.forms[ key ].name );

				if (obj) 
					$input.val( obj.fields[ key ] );
				else if (me.options.forms[ key ].default)
					$input.val( me.options.forms[ key ].default );

			}

			/** CHECKBOX */
			if ( me.options.forms[ key ].type == "checkbox" ) {

				$input = $field.find( "input" );
				
				$input.attr( "name", key );
				$field.append( me.options.forms[ key ].name );

				if (obj)
					$input.attr("checked", obj.fields[ key ] );
				else if (me.options.forms[ key ].default)
					$input.attr("checked", me.options.forms[ key ].default );

			}


			/** SELECT */
			if ( me.options.forms[ key ].type == "select" ) {

				$input = $field.find( "select" );
				
				$input.attr( "name", key );
				$field.prepend( me.options.forms[ key ].name );

				for ( i in me.options.forms[ key ].option) {
					$( me.tmpl["form-select-option" ] )
						.text( me.options.forms[ key ].option[i]["name"] )
						.val( me.options.forms[ key ].option[i]["value"] )
						.appendTo( $input );
				}

				if (obj) 
					$input.val( obj.fields[ key ] );
				else if (me.options.forms[ key ].default)
					$input.val( me.options.forms[ key ].default );

			}

			$form.append( $field );

		}

		$item
			.find("[name='itemname']")
			.each( me.itemName );

	}

	$( this ).append( $item );

	return $item;

};

me.itemName = function () {
	var $parent = $( this ).parents( ".me-item-parent" );
	var $name = $(".mei-name", $parent);
	var text = $( this ).val();

	$name.text( text );
};

me.presubmit = function ( callback ) {

	var data = me.getData.call( me.$container );
	
	var string = JSON.stringify( data );

	me.$jsonarea.val( string );

	$( this ).each( callback );

};

me.getData = function () {
	var $now, $list, $parent, i;
	var array = [];

	var $els = $( this ).children('.me-item');
		
	var size = $els.length;

	for (var key = 0; key < size; key++) {
		
		$now		= $els.eq( key );
		$list		= $now.find("> .me-list");
		$parent		= $now.find("> .me-item-parent");

		array.push({});

		if ( $now.hasClass("me-sepparator") ) {
			array[key] = "sepparator";
			continue;
		}

		array[key].visible = $parent.find(".mei-visible").is(":checked");
		
		array[key].fields = {};

		for (i in me.options.forms) {

			if ( me.options.forms[i].type == "checkbox" ) 
				array[key].fields[ i ] = $parent.find("[name='" + i + "']").is(":checked");
			else 
				array[key].fields[ i ] = $parent.find("[name='" + i + "']").val();

		}

		if ( $list.length ) {
			array[key].child = me.getData.call( $list );

			if ( !array[key].child.length )
				delete array[key].child;
		}

	}

	return array;
};

me.set = function () {

	/** Собираем освновные контейнеры под меню */
	me.$buttonBox = $( me.tmpl["button-box"] );
	me.$me.append( me.$buttonBox );
	me.$container = $( me.tmpl["container"] );
	me.$me.append( me.$container );

	me.$add = $( me.tmpl["button-add"] );
	me.$buttonBox.append( me.$add );
	
	if ( me.options.sepparator ) {

		me.$add = $( me.tmpl["button-sepp"] );
		me.$buttonBox.append( me.$add );

		$document.on("click", ".me-green-button.me-add-sepp", me.addSepp);

	}

	$document.on("click", ".mei-edit", function () {

		var $me = $(this).parent().find(".mei-form");

		me.$container.find(".mei-form:visible").not($me).hide();
		$me.toggle();

	});
	
	$document.on("click", ".mei-remove", function () {

		if ( confirm("Вы хотите удалить пункт меню?") == true ) {

		  	$(this).parent().parent().remove();

		} else return false;

	});
	
	$document.on("mouseenter", ".mei-drag", function () {

		var $parents = $( this ).parents(".me-container");

		$parents.find(".me-item-parent").addClass("me-handle");

	}).on("mouseleave", ".mei-drag", function () {

		setTimeout(function () {
			if ( !$document.find(".me-draged:visible").length ) 
				me.$me.find(".me-item-parent").removeClass("me-handle");
		}, 50);

	});

	$document.on("click", ".me-green-button.me-add-item", function () {
			
		me.$container.each( me.buildItem );

	});

	$document.on("paste change keyup", "[name='itemname']", me.itemName);
	
	me.$me.nestable({
		collapseBtnHTML				: "",
		expandBtnHTML				: "",
		rootClass					: 'menueditor',
		listClass					: "me-list",
		placeClass					: "me-placeholder",
		itemClass					: "me-item",
		handleClass					: "me-handle",
		dragClass					: "me-draged",
		noChildrenClass				: "me-sepparator",
		maxDepth					: me.options.deep,
		group						: 0,
		callback: function($me,e){
			
			$me.find(".me-item-parent").removeClass("me-handle");

		}
	});

	$document.on("click.submit", ".button.submit", function () {
		me.presubmit.call(this, function () {
			$( this ).parents("form").submit();
		})

		return false;
	});

};

/************************************************************/
/************************************************************/
/************************************************************/


x.exe["option-menueditor"] = ["me()"];