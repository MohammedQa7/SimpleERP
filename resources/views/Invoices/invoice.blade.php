<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.3;
            background-color: #1a1a1a;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }

        .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #252525;
            padding: 30px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 8px;
            background-color: #333;
            color: #fff;
        }

        td {
            padding: 8px;
        }

        .header td {
            padding-bottom: 20px;
        }

        .items th,
        .items td {
            border-bottom: 1px solid #444;
        }

        .total-row td {
            border-top: 1px solid #444;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .section {
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 30px;
            border-top: 1px solid #444;
            padding-top: 20px;
            font-size: 11px;
        }

        h1 {
            color: #fff;
            margin: 0 0 5px 0;
        }

        h2 {
            color: #fff;
            font-size: 16px;
            margin: 0 0 10px 0;
        }

        .highlight {
            background-color: #333;
            padding: 10px;
            border-radius: 4px;
        }

        .bill-header {
            margin-bottom: 100px !important;
        }
    </style>
</head>

<body>
    <div class="invoice">
        <!-- Header -->
        <table class="header">
            <tr>
                <td width="50%">
                    <h1>INVOICE</h1>
                    <div>{{ $invoice->invoice_number }}</div>
                </td>
                <td width="50%" class="text-right">
                    <h2>COMPANY NAME</h2>
                    <div>123 Business Street, City, State 12345</div>
                    <div>contact@company.com | (555) 123-4567</div>
                </td>
            </tr>
        </table>

        <!-- Client and Invoice Info -->
        <table class="section">
            <tr>
                <td width="50%" valign="top">
                    <h2 class="bill-header">BILL TO</h2>
                    <div><strong>{{ $invoice->order->customer->full_name }}</strong></div>
                    <div>456 Client Avenue, Client City, State 67890</div>
                    <div>{{ $invoice->order->customer->email }} | {{ $invoice->order->customer->phone_number }}</div>
                </td>
                <td width="50%" valign="top">
                    <h2>INVOICE DETAILS</h2>
                    <table>
                        <tr>
                            <td>Invoice Number:</td>
                            <td class="text-right">{{ $invoice->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td>Date Issued:</td>
                            <td class="text-right">{{ $invoice->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Due Date:</td>
                            <td class="text-right">After: 48 Hours</td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>

        <!-- Invoice Items -->
        <table class="items section">
            <tr>
                <th width="50%">Item</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="20%" class="text-right">Unit Price</th>
                <th width="20%" class="text-right">Amount</th>
            </tr>
            @foreach ($invoice->order->orderitems as $item)
                <tr>
                    <td>
                        <div><strong>{{ $item->product->name }}</strong></div>
                        <div style="color: #aaa; font-size: 11px;">{{ $item->product->description }}
                        </div>
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ $item->product->selling_price }}</td>
                    <td class="text-right">${{ $item->total_amount }}</td>
                </tr>
            @endforeach

        </table>

        <!-- Totals -->
        <table class="section">
            <tr>
                <td width="60%"></td>
                <td width="40%">
                    <table>
                        <tr>
                            <td>Subtotal:</td>
                            <td class="text-right">${{ $invoice->order->total_price }}</td>
                        </tr>
                        <tr>
                            <td>Tax (10%):</td>
                            <td class="text-right">$380.00</td>
                        </tr>
                        <tr class="total-row">
                            <td>Total:</td>
                            <td class="text-right highlight">${{ $invoice->order->total_price }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Notes and Payment Info -->
        <table class="section">
            <tr>
                <td width="50%" valign="top">
                    <h2>NOTES</h2>
                    <p>Thank you for your business. Please make payment by the due date. For any questions concerning
                        this invoice, please contact our accounting department.</p>
                </td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer text-center">
            This invoice was created on a computer and is valid without a signature.
        </div>
    </div>
</body>

</html>
