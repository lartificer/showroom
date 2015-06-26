@extends('app')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@stop

@section('styles')
    <link rel="stylesheet" href="/vendor/news/css/layout.css"/>
@stop

@if(Auth::check())
    @section('scripts')
        <script src="/vendor/news/js/vendor/ckeditor/ckeditor.js"></script>
        <script src="/vendor/news/js/news-overview.js"></script>
    @stop
@endif


@section('content')
    <div class="row">
        <div class="small-12 columns">
            @if(Session::has('message'))
                <div class="message-container">
                    <div class="{{ Session::get('message-class') }}">
                        {{ Session::get('message') }}
                    </div>
                </div>
            @endif
            <h1>News Entries</h1>
            @if(Auth::check())
                <div class="row">
                    <div class="small-9 columns">
                        {!! Form::hidden('secret-visibility-route', trans('news::links.toggleVisibility')) !!}
                        {!! Form::hidden('secret-delete-route', trans('news::links.delete')) !!}
                        {!! Form::hidden('secret-update-route', trans('news::links.update')) !!}
                    </div>
                    <div class="small-3 columns">
                        <a href="{{ trans('news::links.create') }}" class="button success">{{ trans('news::button-labels.create-news') }}</a>
                    </div>
                </div>
            @endif
                {!! Form::open(['method' => 'POST']) !!}
                    @foreach($newsEntries as $index => $entry)
                        <div class="row">
                            <div class="medium-3 small-12 columns">
                                <div class="date-container">
                                    {{ date("F d, Y", strtotime($entry->created_at)) }}
                                </div>
                                @if(Auth::check())
                                    <div class="icon-panel">
                                        <div class="visibility-box">
                                            <label>Is visible
                                                @if($entry->visible == 1)
                                                    {!!  Form::checkbox('visible', 1, true, [
                                                        'class' => 'visibility-checkbox',
                                                        'data-entry-id' => $entry->id
                                                    ]) !!}
                                                @else
                                                    {!!  Form::checkbox('visible', 1, false, [
                                                        'class' => 'visibility-checkbox',
                                                        'data-entry-id' => $entry->id
                                                    ]) !!}
                                                @endif
                                            </label>
                                        </div>
                                        <a href="{{ trans('news::links.delete') . '/' . $entry->id }}" data-entry-id="{{ $entry->id }}" class="button alert remove-news-button">{{ trans('news::button-labels.remove-news') }}</a>
                                    </div>
                                @endif
                            </div>
                            <div class="medium-9 small-12 columns">
                                @if(Auth::check())
                                    <h2 class="editor headline" contenteditable="true" id="headlineEditor{{ $index }}" data-entry-id="{{ $entry->id }}">{!! $translations[$index]['title'] !!}</h2>
                                    <div class="editor content" contenteditable="true" id="contentEditor{{ $index }}" data-entry-id="{{ $entry->id }}">
                                        {!! $translations[$index]['content'] !!}
                                    </div>
                                @else
                                    <h2 class="editor headline" contenteditable="false" id="headlineEditor{{ $index }}" data-entry-id="{{ $entry->id }}">{!! $translations[$index]['title'] !!}</h2>
                                    <div class="editor content" contenteditable="false" id="contentEditor{{ $index }}" data-entry-id="{{ $entry->id }}">
                                        {!! $translations[$index]['content'] !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    {!! $newsEntries->render() !!}
                {!!  Form::close() !!}
        </div>
    </div>

@endsection
