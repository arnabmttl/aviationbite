<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>

    <style type="text/css">
        table {
            width: 100%;
            text-align: center;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td>
                    <p>Office Address of the Aviation Bites</p>
                    <p>North West Delhi, Delhi, India</p>
                    <p>+91 99999 99999, +9111 2748 7432</p>
                </td>
                <td>
                    <h4>
                        Invoice
                        <span>#{{ $invoice->invoiceNumber }}</span>
                    </h4>
                    <p>Invoice Date:</p>
                    <p>{{ $invoice->created_at->format('d/m/Y') }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <h6>Invoice To:</h6>
                    <h6>{{ $invoice->user_details['name'] }}</h6>
                    <p>{{ $invoice->user_details['email'] }}</p>
                    <p>{{ $invoice->user_details['phone_number'] }}</p>
                </td>
                <td>
                    <h6>Status:</h6>
                    <h6>
                        @switch($invoice->order_details['payment_status'])
                            @case('Pending')
                                <div>
                                    {{ $invoice->order_details['payment_status'] }}
                                </div>
                            @break
                            @case('Completed')
                                <div>
                                    {{ $invoice->order_details['payment_status'] }}
                                </div>
                            @break
                            @case('Failed')
                                <div>
                                    {{ $invoice->order_details['payment_status'] }}
                                </div>
                            @break
                            @default
                                Some problem occured please try again.
                        @endswitch
                    </h6>
                </td>
            </tr>
        </thead>
    </table>

    <table>
        <th>
            <tr>
                <th>#</th>
                <th>Name & Description</th>
                <th>Price</th>
                <th>Special Price</th>
            </tr>
        </th>
        <tbody>
        @foreach($invoice->order_item_details as $index => $orderItem)
            <tr>
                <td>
                    {{ $index+1 }}
                </td>
                <td>
                    <p>{{ $orderItem['course_details']['name'] }}</p>
                    <p>Validity : {{ $orderItem['course_details']['valid_for'] }} days</p>
                </td>
                <td>
                    <span>Rs. {{ $orderItem['course_details']['price'] }}</span>
                </td>
                <td>
                    <span>Rs. {{ $orderItem['course_details']['special_price'] }}</span>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <table style="text-align: right;">
        <tbody>
            <tr>
                <td>
                    <p>Subtotal: Rs. {{ $invoice->order_details['amount'] }}</p>
                </td>
            </tr>
        @if ($invoice->order_details['discount_amount'])
            <tr>
                <td>
                    <p>Discount: - Rs. {{ $invoice->order_details['discount_amount'] }}</p>
                </td>
            </tr>
        @endif
            <tr>
                <td>
                    <p>Tax ({{ $invoice->order_details['tax_percentage'] }}%): Rs. {{ $invoice->order_details['tax_amount'] }}</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Total: Rs. {{ $invoice->total_amount }}</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>