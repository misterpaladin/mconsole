@extends('mconsole::app')

@section('pageTitle', trans('mconsole::mconsole.errors.accessdenied.title'))

@section('content')

<div class="portlet light">
    @include('mconsole::partials.portlet-title', [
        'title' => trans('mconsole::mconsole.errors.accessdenied.title'),
    ])
    <div class="portlet-body">
        <p>{{ trans('mconsole::mconsole.errors.accessdenied.info') }}</p>
    </div>
</div>

@endsection