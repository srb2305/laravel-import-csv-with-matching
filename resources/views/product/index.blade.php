@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"> Products
                    <div class="pull-right">
                        <a href="{{url('/')}}"  class="btn btn-primary">Import</a> 

                        <a href="{{ url('export') }}" class="btn btn-primary ">Export</a>
                       
                        <a href="{{url('category')}}"  class="btn btn-primary">Category List</a>
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
                                <th>Title</th>
                                <th>SKU</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Category</th>
                            </tr>
                        </thead>

                        <tbody>
                        @if(!empty($data['product']))
                            @foreach($data['product'] as $list)
                            <tr id="rowid{{$list->id}}">
                                <td>{{ $list->title }}</td>
                                <td>{{ $list->sku }}</td>
                                <td>{{ $list->description }}</td>
                                <td>{{ $list->price }}</td>
                                <td>{{ $list->quantity }}</td>
                                <td>
                                @php
                                    $catStr = '';                
                                    $category =  $list->category;
                                    $catAry = explode(',',$category);
                                    foreach ($catAry as $key => $value) {
                                        $cat =   Helper::categoryName($value);
                                        $catStr = $catStr . $cat .',' ;
                                    }
                                @endphp    
                                    {{ rtrim($catStr,',') }}
                                </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <div class="pull-right"> 
                        {{ $data['product']->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection