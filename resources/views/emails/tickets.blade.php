<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ваши билеты в театр</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: #8B0000;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 30px;
        }
        .ticket {
            background: #f9f9f9;
            border-left: 4px solid #8B0000;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .ticket-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .qr-code {
            text-align: center;
            margin-top: 15px;
        }
        .footer {
            background: #f4f4f4;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .button {
            display: inline-block;
            background: #8B0000;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎭 Театр имени Аяза Гилязова</h1>
            <p>Ваши электронные билеты</p>
        </div>
        
        <div class="content">
            <h2>Здравствуйте, {{ $customerName }}!</h2>
            <p>Благодарим вас за покупку билетов. Ваши электронные билеты прикреплены к письму.</p>
            
            <h3>Информация о заказе:</h3>
            <p><strong>Номер заказа:</strong> #{{ $order->id }}</p>
            <p><strong>Дата заказа:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            <p><strong>Сумма:</strong> {{ number_format($order->total_amount, 2) }} ₽</p>
            
            <h3>Ваши билеты:</h3>
            @foreach($order->tickets as $ticket)
                <div class="ticket">
                    <div class="ticket-info">
                        <strong>{{ $ticket->show->spectacle->title }}</strong>
                        <span>{{ $ticket->show->start_time->format('d.m.Y H:i') }}</span>
                    </div>
                    <div class="ticket-info">
                        <span>Ряд: {{ $ticket->row }}, Место: {{ $ticket->seat }}</span>
                        <span>{{ number_format($ticket->price, 2) }} ₽</span>
                    </div>
                    <div class="qr-code">
                        <img src="data:image/png;base64,{{ $ticket->generateQrCode() }}" 
                             alt="QR код" width="150">
                    </div>
                </div>
            @endforeach
            
            <div style="text-align: center;">
                <a href="{{ route('profile.orders') }}" class="button">
                    Посмотреть все билеты
                </a>
            </div>
            
            <p style="margin-top: 20px;">
                <strong>Важно!</strong> Пожалуйста, сохраните этот email и приложенные билеты. 
                Для входа в театр необходимо предъявить электронный билет (на экране телефона или распечатанный).
            </p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Театр имени Аяза Гилязова. Все права защищены.</p>
            <p>Это письмо сформировано автоматически. Пожалуйста, не отвечайте на него.</p>
        </div>
    </div>
</body>
</html>