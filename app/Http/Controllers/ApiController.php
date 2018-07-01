<?php

namespace App\Http\Controllers;

use App\AppUser;
use App\Cafe;
use App\Order;
use App\Product;
use App\ProductOrder;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Validator;
use function floor;
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBonusById(Request $request)
    {
        $bonus = AppUser::where('api_token', '=', $request->input('token'))->first(['bonus']);
        return response()->json(['bonus' => $bonus->bonus])->header('Access-Control-Allow-Origin', '*');
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


        return response()->json($result)->header('Access-Control-Allow-Origin', '*');
    }


    /**
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function newOrder(Request $request)
    {
        echo '<pre>';
        print_r($request->input('bonus_counter'));die;
        echo '</pre>';

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
        $order->price = $request->input('order_price');
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

        if ($request->input('order_price') && $request->input('api_token')) {
            $user = AppUser::where('api_token', '=', $request->input('api_token'))->first();
            $bonus = floor($request->input('order_price')) / 10 + $user->bonus;
            $user->bonus = $bonus;
            $user->save();
        }

        return view('emails.success', [
        ]);
    }

    /**
     * @param Request $request
     * @return object
     */
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:app_users',
            'password' => 'required|min:6',
            'password_confirmation' => 'same:password',
        ];

        $messages = [
            'required' => 'Заполните все поля',
            'email.email' => 'Введите валидный почтовый адрес',
            'email.unique' => 'Почтовый адрес уже занят',
            'password.min' => 'Пароль должен быть минимум 6 символов',
            'password_confirmation.same' => 'Подтвердите пароль',
        ];

        $data = $request->data;

        $validator = Validator::make($request->data, $rules, $messages);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        $user = new AppUser();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->api_token = Hash::make($data['email']);
        $user->save();

        $response = $user->api_token;
        return response()->json($response)->header('Access-Control-Allow-Origin', '*');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->data;
        $user = AppUser::where('email', $data['email'])->first();
        $response = '';
        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                $response = $user->api_token;
            }
        }

        return response()->json($response)->header('Access-Control-Allow-Origin', '*');

    }

    /**
     * @param Request $request
     * @return AppUser|\Illuminate\Database\Eloquent\Model
     */
    public function account(Request $request)
    {
        $api_token = $request->api_token;

        $user = AppUser::where('api_token', $api_token)->firstOrFail();

        return $user;

    }

}
