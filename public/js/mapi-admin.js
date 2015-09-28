var madmin = function () {

	/** Первоначальные настройки карт */

	madmin.latlng				= [46.959118, 142.738068];
	madmin.zoom					= 14;
	madmin.maxZoom				= 18;
	madmin.currentMap			= -1;
	madmin.ready				= 0;

	/** Селекторы */
	madmin.$mapReplace			= $('#map-container-replace');
	madmin.$copyReplace			= $('#copy-buttons-replace');
	madmin.$copyCoord			= $('#copy-buttons');
	madmin.$container			= $('.map-container');
	madmin.$tabs				= $('.map-tabs .tab');
	madmin.$maps				= madmin.$container.find('.map-inner');

	/** Объекты карт */
	madmin.yandex;
	madmin.google;
	madmin.dgis;

	madmin.init();
	madmin.setListeners();

}

/** Копирование координат в буфер */
madmin.copyParam = function () {
	madmin.getCenter(madmin.$tabs.index(madmin.$tabs.filter('.active')));
	madmin.$copyCoord.find('#copy-coord-button').data('copy', madmin.latlng.toString());
	madmin.$copyCoord.find('#copy-zoom-button').data('copy', madmin.zoom.toString());
}

madmin.init = function () {
	
	/** Ициниализация кнопки копирования координат */
	madmin.$copyCoord.children().each(function () {
		$(this).zclip({
			path 			: '/massets/js/zeroclipboard/zclip.swf',
			copy 			: function () {
				madmin.copyParam();
				return $(this).data('copy');
			},
			afterCopy 		: function () { return false; }
		});
	});
	
	/** Yandex */
	ymaps.ready(function () {
		madmin.yandex = new ymaps.Map("yandex-map", {
			center: madmin.latlng,
			zoom: madmin.zoom,
			maxZoom: madmin.maxZoom
		});
		madmin.ready++;
	});

	/** Google */
	var mapCanvas = document.getElementById('google-map');
	var mapOptions = {
		center: new google.maps.LatLng(madmin.latlng[1], madmin.latlng[0]),
		zoom: madmin.zoom,
		maxZoom: madmin.maxZoom,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	}
	madmin.google = new google.maps.Map(mapCanvas, mapOptions);

	google.maps.event.addListenerOnce(madmin.google, 'idle', function () {
		madmin.ready++;
	});

	/** 2gis */
	DG.then(function () {
		madmin.dgis = DG.map('2gis-map', {
			"center": madmin.latlng,
			"zoom": madmin.zoom
		});
		madmin.ready++;
	});

	/** Проверка через каждую секунду на инициализацию карт */
	var init = setInterval(function () {
		if (madmin.ready == madmin.$maps.length) {
			madmin.$mapReplace.replaceWith(madmin.$container);
			madmin.$container.css({
				'position': 'relative',
				'left': 'auto'
			});
			madmin.$maps.hide();
			madmin.$tabs.parent().show();
			madmin.switchTab(0);
			madmin.$copyReplace.replaceWith(madmin.$copyCoord);
			madmin.$copyCoord.css({
				'position': 'relative',
				'left': 'auto'
			});
			clearInterval(init);
		}
	}, 1000);

}

madmin.changeMap = function (index) {
	
	madmin.currentMap = index;

	madmin.$maps.each(function (i) {
		madmin.$maps.eq(i).hide();
	});

	madmin.$maps.eq(index).show();
	
}

madmin.getCenter = function (index) {
	
	var latlng;
	
	switch (index) {

		/** Yandex */
		case 0:
			madmin.latlng = madmin.yandex.getCenter();
			madmin.zoom = madmin.yandex.getZoom();
			break;

			/** Google */
		case 1:
			latlng = madmin.google.getCenter();
			madmin.latlng = [latlng.lat(), latlng.lng()];
			madmin.zoom = madmin.google.getZoom();

			break;

			/** 2gis */
		case 2:
			latlng = madmin.dgis.getCenter();
			madmin.latlng = [latlng.lat, latlng.lng];
			madmin.zoom = madmin.dgis.getZoom();
			break;

		default:
			return;
	}
	
	madmin.setCenter();

}

/** Установка центра на всех картах */
madmin.setCenter = function () {
	madmin.yandex.setCenter(madmin.latlng);
	madmin.yandex.setZoom(madmin.zoom);
	madmin.google.setCenter(new google.maps.LatLng(madmin.latlng[0], madmin.latlng[1]));
	madmin.google.setZoom(madmin.zoom);
	madmin.dgis.setView(madmin.latlng, madmin.zoom);
}

madmin.switchTab = function (index) {

	/** Записываем координаты текущей карты */
	madmin.getCenter(madmin.$tabs.index(madmin.$tabs.filter('.active')));

	madmin.$tabs.each(function (i) {
		madmin.$tabs.eq(i).removeClass('active');
	});

	madmin.$tabs.eq(index).addClass('active');

	madmin.changeMap(index);

}

madmin.setListeners = function () {

	madmin.$tabs.on('click', function () {
		if (madmin.$tabs.index($(this)) != madmin.currentMap)
			madmin.switchTab(madmin.$tabs.index($(this)));
	});
	
	madmin.$copyCoord.find('a').on('click', function () {
		madmin.getCenter(madmin.$tabs.index(madmin.$tabs.filter('.active')));
		madmin.$copyCoord.find('input').val(madmin.latlng.toString());
	});

}

x.exe["option-mapi"] = ["madmin()"];