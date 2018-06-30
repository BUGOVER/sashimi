@extends('layouts.app')

@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Редактирование Заявки</h3>
        </div>
        <div class="panel-body">
            <form method="post" action="{{ url('product/edit/'.$product->id) }}">
            <table class="table table-striped">
                <tr>
                    <td>Имя</td> <td><input class="form-control" name="name" value="{{ $product->name }}" type="text"></td>
                </tr>
                <tr>
                    <td>Адрес</td> <td><input class="form-control" name="desc" value="{{ $product->desc }}" type="text"></td>

                </tr>
                <tr>
                    <td>Телефон</td> <td><input class="form-control" name="price" value="{{ $product->price }}" type="text"></td>
                </tr>
                <tr>
                    <td>Способ доставки</td> <td><input class="form-control" name="img" value="{{ $product->img }}" type="text"></td>
                </tr>
                <tr>
                    <td>Подезд</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Этаж</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Сдача</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Время доставки</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Час</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Минуты</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Кафе</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>
                <tr>
                    <td>Скидка</td><td><input class="form-control" name="category" value="{{ $product->category }}" type="text"></td>
                </tr>

                <tr>
                    <td colspan="2"><input class="btn btn-success" type="submit" value="Отправить"></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
@endsection