<?php
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Spatie\Permission\Models\Permission;
use PhpOffice\PhpSpreadsheet\Writer\Html;
use App\Http\Controllers\ProfileController;
use App\Notifications\SendMailNotification;
use App\Http\Controllers\ArticaleController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\Admin\CartController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\dasboardController;
use App\Http\Controllers\Admin\CurrencyConverterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Stripe\StripeClient;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

// Home route
Route::get('/home', function () {
    return view('home');
})->middleware(['auth', 'verified', CheckType::class]);

// Admin routes
Route::prefix('')->group(function(){
    // Category routes
    Route::get('category', [CategoryController::class,'index'])->middleware('auth');
    Route::get('category/create', [CategoryController::class,'create']);
    Route::post('category', [CategoryController::class,'store'])->name('category.store');
    Route::get('category/{id}/edit', [CategoryController::class,'edit'])->name('category.edit');
    Route::delete('category/{id}/destroy', [CategoryController::class,'destroy'])->name('category.destroy');
    Route::get('category/{id}/show', [CategoryController::class,'show'])->name('category.show');
    Route::post('category/{id}/update', [CategoryController::class,'update'])->name('category.update');
    Route::delete('/delete/{imageId}', [CategoryController::class,'delete']);
    Route::delete('/delete/product/{imageId}', [ProductController::class,'deleteproduct']);

    // Product routes
    Route::resources([
        'product' => ProductController::class,
    ]);
});

// Cart routes
Route::get('homebasic', [CartController::class,'home'])->name('homebasic');
Route::post('addCart/{product_id}/cart', [CartController::class,'addtocart2'])->name('addCart');
Route::get('my_cart', [CartController::class,'my_cart'])->name('my_cart');
Route::post('updateQuantity', [CartController::class,'updateQuantity']);

// Order routes
Route::get('order', [OrderController::class,'index']);
Route::post('order', [OrderController::class,'store'])->name('order');
Route::post('fetch-cities', [OrderController::class,'getcities'])->name('cities');
Route::get('/dashboard',[dasboardController::class,'index'])->name('dashboard')
->middleware('admin');
Route::get('admin-login', [dasboardController::class, 'login'])
->name('admin.login');
Route::post('admin-login', [dasboardController::class, 'loginstore'])->name('admin.login_post');
Route::get('admin-logout', [dasboardController::class, 'logout'])
->name('Admin-logout')->middleware('admin');
Route::get('admin-register', [dasboardController::class, 'register'])
;
Route::post('admin-register', [dasboardController::class, 'registerstore'])
->name('admin.register');
Route::get('/treatment', function () {
    return view('samaratreatmentplan');
});

route::get('/trash',[CategoryController::class,'trash']);
Route::delete('category/{id}/forcedelete', [CategoryController::class,'forcedelete'])->name('category.forcedelete');

Route::post('trash/{id}/restore',[CategoryController::class,'restorecat'])->name('category.restore');

Route::get('/send-mail', function () {
    // $user = User::first();
    // $user->notify(new SendMailNotification);

    $users = User::get();
  
    Notification::send($users, new SendMailNotification);
    return 'done';
});
// Route::post('currency',[CurrencyConverterController::class,'storewe'])->name('currency.store');
Route::post('/currency',[CurrencyConverterController::class,'storewe'])->name('currency.store');


Route::get('all-notifications', function(){
    $user =Auth::user();
   // $notifications = $user->unreadNotifications()->latest()->get();

    foreach ($user->unreadNotifications as $notification) {
        $notification->markAsRead();
    }

    return 'done';

    
   // return view('notifications', compact('notifications'));
})->middleware('auth');
Route::get('/roles',function(){
    //  $role1 = Role::create(['name' => 'driver']);
    //  $role2 = Role::create(['name' => 'admin']);

    //  $permissionindex= Permission::create(['name' => 'index articles']);
    // $permissioncreate= Permission::create(['name' => 'create articles']);
    // $permissionedit = Permission::create(['name' => 'edit articles']);
    //  $role1->givePermissionTo($permissioncreate);
    //  $premission=Permission::pluck('id')->ToArray();
    //   $role2->syncPermissions( $premission);
    //  $user=User::where('id',1)->first();
    //  $user->assignRole('admin');
    //  $user1=User::where('id',5)->first();
    //  $user1->hasPermissionTo('index articles');
    // $role= Role::where('id',7)->first();
    // $permission=Permission::where('name','create articles')->first();
    //  $role->givePermissionTo($permission);
    $user=User::where('id',5)->first();
     $user->assignRole('driver');
    
    return 'done';
});
Route::group(['middleware' => ['permission:create articles']], function () {
    Route::get('permission',function(){
 return 'done';
    });
});
route::get('/articles',[ArticaleController::class,'index']);
route::get('/articles/edit',[ArticaleController::class,'edit']);
route::get('/articles/create',[ArticaleController::class,'create']);
// route::post('/create-checkout-session',[PaymentController::class,'checkout'])->name('checkout');


// Route::get('stripe', [StripeController::class, 'stripe']);
// Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
Route::get('orders/{order}/pay', [PaymentController::class,'create'])->name('orders.payments.create');
Route::post('orders/{order}/stripe/payment-intent', [PaymentController::class,'createStripePaymentIntent'])->name('stripe.paymentIntent.create');
Route::get('orders/{order}/pay/stripe/callback', [PaymentController::class,'confirm'])->name('stripe.return');

// Route::get('test', function(Request $request){
//     $stripe = new StripeClient(config('services.stripe.secret_key'));

//     // Get the authenticated user
//     $user = auth()->user();

//     // Create the SetupIntent using the Stripe client
//     $setupIntent = $stripe->setupIntents->create([
//         'customer' => $user->stripe_customer_id, // Assuming you have a stripe_customer_id column in your users table to store the Stripe Customer ID
//     ]);
//     $request->user()->createSetupIntent()->client_secret

//     $user = auth()->user();
//     dd($request->user()->createSetupIntent()->client_secret);
// });