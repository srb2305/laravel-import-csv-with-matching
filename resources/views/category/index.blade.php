@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> Category
                    <div class="pull-right">
                        <a href="{{url('product')}}"  class="btn btn-primary ">Product List</a> 
                        <a href="{{url('/')}}"  class="btn btn-primary">Import</a>
                     </div>
                </div>

                <div class="panel-body">
                   @if (count($errors) > 0)
                    <div class="alert alert-danger alert-dismissible">
                         <a href="#" class="close" data-dismiss="alert" aria-label="close" style="right: 0%;">&times;</a>
                        <strong>Oops</strong>
                       Something went wrong<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                            </tr>
                        </thead>

                        <tbody>
                        @if(!empty($data['category']))
                            @foreach($data['category'] as $list)
                            <tr id="rowid{{$list->id}}">
                                <td>{{ $list->id }}</td>
                                <td>{{ $list->name }}</td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="pull-right"> 
                        {{ $data['category']->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
