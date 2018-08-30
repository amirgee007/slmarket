<?php

namespace Responsive\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

use File;
use Image;
use Responsive\UserEarning;
use URL;
use Mail;
use Carbon\Carbon;


class SuccessController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function avigher_shop_success($cid)
    {

        $orderupdate = DB::table('product_orders')
            ->where('purchase_token', '=', $cid)
            ->where('status', '=', 'pending')
            ->update(['status' => 'completed']);

        $checkoutupdate = DB::table('product_checkout')
            ->where('purchase_token', '=', $cid)
            ->where('payment_status', '=', 'pending')
            ->update(['payment_status' => 'completed']);


        $get_viewr = DB::table('product_orders')
            ->where('purchase_token', '=', $cid)
            ->where('status', '=', 'completed')
            ->count();


        $view_orders = DB::table('product_orders')
            ->where('purchase_token', '=', $cid)
            ->where('status', '=', 'completed')
            ->get();

        foreach ($view_orders as $views) {

            $ord_id = $views->ord_id;

            $subtotal = $views->quantity * $views->price;

            $total = $subtotal + $views->shipping_price;


            DB::update('update product_orders set subtotal="' . $subtotal . '",total="' . $total . '" where status="completed" and ord_id = ?', [$ord_id]);


        }


        $get_details = DB::table('product_checkout')
            ->where('purchase_token', '=', $cid)
            ->get();

        $user_details = DB::table('users')
            ->where('id', '=', $get_details[0]->user_id)
            ->get();


        $order_id = $cid;

        $name = $user_details[0]->name;
        $email = $user_details[0]->email;
        $phone = $user_details[0]->phone;
        $amount = $get_details[0]->total;


        $setid = 1;
        $setts = DB::table('settings')
            ->where('id', '=', $setid)
            ->get();

        $url = URL::to("/");

        $site_logo = $url . '/local/images/media/' . $setts[0]->site_logo;

        $site_name = $setts[0]->site_name;


        $aid = 1;
        $admindetails = DB::table('users')
            ->where('id', '=', $aid)
            ->first();

        $admin_email = $admindetails->email;


        $datas = [
            'site_logo' => $site_logo, 'site_name' => $site_name, 'name' => $name, 'email' => $email, 'phone' => $phone, 'amount' => $amount, 'url' => $url, 'order_id' => $order_id
        ];

        Mail::send('shop_email', $datas, function ($message) use ($admin_email, $email) {
            $message->subject('Payment Received');

            $message->from($admin_email, 'Admin');

            $message->to($admin_email);

        });


        Mail::send('shop_email', $datas, function ($message) use ($admin_email, $email) {
            $message->subject('Payment Received');

            $message->from($admin_email, 'Admin');

            $message->to($email);

        });

        $this->orders_approval($cid);

        $data = array('cid' => $cid);
        return view('shop_success')->with($data);


    }


    public function orders_approval($purchase_token)
    {
        $cid =  $purchase_token;

        $setts = DB::table('settings')
            ->where('id', '=', 1)
            ->get();

        $commission_mode = $setts[0]->commission_mode;
        $commission_amt = $setts[0]->commission_amt;

        $product = DB::table('product_checkout')
            ->where('purchase_token', '=', $cid)
            ->first();

        $vendor_amt = $product->shipping_price + $product->subtotal;

        if($commission_mode=="percentage")
        {
            $commission_amount = ($commission_amt * $vendor_amt) / 100;
        }
        if($commission_mode=="fixed")
        {
            if($product->total < $commission_amt)
            {
                $commission_amount = 0;
            }
            else
            {
                $commission_amount = $commission_amt;
            }
        }

        $vendor_commission = $vendor_amt - $commission_amount;

        $admin_commission = $product->processing_fee + $commission_amount;


        $product_count = DB::table('product_checkout')
            ->where('purchase_token', '=', $purchase_token)
            ->where('payment_approval', '=', 0)
            ->count();

        $set_id = 1;

        $site_setting = DB::table('settings')->where('id', $set_id)->get();


        if (!empty($product_count)) {
            $product = DB::table('product_checkout')
                ->where('purchase_token', '=', $purchase_token)
                ->get();


            $view_orders = DB::table('product_orders')
                ->where('purchase_token', '=', $purchase_token)
                ->where('status', '=', 'completed')
                ->get();


            $admin_final_amount = 0;
            foreach ($view_orders as $views) {

                $prod_user_id = $views->prod_user_id;
                $vendor_amount = $views->total;

                $commission_amt = $site_setting[0]->commission_amt;
                $commission_mode = $site_setting[0]->commission_mode;


                if ($commission_mode == "percentage") {
                    $commission_amount = ($commission_amt * $vendor_amount) / 100;
                }
                if ($commission_mode == "fixed") {
                    if ($views->total < $commission_amt) {
                        $commission_amount = 0;
                    } else {
                        $commission_amount = $commission_amt;
                    }
                }

                $vendor_final_amt = $vendor_amount - $commission_amount;
                $admin_final_amount += $commission_amount;


                $user_check = DB::table('users')
                    ->where('id', '=', $prod_user_id)
                    ->get();

                $wallet_balance = $user_check[0]->earning;

                $credit_amt = $wallet_balance + $vendor_final_amt;


                UserEarning::firstOrCreate([
                    'user_id' => $user_check[0]->id,
                    'product_order_id' => $views->ord_id,
                    'cleared_at' => Carbon::now()->addDay(config('app.after_days_funds_clear')),
                    'total' => $vendor_final_amt,
                ]);

            }


            $admin_check = DB::table('users')
                ->where('id', '=', 1)
                ->get();
            $admin_wallet = $admin_check[0]->earning;
            $admin_amount = $admin_final_amount + $product[0]->processing_fee;

            $admin_credit = $admin_wallet + $admin_amount;

            DB::update('update users set earning="' . $admin_credit . '" where id = ?', [1]);


            $user = DB::table('users')
                ->where('id', '=', $product[0]->user_id)
                ->get();


            $user_email = $user[0]->email;
            $shipping_charge = $product[0]->shipping_price;
            $processing_fee = $product[0]->processing_fee;
            $subtotal = $product[0]->subtotal;
            $total = $product[0]->total;
            $payment_type = $product[0]->payment_type;
            $payment_date = $product[0]->payment_date;


            $setid = 1;
            $setts = DB::table('settings')
                ->where('id', '=', $setid)
                ->get();

            $currency = $setts[0]->site_currency;

            $url = URL::to("/");

            $site_logo = $url . '/local/images/media/' . $setts[0]->site_logo;

            $site_name = $setts[0]->site_name;


            $aid = 1;
            $admindetails = DB::table('users')
                ->where('id', '=', $aid)
                ->first();

            $admin_email = $admindetails->email;

            DB::update('update product_checkout set payment_approval="1",vendor_amount="' . $vendor_commission . '",admin_amount="' . $admin_commission . '" where purchase_token = ?', [$purchase_token]);


            $datas = [
                'user_email' => $user_email, 'url' => $url, 'purchase_token' => $purchase_token, 'vendor_commission' => $vendor_commission, 'admin_commission' => $admin_commission, 'total' => $total, 'payment_type' => $payment_type, 'payment_date' => $payment_date, 'site_logo' => $site_logo, 'site_name' => $site_name, 'currency' => $currency
            ];

//            Mail::send('admin.order_approval_mail', $datas, function ($message) use ($admin_email, $user_email) {
//                $message->subject('Your payment is approved');
//
//                $message->from($admin_email, 'Admin');
//
//                $message->to($user_email);
//
//            });


        }


        return true;

    }


    public function paypal_success($cid)
    {


        $booking = DB::table('booking')
            ->where('book_id', '=', $cid)
            ->get();


        $setid = 1;
        $setts = DB::table('settings')
            ->where('id', '=', $setid)
            ->get();


        $bookingupdate = DB::table('booking')
            ->where('book_id', '=', $cid)
            ->update(['payment_status' => 'paid']);


        $ser_id = $booking[0]->services_id;
        $sel = explode(",", $ser_id);
        $lev = count($sel);
        $ser_name = "";
        $sum = "";
        $price = "";
        for ($i = 0; $i < $lev; $i++) {
            $id = $sel[$i];


            $fet1 = DB::table('subservices')
                ->where('subid', '=', $id)
                ->get();
            $ser_name .= $fet1[0]->subname . '<br>';
            $ser_name .= ",";


            $ser_name = trim($ser_name, ",");

        }

        $booking_time = $booking[0]->book_time;
        if ($booking_time > 12) {
            $final_time = $booking_time - 12;
            $final_time = $final_time . "PM";
        } else {
            $final_time = $booking_time . "AM";
        }


        $booking_id = $booking[0]->book_id;
        $booking_date = $booking[0]->book_date;
        $total_amt = $booking[0]->total_amount;
        $currency = $setts[0]->site_currency;


        $url = URL::to("/");

        $site_logo = $url . '/local/images/media/' . $setts[0]->site_logo;

        $site_name = $setts[0]->site_name;

        $aid = 1;
        $admindetails = DB::table('users')
            ->where('id', '=', $aid)
            ->first();

        $admin_email = $admindetails->email;
        $user_email = $booking[0]->book_email;

        $viewuser = DB::table('users')
            ->where('email', '=', $user_email)
            ->get();

        $shopid = $booking[0]->shop_id;

        $shopdetails = DB::table('shop')
            ->where('shop_id', '=', $shopid)
            ->get();

        $seller_email = $shopdetails[0]->email;

        $usernamer = $viewuser[0]->name;
        $userphone = $viewuser[0]->phone;


        $data = [
            'booking_id' => $booking_id, 'ser_name' => $ser_name, 'booking_date' => $booking_date, 'final_time' => $final_time, 'total_amt' => $total_amt,
            'currency' => $currency, 'site_logo' => $site_logo, 'site_name' => $site_name, 'user_email' => $user_email, 'usernamer' => $usernamer, 'userphone' => $userphone
        ];


        Mail::send('payment_usermail', $data, function ($message) use ($admin_email, $user_email) {
            $message->subject('Payment Details');

            $message->from($admin_email, 'Admin');

            $message->to($user_email);

        });


        Mail::send('payment_adminmail', $data, function ($message) use ($admin_email) {
            $message->subject('New Payment Received');

            $message->from($admin_email, 'Admin');

            $message->to($admin_email);

        });


        Mail::send('payment_sellermail', $data, function ($message) use ($admin_email, $seller_email) {
            $message->subject('New Payment Received');

            $message->from($admin_email, 'Admin');

            $message->to($seller_email);

        });

        $this->orders_approval($cid);

        $data = array('cid' => $cid);
        return view('success')->with($data);

    }


}
