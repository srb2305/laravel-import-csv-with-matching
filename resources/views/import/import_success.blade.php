@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">CSV Import</div>

                    <div class="panel-body">
                        Data imported successfully.
                         <a href="{{ url('product') }}" class="btn btn-primary pull-right">Show Product</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
