
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

    <p>
        Your registration transaction is now under review.
        To complete your payment via GCash, please follow the guide below.
    </p>

    <hr>

    <h3>📱 How to Pay via GCash</h3>

    <ol>
        <li>Open the GCash App on your phone.</li>
        <li>Tap <strong>Send Money</strong>.</li>
        <li>Select <strong>Express Send</strong>.</li>
        <li>Enter the recipient's GCash mobile number.</li>
        <li>Enter the amount you want to pay.</li>
        <li>Optional: Add a note (e.g., "Payment for Transaction #260613182935").</li>
        <li>Tap <strong>Next</strong> and review the payment details.</li>
        <li>Tap <strong>Send</strong>.</li>
        <li>Wait for the confirmation message with the Reference Number.</li>
        <li>Save or screenshot the confirmation.</li>
    </ol>

    <hr>

    <h3>💳 Pay via Bank Transfer</h3>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th align="left">Bank</th>
            <th align="left">Account Number</th>
            <th align="left">Account Name</th>
        </tr>
        <tr>
            <td>Bank of the Philippine Islands (BPI)</td>
            <td>123456789</td>
            <td>Juan Dela Cruz</td>
        </tr>
        <tr>
            <td>Banco de Oro (BDO)</td>
            <td>123456789</td>
            <td>Juan Dela Cruz</td>
        </tr>
        <tr>
            <td>Metrobank</td>
            <td>123456789</td>
            <td>Juan Dela Cruz</td>
        </tr>
        <tr>
            <td>Land Bank of the Philippines (LANDBANK)</td>
            <td>123456789</td>
            <td>Juan Dela Cruz</td>
        </tr>
    </table>

    <hr>

    <h3>📤 After GCash or Bank Transfer</h3>

    <p>✅ Take a screenshot or photo of your payment confirmation.</p>

    <p>
        ✅ Send the proof of payment (with your Name, Amount, and Reference Number)
        through the transaction confirmation page:
    </p>

    <p>
        <a href="http://localhost:3000/transaction-confirmation?transaction={{ $data['transaction_number'] }}">
            Submit Payment Confirmation
        </a>
    </p>

    <hr>

    <h3>📝 Sample Confirmation</h3>

    <p>
        <strong>Transaction Number:</strong> 123456789011<br>
        <strong>Name:</strong> Jesus Nazareno<br>
        <strong>Phone Number:</strong> 09123456789<br>
        <strong>Amount:</strong> ₱2,500.00<br>
        <strong>Reference Number:</strong> GCASH123456789
    </p>

    <hr>

    <p>
        Thank you for registering. We look forward to seeing you at the event!
    </p>

</body>
</html>
```
