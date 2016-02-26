@extends('mconsole::app')

@section('title', trans('mconsole::sections.news.title') . ' | Mconsole')
@section('page.title', trans('mconsole::sections.news.title'))
@section('page.subtitle', trans('mconsole::sections.list'))

@section('content')

@include('mconsole::partials.table')

@endsection