@extends('layouts.app')

@section('content')
{{ Form::open(
    array(
        'method'=>'post',
        'url' => URL::to('twitter/post'),
        'autocomplete'=>"off",
        'id' => "twitter-form",
        'enctype'=>"multipart/form-data",
        'class' => 'form-horizontal'
    ))
}}
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Twitter Post</h3>
                </div>

                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea class="form-control twPost" rows="2" id="twPost" name="twPost"></textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    @if(Session::get('access_token')!=null)
                        <button type="submit" class="btn btn-primary pull-right" role="button">Post</button>
                    @else
                        <a href="{{$login_url}}" class="pull-right">Login with Twitter</a>
                    @endif
                    <div class="clearfix"></div>
                </div>


            </div>
        </div>
    </div>
    {{--@if($postMessage!='')--}}
    {{--<div class="row">--}}
        {{--<div class="col-md-6 col-md-offset-3">--}}
            {{--<div class="panel panel-primary">--}}
                {{--<div class="panel-heading">--}}
                    {{--Post By : {{$postBy}}--}}
                {{--</div>--}}

                {{--<div class="panel-body">--}}
                    {{--<div class="form-group">--}}
                        {{--<div class="col-md-12">--}}
                            {{--{{$postMessage}}--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@foreach($commentBody as $comment)--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-6 col-md-offset-3">--}}
                {{--<div class="panel panel-success">--}}
                    {{--<div class="panel-heading">--}}
                        {{--Comment By : {{$comment['from']['name']}}--}}
                    {{--</div>--}}

                    {{--<div class="panel-body">--}}
                        {{--<div class="form-group">--}}
                            {{--<div class="col-md-12">--}}
                                {{--{{$comment['message']}}--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--@endforeach--}}
</div>
@endsection