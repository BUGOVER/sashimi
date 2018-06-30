<?php

namespace App\Http\Controllers;

use App\Cafe;
use App\Order;
use App\Product;
use App\ProductOrder;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function response;

/**
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller
{
    /**
     * @var
     */
    protected $productId;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request)
    {
        $category = $request->input('category');

        if (empty($category)) {
            $product = Product::all();
        } else {
            $product = Product::get()->where('category', $category);
        }

        return response()->json($product)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param $productId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductById($productId)
    {
        if (empty($productId)) {
            return response()->json(['message' => 'Not Selected product'])->header('Access-Control-Allow-Origin', '*');
        }

        $product = Product::where('id', $productId)
            ->first(['id', 'id_product', 'name', 'price', 'desc', 'category', 'img', 'weight']);

        return response()->json($product)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSettings()
    {
        $setting = Setting::all();

        $cafe = Cafe::all();

        $result = [
            'setting' => $setting,
            'cafe' => $cafe
        ];


        return response()->json($result)->header('Access-Control-Allow-Origin', '*');;
    }


    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function newOrder(Request $request)
    {
        $time = strtotime("now+4 hour");

        $order = new Order();
        $order->name = $request->input('post-name');
        $order->phone = $request->input('post-phone');
        $order->addres = $request->input('post-place');
        $order->way_delivery = $request->input('post-wayDelivery');
        $order->porch = $request->input('post-porch');
        $order->floor = $request->input('post-floor');
        $order->time_delivery = $request->input('post-timeDelivery');
        $order->hour = $request->input('post-hour');
        $order->min = $request->input('post-min');
        $order->odd_money = $request->input('odd-money') ? $request->input('odd-money') : 0;
        $order->cafe_id = $request->input('post-cafeId');
        $order->promo = $request->input('post-promo');
        $order->discount = $request->input('discount') ? $request->input('discount') : 0;
        $order->created_at = $time;
        $order->updated_at = $time;

        $products = $request->input('produts');
        $productsForEmail = [];
        $summDelivery = Setting::get()->where('name', 'summDelivery')->first()->value;
        $freeSummDelivery = Setting::get()->where('name', 'freeSummDelivery')->first()->value;
        $promo = Setting::get()->where('name', 'promoCupon')->first()->value;
        $discountPercent = Setting::get()->where('name', 'discountPercent')->first()->value;

        if ($promo !== $order->promo) {
            $discountPercent = 0;
        }

        $summ = 0;
        foreach ($products as $key => $productForEmail) {
            $id = str_replace('ID', '', $key);
            $model = Product::get()->where('id_product', $id)->first();
            $productsForEmail[$id]['name'] = $model->name;
            $productsForEmail[$id]['price'] = $model->price;
            $productsForEmail[$id]['count'] = $productForEmail;
            $summ = $summ + ($model->price * $productForEmail);
        }

        $discount = 0;
        if ($discountPercent > 0) {
            $discount = round($summ * ($discountPercent / 100));
        }

        if ($summ > $freeSummDelivery) {
            $summDelivery = 0;
        }

        $cafe = Cafe::get()->where('id', $order->cafe_id)->first();

        Mail::send('emails.order', [
            'order' => $order,
            'productsForEmail' => $productsForEmail,
            'cafe' => $cafe,
            'summ' => $summ,
            'summDelivery' => $summDelivery,
            'discount' => $discount
        ], function ($m) use ($order, $products, $cafe) {
            $m->to('1.aaaaaa@mail.ru')->subject('Новый заказ из мобильного приложения для Sashimi59');
            $m->to($cafe->email)->subject('Новый заказ из мобильного приложения для Sashini59');
            $order->save();

            foreach ($products as $key => $product) {
                $id = str_replace('ID', '', $key);
                $productsOrder = new ProductOrder();
                $productsOrder->order_id = $order->id;
                $productsOrder->product_id = $id;
                $productsOrder->count = $product;
                $productsOrder->save();
            }
        });
        return view('emails.success', [
        ]);
    }

}
