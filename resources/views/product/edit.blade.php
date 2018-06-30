@extends('layouts.app')

@section('content')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3>Редактирование продукта</h3>
    </div>
    <div class="panel-body">
      <form method="post" action="{{ url('product/edit/'.$product->id) }}" enctype="multipart/form-data">
        <table class="table table-striped">
          <tr>
            <td>Имя</td>
            <td><input class="form-control" name="name" value="{{ $product->name }}" type="text"></td>
          </tr>
          <tr>
            <td>Описание</td>
            <td><input class="form-control" name="desc" value="{{ $product->desc }}" type="text"></td>

          </tr>
          <tr>
            <td>Цена</td>
            <td><input class="form-control" name="price" value="{{ $product->price }}" type="text"></td>
          </tr>
          <tr>
            <td>Картинка</td>
            <td><input class="form-control" name="img" value="{{ $product->img }}" type="file"></td>
          </tr>
          <tr>
            <td>Категория</td>
            <td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
          </tr>
          <tr>
            <td colspan="2"><input class="btn btn-success" type="submit" value="Отправить"></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
@endsection
