@extends('layouts.app')

@section('content')
  <div class="panel panel-default">
    <div class="panel-body">
      <form enctype="multipart/form-data" action="{{ url('product/csv') }}" method="post" class="form-horizontal">
        <div class="form-group">
          <label class="col-sm-3 control-label" for="csv">Загрузить таблицу</label>
          <div class="col-sm-6">
            <input name="csv" type="file" id="csv" class="form-control">
            <input type="submit" name="" id="">
          </div>
        </div>
      </form>
    </div>
  </div>
  @if($products->count())
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3>Таблица продуктов</h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>Картинка</th>
            <th>Категория</th>
            <th></th>
          </tr>
          </thead>
          <tbody>
          @foreach( $products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ $product->desc }}</td>
              <td>{{ $product->price }}</td>
              <td><img src="{{ asset($product->img) }}" alt="" width="75" height="50"></td>
              <td>{{ $product->category }}</td>
              <td>
                <a href="{{ url('product/edit/'. $product->id) }}" class="btn btn-default">Редактировать</a>
                <a href="{{ url('product/delete/'. $product->id) }}" class="btn btn-danger">Удалить</a>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  @endif
@endsection
