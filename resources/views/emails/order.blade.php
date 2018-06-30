<h1>Поступил новый заказ из мобильного приложения</h1>
<div>
  <div>
    <span>Имя </span><b>{{ $order->name }}</b>
  </div>
  <div>
    <span>Телефон </span><b>{{ $order->phone }}</b>
  </div>
  <div>
    <span>Адрес </span><b>{{ $order->addres }}</b>
  </div>
  <div>
    <span>Способ доставки </span><b>@if($order->way_delivery == 'delivery')Доставка курьером@elseСамовывоз@endif</b>
  </div>
  <div>
    <span>Подъезд </span><b>{{ $order->porch }}</b>
  </div>
  <div>
    <span>Этаж </span><b>{{ $order->floor }}</b>
  </div>
  <div>
    <span>Время доставки </span><b>@if($order->time_delivery == 'fast')Как можно быстрее@else Ко времени@endif</b>
  </div>
  <div>
    <span>Час</span><b>{{ $order->hour }}</b>
  </div>
  <div>
    <span>Минут </span><b>{{ $order->min }}</b>
  </div>
  <div>
    <span>Кафе </span><b>{{ $cafe->name }}</b>
  </div>
  <div>
    <span>Промо </span><b>{{ $order->promo }}</b>
  </div>

  <div>
    <table border="1">
      <thead>
      <tr>
        <th>Название</th>
        <th>Количество</th>
        <th>Цена</th>
      </tr>
      </thead>
      <tbody>
      @foreach($productsForEmail as $product)
        <tr>
          <td>{{ $product['name'] }}</td>

          <td>{{ $product['count'] }}</td>

          <td>{{ $product['price'] }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>

  </div>
  <div>
    <span>Сумма </span><b>{{ $summ }}</b>
  </div>
  <div>
    <span>Скидка </span><b>{{ $discount }}</b>
  </div>
  <div>
    <span>Доставка </span><b>{{ $summDelivery }}</b>
  </div>
  <div>
    <span>К оплате </span><b>{{ $summ - $discount + $summDelivery }}</b>
  </div>
</div>

