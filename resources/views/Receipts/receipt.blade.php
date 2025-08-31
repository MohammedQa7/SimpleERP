<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #1a1a1a;">
    <div
        style="max-width: 800px; margin: 0 auto; background-color: #2d2d2d; padding: 40px; box-shadow: 0 0 20px rgba(0,0,0,0.5); border: 1px solid #404040;">

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 20px;">
            <h1 style="color: #a995c9; font-size: 36px; margin: 0; font-weight: bold;">PAYMENT RECEIPT</h1>
            <p style="color: #cccccc; font-size: 18px; margin: 5px 0 0 0; font-weight: bold;">
                {{ $payment_transaction->payment_number }}</p>
        </div>

        <!-- Payment Status Banner  -->
        <div
            style="background: linear-gradient(135deg, #1b4332 0%, #2d5a3d 100%); border: 2px solid #4caf50; color: #4caf50; padding: 20px; margin-bottom: 30px; border-radius: 8px; text-align: center; position: relative; overflow: hidden;">
            <div
                style="position: absolute; top: 0; left: 0; right: 0; height: 3px; background: linear-gradient(90deg, #4caf50, #66bb6a, #4caf50);">
            </div>
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px; margin-bottom: 8px;">
                <span style="font-size: 24px;">✓</span>
                <strong style="font-size: 18px; letter-spacing: 1px;">PAYMENT SUCCESSFULLY PROCESSED</strong>
            </div>
            <div
                style="background-color: rgba(76, 175, 80, 0.1); padding: 8px 16px; border-radius: 20px; display: inline-block; margin-top: 5px;">
                <span style="font-size: 14px; color: #81c784;">Transaction ID:
                    {{ $payment_transaction->payment_number }}</span>
            </div>
        </div>

        <!-- Company Info -->
        <div style="background-color: #a995c9; color: white; padding: 20px; margin-bottom: 30px; border-radius: 4px;">
            <h2 style="margin: 0 0 10px 0; font-size: 20px;">COMPANY NAME</h2>
            <p style="margin: 0; line-height: 1.5;">
                123 Business Street, City, State 12345<br>
                contact@company.com | (555) 123-4567
            </p>
        </div>

        <!-- Payment From Section -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: #a995c9; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">PAYMENT RECEIVED FROM
            </h3>
            <div
                style="background-color: #3a3a3a; padding: 15px; border-left: 4px solid #a995c9; border-radius: 0 4px 4px 0;">
                <p style="margin: 0; font-weight: bold; color: #ffffff;">{{ $invoice->order->customer->full_name }}</p>
                <p style="margin: 5px 0 0 0; color: #cccccc; line-height: 1.5;">
                    456 Client Avenue, Client City, State 67890<br>
                    {{ $invoice->order->customer->email }} | {{ $invoice->order->customer->phone_number }}
                </p>
            </div>
        </div>

        <!-- Payment Details -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: #a995c9; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">PAYMENT DETAILS</h3>
            <div style="background-color: #3a3a3a; padding: 20px; border-radius: 4px; border: 1px solid #404040;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; color: #cccccc; width: 150px;">Receipt Number:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #ffffff;">
                            {{ $payment_transaction->payment_number }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #cccccc;">Payment Date:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #ffffff;">
                            {{ $payment_transaction->created_at }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #cccccc;">Payment Method:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #ffffff;">
                            {{ $payment_transaction->method }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #cccccc;">Reference Invoice:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #ffffff;">{{ $invoice->invoice_number }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #cccccc;">Status:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #4caf50;">APPROVED & PROCESSED</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Payment Items -->
        <div style="margin-bottom: 30px;">
            <h3 style="color: #a995c9; margin: 0 0 15px 0; font-size: 16px; font-weight: bold;">ITEMS PAID</h3>
            <div style="border-radius: 4px; overflow: hidden; border: 1px solid #404040;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #a995c9; color: white;">
                            <th style="padding: 12px; text-align: left; font-weight: bold;">Item</th>
                            <th style="padding: 12px; text-align: center; font-weight: bold; width: 60px;">Qty</th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; width: 100px;">Unit Price
                            </th>
                            <th style="padding: 12px; text-align: right; font-weight: bold; width: 100px;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice->order->orderitems as $item)
                            <tr style="border-bottom: 1px solid #404040; background-color: #3a3a3a;">
                                <td style="padding: 15px 12px; vertical-align: top;">
                                    <strong style="color: #ffffff;">{{ $item->product->name }}</strong><br>
                                    <span style="color: #cccccc; font-size: 14px;">
                                        {{ $item->product->description }}
                                    </span>
                                </td>
                                <td
                                    style="padding: 15px 12px; text-align: center; vertical-align: top; color: #ffffff;">
                                    {{ $item->quantity }}</td>
                                <td style="padding: 15px 12px; text-align: right; vertical-align: top; color: #ffffff;">
                                    ${{ $item->product->selling_price }}
                                </td>
                                <td
                                    style="padding: 15px 12px; text-align: right; vertical-align: top; font-weight: bold; color: #ffffff;">
                                    ${{ $item->total_amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Summary -->
        <div style="margin-bottom: 30px;">
            <div style="background-color: #3a3a3a; padding: 20px; border-radius: 4px; border: 1px solid #404040;">
                <table style="width: 100%; max-width: 350px; margin-left: auto;">
                    <tr style="border-top: 2px solid #a995c9;">
                        <td
                            style="padding: 15px 0 8px 0; text-align: right; font-size: 20px; font-weight: bold; color: #a995c9;">
                            Total Paid:</td>
                        <td
                            style="padding: 15px 0 8px 20px; text-align: right; font-size: 20px; font-weight: bold; color: #a995c9; width: 120px;">
                            ${{ $invoice->order->total_price }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <div
            style="background-color: #3a3a3a; padding: 20px; border-left: 4px solid #a995c9; border-radius: 0 4px 4px 0;">
            <h4 style="color: #a995c9; margin: 0 0 10px 0; font-size: 14px; font-weight: bold;">PAYMENT CONFIRMATION
            </h4>
            <p style="margin: 0; color: #cccccc; line-height: 1.6; font-size: 14px;">
                Thank you for your payment. This receipt confirms that your payment has been successfully processed and
                approved.
                The funds have been credited to our account. For any questions concerning this payment receipt,
                please contact our accounting department with reference number
                {{ $payment_transaction->payment_number }}.
            </p>
            <p style="margin: 15px 0 0 0; color: #999999; font-size: 12px; font-style: italic;">
                This payment receipt was generated electronically and is valid without a signature.
            </p>
        </div>

    </div>
</body>

</html>
