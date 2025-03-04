<h1>Здравствуйте, {{ $order['customer_name'] }}!</h1>
<p>Ваша запись на автомойку подтверждена:</p>
<ul>
    <li><strong>Дата:</strong> {{ $order['date'] }}</li>
    <li><strong>Время:</strong> {{ $order['time'] }}</li>
    <li><strong>Автомобиль:</strong> {{ $order['car_type'] }}</li>
</ul>
<p>Ждём вас! 🚗</p>
