@extends('app')

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
@stop

@section('styles')
    <link rel="stylesheet" href="/vendor/news/css/layout.css"/>
@stop

@section('scripts')
    <script src="/vendor/news/js/vendor/ckeditor/ckeditor.js"></script>
    <script src="/vendor/news/js/news-create.js"></script>
@stop

@section('content')
    <div class="row">
        <div class="small-12 columns">
            <h1>Create News Entry</h1>

            {!! Form::open([
                'method' => 'POST'
            ]) !!}
                <div class="row">
                    <div class="large-6 columns">
                        <label>Title
                            {!! Form::text('title',  '') !!}
                        </label>
                        <label>Is visible
                            {!! Form::checkbox('visible', true, false) !!}
                        </label>
                    </div>
                    <div class="large-6 columns ">
                        <label>Content
                            {!! Form::textarea('content',  '', [
                                'contenteditable' => 'true',
                                'class' => 'ckeditor editable',
                                'id' => 'news-create-content'
                            ]) !!}
                        </label>
                        <input type="submit" class="button success news-submit-button" value="Save News Entry">
                    </div>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection
