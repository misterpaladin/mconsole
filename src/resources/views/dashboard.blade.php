@extends('mconsole::app')

@section('content')
    
    <div class="row">
        <div class="col-xs-12">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-bulb font-dark"></i>
                        <span class="caption-subject font-dark bold uppercase">Мудрость минуты</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <ul class="media-list">
                        <li class="media">
                            <img width="95px" class="media-object pull-left hidden-xs" src="/massets/mudrec.png">
                            <div class="media-body">
                                <blockquote>
                                    <p>“ {{ $quote['text'] }} „</p>
                                    <small><cite title="Source Title">{{ $quote['author'] }}</cite></small>
                                </blockquote>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection