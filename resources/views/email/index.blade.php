@extends('layouts.app')

@section('content')
    {{ Form::open(
        array(
            'method'=>'post',
            'url' => URL::to('Q1/post'),
            'autocomplete'=>"off",
            'id' => "email-form",
            'enctype'=>"multipart/form-data",
            'class' => 'form-horizontal'
        ))
    }}

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Email Send</h3>
                    </div>

                    <div class="panel-body">
                        <div class="col-md-12">

                                <label for="subject">Subject</label>
                                <div class="form-group">
                                    <input type="text" id="subject" name="subject" class="form-control">
                                </div>

                                <label for="content">Mail Body</label>
                                <div class="form-group">
                                    <textarea class="form-control mailBody" rows="3" id="content" name="content"></textarea>
                                </div>

                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary pull-right" role="button">Send</button>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection