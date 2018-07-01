<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

require __DIR__ . './../app/Helpers/helpers.php';

use Illuminate\Http\Request;

const TC = 'wx22331233';

$app->get('/login', function (Request $request) use ($app) {

    return view('login', [
        'request' => $request
    ]);
});

$app->post('/login', function (Request $request) use ($app) {
    if ($request->input('username') === 'Admin' && $request->input('password') === 'wx22331233') {
        setcookie("TestCookie", 'wx22331233');
        return redirect('/');
    } else {
        return redirect('login');
    }

});


$app->get('/', function (Request $request) use ($app) {
    if ($request->cookie('TestCookie') == TC) {

        $settings = \App\Setting::get();
        $minSummDelivery = null;
        $freeSummDelivery = null;
        $summDelivery = null;
        $promoCupon = null;
        $discountPercent = null;
        foreach ($settings as $setting) {
            if ($setting->name == 'minSummDelivery') {
                $minSummDelivery = $setting->value;
            }
            if ($setting->name == 'freeSummDelivery') {
                $freeSummDelivery = $setting->value;
            }
            if ($setting->name == 'promoCupon') {
                $promoCupon = $setting->value;
            }
            if ($setting->name == 'summDelivery') {
                $summDelivery = $setting->value;
            }
            if ($setting->name == 'discountPercent') {
                $discountPercent = $setting->value;
            }
        }
        return view('setting.index', [
            'minSummDelivery' => $minSummDelivery,
            'freeSummDelivery' => $freeSummDelivery,
            'promoCupon' => $promoCupon,
            'summDelivery' => $summDelivery,
            'discountPercent' => $discountPercent,
            'request' => $request
        ]);
    } else {
        return redirect('login');
    }

});

$app->post('/', function (Request $request) use ($app) {
    if ($request->cookie('TestCookie') == TC) {


        if ($settings = \App\Setting::where(['name' => 'minSummDelivery'])->first()) {
            $settings->name = 'minSummDelivery';
            $settings->value = $request->input('minSummDelivery');
            $settings->save();
        } else {
            $settings = new \App\Setting();
            $settings->name = 'minSummDelivery';
            $settings->value = $request->input('minSummDelivery');
            $settings->save();
        }


        if ($settings = \App\Setting::where(['name' => 'freeSummDelivery'])->first()) {
            $settings->name = 'freeSummDelivery';
            $settings->value = $request->input('freeSummDelivery');
            $settings->save();
        } else {
            $settings = new \App\Setting();
            $settings->name = 'freeSummDelivery';
            $settings->value = $request->input('freeSummDelivery');
            $settings->save();
        }


        if ($settings = \App\Setting::where(['name' => 'summDelivery'])->first()) {
            $settings->name = 'summDelivery';
            $settings->value = $request->input('summDelivery');
            $settings->save();
        } else {
            $settings = new \App\Setting();
            $settings->name = 'summDelivery';
            $settings->value = $request->input('summDelivery');
            $settings->save();
        }


        if ($settings = \App\Setting::where(['name' => 'promoCupon'])->first()) {
            $settings->name = 'promoCupon';
            $settings->value = $request->input('promoCupon');
            $settings->save();
        } else {
            $settings = new \App\Setting();
            $settings->name = 'promoCupon';
            $settings->value = $request->input('promoCupon');
            $settings->save();
        }


        if ($settings = \App\Setting::where(['name' => 'discountPercent'])->first()) {
            $settings->name = 'discountPercent';
            $settings->value = $request->input('discountPercent');
            $settings->save();
        } else {
            $settings = new \App\Setting();
            $settings->name = 'discountPercent';
            $settings->value = $request->input('discountPercent');
            $settings->save();
        }

        return redirect('/');

    } else {
        return redirect('login');
    }
//    $settings = \App\Product::get();


});

$app->get('/product', function (Request $request) use ($app) {
    if ($request->cookie('TestCookie') == TC) {
        $products = \App\Product::get();
        return view('product.index', [
            'products' => $products,
            'request' => $request
        ]);
    } else {
        return redirect('login');
    }
});

$app->get('/product/edit/{id}', function (Request $request, $id) use ($app) {
    $product = \App\Product::find($id);
    return view('product.edit', [
        'product' => $product,
        'request' => $request
    ]);
});

$app->get('/product/delete/{id}', function (Request $request, $id) use ($app) {
    $product = \App\Product::find($id);
    $product->delete();
    return redirect('product');
});

$app->post('/order/edit/{id}', function (Request $request, $id) use ($app) {
    $product = \App\Order::find($id);
    $product->name = $request->input('name');
    $product->desc = $request->input('desc');
    $product->price = $request->input('price');
    $product->img = $request->input('img');
    $product->category = $request->input('category');
    $product->save();

    return redirect('product');
});

$app->get('/order/edit/{id}', function (Request $request, $id) use ($app) {
    $product = \App\Order::find($id);
    return view('product.edit', [
        'product' => $product,
        'request' => $request
    ]);
});

$app->get('/order/delete/{id}', function (Request $request, $id) use ($app) {
    $product = \App\Order::find($id);
    $product->delete();
    return redirect('product');
});

$app->post('/product/edit/{id}', function (Request $request, $id) use ($app) {

    $img = image_uploader($request->file(), $request->input('name'), $request->input('category'));

    $product = \App\Product::find($id);
    $product->name = $request->input('name');
    $product->desc = $request->input('desc');
    $product->price = $request->input('price');
    $product->img = $img;
    $product->category = $request->input('category');
    $product->save();

    return redirect('product');
});


$app->get('/order', function (Request $request) use ($app) {
    if ($request->cookie('TestCookie') == TC) {
        $orders = \App\Order::get()->sortByDesc('created_at');
        return view('order.index', [
            'orders' => $orders,
            'request' => $request
        ]);
    } else {
        return redirect('login');
    }
});

$app->post('/order/{id}', function (Request $request) use ($app) {
    $product = \App\Order::get();
    $product->name = '';
    $product->desc = '';
    $product->price = '';
    $product->img = '';
    $product->category = '';
    $product->save();

    return redirect('order');
});

$app->get('/cafe/delete/{id}', function (Request $request, $id) use ($app) {
    $cafe = \App\Cafe::find($id);
    $cafe->delete();
    return redirect('cafe');
});

$app->get('/cafe', function (Request $request) use ($app) {
    if ($request->cookie('TestCookie') == TC) {
        $cafes = \App\Cafe::get();
        return view('cafe.index', [
            'cafes' => $cafes,
            'key' => 0,
            'request' => $request
        ]);
    } else {
        return redirect('login');
    }
});

$app->post('/cafe', function (Request $request) use ($app) {
    DB::table('cafe')->delete();
    $cafes = $request->input('cafe.*');
    if (empty($cafes)) {
        return redirect('cafe');
    }
    foreach ($cafes as $cafe) {
        if ($cafe['name'] !== 0
            && $cafe['number'] !== 0
            && $cafe['email'] !== 0
        ) {
            $model = new \App\Cafe();
            $model->name = $cafe['name'];
            $model->email = $cafe['email'];
            $model->number = $cafe['number'];
            if (!empty($cafe['sms'])) {
                $model->sms = 1;
            } else {
                $model->sms = 0;
            }
            $model->save();
        }
    }

    return redirect('cafe');
});

$app->post('/product/csv', function (Request $request) use ($app) {
    if ($request->cookie('TestCookie') == TC) {
        if ($request->hasFile('csv')) {
            $request->file('csv')->move($app->basePath() . '/upload', 'csv.csv');
        }
        DB::table('product')->delete();
        setlocale(LC_ALL, 'ru_RU.UTF-8');
        $f = file_get_contents($app->basePath() . '/upload/csv.csv');
        $arrRows = str_getcsv($f, ';');
        $arrRows = explode("\r", $f);
        unset($arrRows[0]);
        array_pop($arrRows);
        foreach ($arrRows as $arrRow) {
            $product = new \App\Product();
            $row = explode(';', $arrRow);
            $product->id_product = trim($row[0]);

            $product->name = iconv("windows-1251", "UTF-8", $row[1]);
            $product->desc = iconv("windows-1251", "UTF-8", $row[3]);
            $product->img = iconv("windows-1251", "UTF-8", $row[4]);
            $product->category = iconv("windows-1251", "UTF-8", $row[5]);
            $product->weight = $row[6];
            $product->price = $row[2];
            $product->save();
        }
        return redirect('product');
    } else {
        return redirect('login');
    }
});

/**
 * @param array $data
 * @param $name
 * @param $category
 * @return string
 */
function image_uploader(array $data, $name, $category)
{
    if (!empty($data['img'])) {
        $file = $data['img'];
        $imgExt = $file->getClientOriginalExtension();

        $img = productCategory($category) . DS . translatable(str_replace(' ', '_', $name)) . '.' . $imgExt;

        $file->move(public_path('img/img_menu/' . productCategory($category)),
            translatable(str_replace(' ', '_', $name)) . '.' . $imgExt);

        return 'img' . DS . 'img_menu' . DS . $img;
    }

    return false;
}


$app->group(['prefix' => 'api/v1'], function ($app) {
    $app->get('products', 'ApiController@getProducts');
    $app->get('product/{id}', 'ApiController@getProductById');
    $app->get('settings', 'ApiController@getSettings');
    $app->get('cafe', 'ApiController@getCafe');
    $app->post('new', 'ApiController@newOrder');

    $app->post('get_bonus', 'ApiController@getBonusById');

    $app->post('register', 'ApiController@register');
    $app->post('login', 'ApiController@login');
    $app->post('account', 'ApiController@account');
});
