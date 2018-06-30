@extends('layouts.app')

@section('content')
    <div>
        <h1>Кафе</h1>
    </div>
    <form id="cafeForm" action="{{ url('cafe') }}" method="post" class="form-horizontal">
        <div id="cafeBlock">
            @foreach($cafes as $key => $cafe)
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="csv">Название</label>
                        <div class="col-sm-7">
                            <input name="cafe[{{ $key }}][name]" type="text" value="{{ $cafe->name }}" id="csv" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="csv">Email</label>
                        <div class="col-sm-7">
                            <input name="cafe[{{ $key }}][email]" type="text" value="{{ $cafe->email }}" id="csv" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="csv">Номер</label>
                        <div class="col-sm-7">
                            <input name="cafe[{{ $key }}][number]" type="text" value="{{ $cafe->number }}" id="csv" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="csv">Смс оповещение</label>
                        <div class="col-sm-1">
                            <input name="cafe[{{ $key }}][sms]" {{ $cafe->sms ? 'checked' : '' }} type="checkbox" id="csv" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-1">
                            <a href="{{ url('cafe/delete/'. $cafe->id) }}" class="btn btn-danger">Удалить</a>
                        </div>
                    </div>
                </div>
            </div>
                @endforeach
        </div>
        <div class="form-group">
            <div class="col-sm-1">
                <input name="csv" type="button" value="+" id="addCafe" class="btn btn-success form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3">
                <input name="csv" type="submit" id="csv" class="btn btn-success form-control">
            </div>
        </div>
    </form>
    <script>
        var key = {{ $key }};
        $('#addCafe').on('click', function () {
            key = key+1;
            var cafe = '<div class="panel panel-default"> \
                    <div class="panel-body"> \
                    <div class="form-group"> \
                    <label class="col-sm-4 control-label" for="csv">Название</label> \
                    <div class="col-sm-7"> \
                    <input name="cafe['+key+'][name]" type="text" id="csv" class="form-control"> \
                    </div> \
                    </div> \
                    <div class="form-group"> \
                    <label class="col-sm-4 control-label" for="csv">Email</label> \
                    <div class="col-sm-7"> \
                    <input name="cafe['+key+'][email]" type="text" id="csv" class="form-control"> \
                    </div> \
                    </div> \
                    <div class="form-group"> \
                    <label class="col-sm-4 control-label" for="csv">Номер</label> \
                    <div class="col-sm-7"> \
                    <input name="cafe['+key+'][number]" type="text" id="csv" class="form-control"> \
                    </div> \
                    </div> \
                    <div class="form-group"> \
                    <label class="col-sm-4 control-label" for="csv">Смс оповещение</label> \
            <div class="col-sm-1"> \
                    <input name="cafe['+key+'][sms]" type="checkbox" id="csv" class="form-control"> \
                    </div> \
                    </div> \
                    </div> \
                    </div>';
            $(cafe).appendTo('#cafeForm div:first');
        })
    </script>
@endsection