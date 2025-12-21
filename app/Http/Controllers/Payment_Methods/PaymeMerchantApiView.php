<?php

namespace App\Http\Controllers\Payment_Methods;

use App\Models\Cart;
use App\Models\PaymentRequest;
use Illuminate\Support\Facades\Log;
use JscorpTech\Payme\Enums\ErrorEnum;
use JscorpTech\Payme\Exceptions\PaymeException;
use JscorpTech\Payme\Views\PaymeApiView;


class PaymeMerchantApiView extends PaymeApiView
{
    public function CheckPerformTransaction()
    {
        $this->merchant->validateParams($this->request_id, $this->params);
        $order = $this->order::query()->where(['id' => $this->params['account'][$this->field]]);
        if (!$order->exists() or $order->first()->state) {
            throw new PaymeException($this->request_id, "Order not found", ErrorEnum::INVALID_ACCOUNT);
        }
        $payment_request = PaymentRequest::query()->where(['order_id' => $order->first()->id]);
        if (!$payment_request->exists()) {
            return [
                "allow" => false,
            ];
        }
        $payment_request = $payment_request->first();
        $data = json_decode($payment_request->additional_data);
        $carts = Cart::where(['customer_id' => $data->customer_id, 'is_checked' => 1])->get();
        $items = [];
        $vat_percent = 0;
        $commission_total = 0;
        $commission_percent = getWebConfig("sales_commission") ?? 0;
        foreach ($carts as $cart) {
            $product = $cart->product;
            $vat_percent = $product->seller->vat_percent;
            $price = (int)currencyConverter($cart->price, "uzs") * 100;
            $comission = (int) ceil($price * $commission_percent / 100);
            $commission_total += $comission;
            $items[] = array_merge([
                "title"         => $cart->name,
                "price"         => $price - $comission,
                "count"         => $cart->quantity,
                "code"          => $product->mxik,
                "package_code"  => (string) $product->package_code,
                "vat_percent"   => (int) $vat_percent,
            ], $product->seller->inn ? [
                "commission_info" => [
                    "tin" => (string) $product->seller->inn,
                ],
            ] : []);
        }
        $items[] = [
            "title" => "Комисионные услуги и услуги комиссионеров, роялти (в т.ч. комисионное вознаграждение и роялти), кроме процентных доходов",
            "price" => $commission_total,
            "count" => 1,
            "code" => (string) "10406003001000000",
            "package_code" => (string) "1508544",
            "vat_percent" => (int) $vat_percent,
            "comission_info" => [
                "tin" => (string) "303917761", #INFO: Hozirda sotuvchi inn si turibdi commissiya uchun venu soliq to'lashi kerak o'zgartiriladi!!!
            ]
        ];
        $items[] = [
            "title" => "yetkazib berish",
            "price" => $payment_request->delivery_price * 100,
            "count" => 1,
            "code" => (string) "10107002001000000",
            "package_code" => (string) "1209885",
            "vat_percent" => (int) $vat_percent,
            "comission_info" => [
                "tin" => (string) "303917761", #INFO: Hozirda sotuvchi inn si turibdi commissiya uchun venu soliq to'lashi kerak o'zgartiriladi!!!
            ]
        ];
        return $this->success(["allow" => true, "detail" => [
            "receipt_type" => 0,
            "items" => $items,
        ]]);
    }
}
