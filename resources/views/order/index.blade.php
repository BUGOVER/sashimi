@extends('layouts.app')

@section('content')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <!--id="bootstrap-css">-->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->

  <script language="JavaScript"
          src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"
          type="text/javascript">
  </script>

  <script language="JavaScript"
          src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js"
          type="text/javascript">
  </script>

  <link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

  <link rel="stylesheet" type="text/css"
        href="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css">

  <script>
    $(document).ready(function() {
      $('#datatable').dataTable({'order': [[3, 'desc']]});

      $('[data-toggle=tooltip]').tooltip();

    });

  </script>

  <div>
    <h1>Заказы</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
        <tr>
          <th>ID</th>
          <th>Имя</th>
          <th>Телефон</th>
          <th>Адрес</th>
          <th>Дата и время</th>
          <th>Статус</th>
          <th></th>
        </tr>
        </thead>

        <tbody>
        @foreach( $orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->name }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->addres }}</td>
            <td>{{ $order->created_at }}</td>
            <td>{{ $order->status }}</td>
            <td>
              <a href="{{ url('order/edit/'. $order->id) }}" class="btn btn-default">Редактировать</a>
              <a href="{{ url('order/delete/'. $order->id) }}" class="btn btn-danger">Удалить</a>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>

    </div>
  </div>

@endsection
