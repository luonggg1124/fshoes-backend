<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Invoice: #{{ $order->id }}</title>


    <!-- Invoice styling -->
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: center;
            color: #777;
        }

        body h1 {
            font-weight: 300;
            margin-bottom: 0px;
            padding-bottom: 0px;
            color: #000;
        }

        body h3 {
            font-weight: 300;
            margin-top: 10px;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }

        body a {
            color: #06f;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="https://res.cloudinary.com/dnchsftqy/image/upload/v1736826318/assets/skpwokfubxi2mzydsf1y.png"
                                    alt="Fshoes logo" style="width: 100%; max-width: 300px" />
                            </td>

                            <td>
                                {{ __('messages.mail.order-success.invoice') }} #: {{ $order->id }}<br />
                                {{ __('messages.mail.order-success.created') }}:
                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}<br />
                                {{ __('messages.mail.order-success.status') }}:
                                @switch($order->status)
                                    @case(0)
                                        {{ __('messages.mail.order-success.status_order.cancelled') }}
                                    @break

                                    @case(1)
                                        {{ __('messages.mail.order-success.status_order.waiting_payment') }}
                                    @break

                                    @case(2)
                                        {{ __('messages.mail.order-success.status_order.waiting_confirm') }}
                                    @break

                                    @case(3)
                                        {{ __('messages.mail.order-success.status_order.confirmed') }}
                                    @break

                                    @case(4)
                                        {{ __('messages.mail.order-success.status_order.delivering') }}
                                    @break

                                    @case(5)
                                        {{ __('messages.mail.order-success.status_order.delivered') }}
                                    @break

                                    @case(6)
                                        {{ __('messages.mail.order-success.status_order.waiting_accept_return') }}
                                    @break

                                    @case(7)
                                        {{ __('messages.mail.order-success.status_order.return_processing') }}
                                    @break

                                    @case(8)
                                        {{ __('messages.mail.order-success.status_order.denied_return') }}
                                    @break

                                    @case(9)
                                        {{ __('messages.mail.order-success.status_order.returned') }}
                                    @break
                                @endswitch
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                {{ $order->address }} <br>
                                {{ $order->city }} <br>
                                {{ $order->country }}
                            </td>

                            <td>
                                {{ $order->receiver_full_name }}.<br />
                                {{ $order->phone }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>{{ __('messages.mail.order-success.payment_method_title') }}</td>

                <td># @switch($order->payment_method)
                        @case (strtolower($order->payment_method) == 'banking')
                            {{ __('messages.mail.order-success.payment_method.banking') }}
                        @break

                        @case (strtolower($order->payment_method) == 'momo')
                            {{ __('messages.mail.order-success.payment_method.momo') }}
                        @break

                        @case (strtolower($order->payment_method) == 'vnpay')
                            {{ __('messages.mail.order-success.payment_method.vnpay') }}
                        @break

                        @case (strtolower($order->payment_method) == 'cash_on_delivery')
                            {{ __('messages.mail.order-success.payment_method.cash_on_delivery') }}
                        @break
                    @endswitch
                </td>
            </tr>
            <tr class="heading">
                <td>{{ __('messages.mail.order-success.status') }}</td>

                <td style="">
                    @switch($order->status)
                        @case(0)
                            {{ __('messages.mail.order-success.status_order.cancelled') }}
                        @break

                        @case(1)
                            {{ __('messages.mail.order-success.status_order.waiting_payment') }}
                        @break

                        @case(2)
                            {{ __('messages.mail.order-success.status_order.waiting_confirm') }}
                        @break

                        @case(3)
                            {{ __('messages.mail.order-success.status_order.confirmed') }}
                        @break

                        @case(4)
                            {{ __('messages.mail.order-success.status_order.delivering') }}
                        @break

                        @case(5)
                            {{ __('messages.mail.order-success.status_order.delivered') }}
                        @break

                        @case(6)
                            {{ __('messages.mail.order-success.status_order.waiting_accept_return') }}
                        @break

                        @case(7)
                            {{ __('messages.mail.order-success.status_order.return_processing') }}
                        @break

                        @case(8)
                            {{ __('messages.mail.order-success.status_order.denied_return') }}
                        @break

                        @case(9)
                            {{ __('messages.mail.order-success.status_order.returned') }}
                        @break
                    @endswitch
                </td>
            </tr>
            <tr class="heading">
                <td>{{ __('messages.mail.order-success.item_text') }}</td>

                <td>{{ __('messages.mail.order-success.price_text') }}</td>
            </tr>
            <?php $sum = 0; ?>
            @if ($order->orderDetails)

                @foreach ($order->orderDetails as $item)
                    :
                    <tr class="item">
                        <td>{{ $item->product_id ? $item->product->name : $item->variation->name }}
                            (x{{ $item->quantity }})
                        </td>
                        <?php $sum += $item->price; ?>
                        <td> {{ number_format($item->price, 0, '.', ',') }} VND</td>
                    </tr>
                @endforeach
            @endif

            <tr class="total">
                <td></td>
                <td>
                    <div class="label-value" style="display: flex; justify-content: space-around">
                        <span class="label"
                            style="text-align: left">{{ __('messages.mail.order-success.subtotal_text') }}:</span>
                        <span class="value">{{ number_format($sum, 0, '.', ',') }} VND</span>
                    </div>
                    <div class="label-value" style="display: flex; justify-content: space-between">
                        <span class="label"
                            style="text-align: left">{{ __('messages.mail.order-success.delivery_fee') }}:</span>
                        <span class="value">+{{ number_format($order->shipping_cost, 0, '.', ',') }} VND</span>
                    </div>
                    @if ($order->voucher_id)
                        <div class="label-value" style="display: flex; justify-content: space-between">
                            <span class="label" style="margin-right: 10px">Voucher:</span>
                            <span
                                class="value">-{{ number_format((($sum + $order->shipping_cost) * $voucher->discount) / 100, 2, '.', ',') }}
                                VND</span>
                        </div>
                    @endif
                    <div class="label-value" style="display: flex; justify-content: space-between">
                        <span class="label"
                            style="margin-right: 10px">{{ __('messages.mail.order-success.total_text') }}:</span>
                        <span class="value">{{ number_format($order->total_amount, 0, '.', ',') }} VND</span>
                    </div>
                </td>
            </tr>

        </table>
    </div>
</body>

</html>
