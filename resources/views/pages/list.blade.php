@extends('mconsole::app')

@section('title', 'Страницы | Mconsole')

@section('content')

<form action="/mconsole/content/page">
	<fieldset class="list-filter openable hide">
		<legend>Фильтр</legend>
		
		<div class="field-box">
			<div class="field-name">Поиск</div>
			<input class="field-search" name="search_text" placeholder="По заголовкам, контенту" type="text" value=""></div>
		
		
	
	<div class="field-box">
		<div class="field-name">Язык (Lang)</div>
		<select class="field-select" name="lang_REQ">
			<option value="all">Все</option>
			<option value="ru">Русский</option><option value="en">Английский</option>
		</select>
	</div>
	<div class="field-box">
		<div class="field-name">Тип (Type)</div>
		<select class="field-select" name="type_REQ">
			<option value="all">Все</option>
			<option value="page">Страница</option><option value="mode">Модуль</option>
		</select>
	</div>

		
		<div class="field-box">
			<div class="field-name">Статус (State)</div>
			<select class="field-select" name="state_REQ"><option value="all">Все</option>
				<option value="on">Отображать</option><option value="off">Не отображать</option>
			</select></div>
		
		
		<div class="spec-functions-box">
			<div class="button submit">Применить фильтр</div>
			<div class="spec-functions-box-items">
				<span class="counter-name">Записей на стр.</span>
				<span class="counter">
					<select class="field-select" name="show_once">
						<option selected="selected" value="30">30</option><option value="60">60</option><option value="90">90</option><option value="120">120</option>
					</select><span class="number">30</span></span></div>
		</div>
	</fieldset>
</form>

<div class="list-table">
	<table>
		<thead>
			<tr>
				<th>#</th>
				<th>Изменен</th>
				<th>Заголовок</th>
				<th>&nbsp;&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($items as $item)
			<tr>
				<td>{{ $item->id }}</td>
				<td>{{ $item->updated_at->format('d.m.Y') }}</td>
				<td>{{ $item->heading }}</td>
				<td><a href="/mconsole/pages/edit/{{ $item->id }}" class="list-icon list-edit"></a>@if (!$item->system)<a href="/mconsole/pages/delete/{id}" class="list-icon list-remove"></a>@endif</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>

@endsection