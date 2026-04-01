<!-- resources/views/pdf/ticket.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Электронный билет</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            background: #f4f4f4;
            padding: 40px 20px;
        }
        
        .ticket {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .ticket-header {
            background: linear-gradient(135deg, #8B0000 0%, #660000 100%);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        
        .ticket-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .ticket-header p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        .ticket-content {
            padding: 30px;
        }
        
        .spectacle-title {
            font-size: 24px;
            font-weight: bold;
            color: #8B0000;
            margin-bottom: 20px;
            text-align: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 15px;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .info-label {
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            color: #333;
        }
        
        .seat-info {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        
        .seat-number {
            font-size: 32px;
            font-weight: bold;
            color: #8B0000;
        }
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
            padding: 20px;
            background: white;
        }
        
        .ticket-footer {
            background: #f9f9f9;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px dashed #ddd;
        }
        
        .barcode {
            text-align: center;
            margin-top: 15px;
            font-family: monospace;
            font-size: 14px;
            letter-spacing: 1px;
            word-break: break-all;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .ticket {
                box-shadow: none;
            }
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="ticket-header">
            <h1>🎭 Театр имени А.С. Пушкина</h1>
            <p>Электронный билет</p>
        </div>
        
        <div class="ticket-content">
            <div class="spectacle-title">
                {{ $ticket->show->spectacle->title }}
            </div>
            
            <div class="info-row">
                <span class="info-label">📅 Дата и время:</span>
                <span class="info-value">{{ $ticket->show->start_time->format('d.m.Y') }} в {{ $ticket->show->start_time->format('H:i') }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">⏱️ Продолжительность:</span>
                <span class="info-value">{{ floor($ticket->show->spectacle->duration / 60) }}ч {{ $ticket->show->spectacle->duration % 60 }}мин</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">👤 Режиссер:</span>
                <span class="info-value">{{ $ticket->show->spectacle->director }}</span>
            </div>
            
            <div class="seat-info">
                <div style="margin-bottom: 10px;">Ваше место в зале:</div>
                <div class="seat-number">
                    Ряд {{ $ticket->row }} • Место {{ $ticket->seat }}
                </div>
            </div>
            
            <div class="info-row">
                <span class="info-label">💰 Цена:</span>
                <span class="info-value">{{ number_format($ticket->price, 2) }} ₽</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">🆔 Номер заказа:</span>
                <span class="info-value">#{{ $ticket->order_id }}</span>
            </div>
            
            <div class="info-row">
                <span class="info-label">📧 Покупатель:</span>
                <span class="info-value">{{ $ticket->order->customer_name }}</span>
            </div>
            
            <div class="qr-code">
                {!! QrCode::size(150)->generate(json_encode([
                    'ticket_id' => $ticket->id,
                    'show_id' => $ticket->show_id,
                    'seat' => $ticket->row . $ticket->seat,
                    'spectacle' => $ticket->show->spectacle->title,
                    'date' => $ticket->show->start_time->format('d.m.Y H:i')
                ])) !!}
            </div>
            <div class="barcode">
                {{ $ticket->qr_code }}
            </div>
        </div>
        
        <div class="ticket-footer">
            <p>❗ Вход в театр осуществляется по данному билету (на экране телефона или в распечатанном виде)</p>
            <p>Просим вас прибыть в театр за 30 минут до начала спектакля</p>
            <p style="margin-top: 10px;">© {{ date('Y') }} Театр имени А.С. Пушкина</p>
        </div>
    </div>
</body>
</html>