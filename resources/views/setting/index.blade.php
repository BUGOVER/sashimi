@extends('layouts.app')

@section('content')
    <div>
        <h1>Настройки</h1>
    </div>
    <form action="{{ url('/') }}" method="post" class="form-horizontal">
    <div class="panel panel-default">
        <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="csv">Минимальная сумма заказа</label>
                    <div class="col-sm-7">
                        <input name="minSummDelivery" type="text" value="{{ $minSummDelivery }}" id="csv" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="csv">Граница бесплатной доставки</label>
                    <div class="col-sm-7">
                        <input name="freeSummDelivery" value="{{ $freeSummDelivery }}" type="text" id="csv" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="csv">Стоимость доставки</label>
                    <div class="col-sm-7">
                        <input name="summDelivery" value="{{ $summDelivery }}" type="text" id="csv" class="form-control">
                    </div>
                </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="csv">Код промо купона</label>
                    <div class="col-sm-7">
                        <input name="promoCupon" value="{{ $promoCupon }}" type="text" id="csv" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-4 control-label" for="csv">Размер скидки (в % от 0 до 100)</label>
                    <div class="col-sm-7">
                        <input name="discountPercent" value="{{ $discountPercent }}" type="text" id="csv" class="form-control">
                    </div>
                </div>
        </div>
    </div>
        <div class="form-group">
            <div class="col-sm-3 pull-right">
                <input name="csv" type="submit" id="csv" class="btn btn-success form-control">
            </div>
        </div>
    </form>

@endsection