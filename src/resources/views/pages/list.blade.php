@extends('mconsole::app')

@section('title', trans('mconsole::sections.pages.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.pages.title'))
@section('page.subtitle', trans('mconsole::sections.list'))

@section('content')

@include('mconsole::partials.table')

@endsection