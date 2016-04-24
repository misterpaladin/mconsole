@extends('mconsole::app')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light">
                @include('mconsole::partials.portlet-title', [
                    'title' => trans('mconsole::docs.title'),
                ])
                <div class="portlet-body">
                    @foreach ($docsets as $docset)
                        <h3>{{ $docset->title }} @if ($docset->description) <small>{{ $docset->description }}</small> @endif</h3>
                        <ul>
                            @foreach ($docset->docs as $doc)
                                <li><a href="#">{{ $doc->title }}</a></li>
                            @endforeach
                        </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection