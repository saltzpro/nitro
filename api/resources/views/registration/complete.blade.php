
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration Order</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <h2 style="color: #2c3e50;">Thank You for Registering for Our Event!</h2>

    <p>
        <strong>Transaction Number:</strong><br>
        <span style="font-size: 18px; color: #e74c3c;">
            {{ $data['transaction_number'] }}
        </span>
    </p>

    <div>
        <h3>🛒 Order Summary</h3>

        <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse;">
            <thead style="background-color: #f5f5f5;">
                <tr>
                    <th align="left">Item</th>
                    <th align="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['orders'] as $order)
                <tr>
                    <td>{{ $order['order'] }}</td>
                    <td align="right">₱{{ number_format($order['amount'], 2) }}</td>
                </tr>
                @endforeach

                <tr style="font-weight: bold;">
                    <td align="right">Total</td>
                    <td align="right">
                        ₱{{ number_format(collect($data['orders'])->sum('amount'), 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <br>

    <p>
        Your registration has been successfully submitted.
        To complete your registration, please proceed with payment using Maya Checkout.
    </p>

    <div style="text-align:center; margin:30px 0;">
        <a href="{{ $data['maya_checkout_url'] }}"
           style="
                background:#00B14F;
                color:#ffffff;
                text-decoration:none;
                padding:15px 30px;
                border-radius:5px;
                display:inline-block;
                font-size:16px;
                font-weight:bold;
           ">
            Pay Now via Maya
        </a>
    </div>

    <p>
        After completing your payment, Maya will automatically process your transaction and redirect you back to our website.
    </p>

    <hr>

    <p>
        If you encounter any issues during payment, please contact our support team and provide your transaction number:
        <strong>{{ $data['transaction_number'] }}</strong>
    </p>

    <p>
        Thank you for registering. We look forward to seeing you at the event!
    </p>

</body>
</html>
