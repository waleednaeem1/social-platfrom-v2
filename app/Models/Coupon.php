<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Cart;

class Coupon extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'coupons';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    //protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public static $types = [
        1 => 'Amount Discount',
        2 => 'Percentage Discount',
        3 => 'BOGO: Buy X Get X Free',
        4 => 'BOGO: Buy X Get % Discount on Y',
        5 => 'BOGO: Buy X Get Y Free'
    ];

    public static function getBogo($type)
    {
        $coupon = Coupon::where(['type' => $type, 'status' => 'Y'])->first();

        if($coupon)
        {
            $error = false;
            $ts_current = strtotime(date('Y-m-d'));
            if($coupon->date_from || $coupon->date_to)
            {
                if($coupon->date_from)
                {
                    $ts_from = strtotime($coupon->date_from);
                    if($ts_current < $ts_from)
                        $error = true;
                }
                if($coupon->date_to)
                {
                    $ts_to = strtotime($coupon->date_to);
                    if($ts_current > $ts_to)
                        $error = true;
                }
            }

            if(!$error)
            {
                $skus = explode(',', $coupon->buy_skus);
                $get_skus = explode(',', $coupon->get_skus);
                //$get_skus = explode(',', $coupon->get_skus);
                $items_buy = $coupon->items_buy;
                $items_get = $coupon->items_get;

                return ['skus' => $skus, 'items_buy' => $items_buy, 'items_get' => $items_get, 'get_skus' => $get_skus];
            }
        }

        return false;
    }

    public static function getFreeShipping()
    {
        $coupons = self::where(['status' => 'Y'])->get();
        $free_shipping = false;

        foreach($coupons as $coupon)
        {
            $error = false;
            $ts_current = strtotime(date('Y-m-d'));
            if($coupon->date_from || $coupon->date_to)
            {
                if($coupon->date_from)
                {
                    $ts_from = strtotime($coupon->date_from);
                    if($ts_current < $ts_from)
                        $error = true;
                }
                if($coupon->date_to)
                {
                    $ts_to = strtotime($coupon->date_to);
                    if($ts_current > $ts_to)
                        $error = true;
                }
            }

            if(!$error)
            {
                if($coupon->free_shipping == 'Y')
                {
                    $free_shipping = true;
                }
            }
        }

        return $free_shipping;
    }

    public static function getActiveCoupons()
    {
        $coupons = self::where(['showcase' => 'Y', 'status' => 'Y'])->get();

        $promos = [];

        foreach($coupons as $coupon)
        {
            $error = false;
            $ts_current = strtotime(date('Y-m-d'));
            if($coupon->date_from || $coupon->date_to)
            {
                if($coupon->date_from)
                {
                    $ts_from = strtotime($coupon->date_from);
                    if($ts_current < $ts_from)
                        $error = true;
                }
                if($coupon->date_to)
                {
                    $ts_to = strtotime($coupon->date_to);
                    if($ts_current > $ts_to)
                        $error = true;
                }
            }

            if(!$error)
            {
                $text = '';
                if($coupon->discount > 0)
                {
                    $text .= 'Get ';
                    if($coupon->type == 1)
                        $text .= '$'.$coupon->discount;
                    else
                        $text .= $coupon->discount.'%';
                    $text .= ' Additional Discount';
                }
                if($coupon->free_shipping == 'Y')
                {
                    if($coupon->discount > 0)
                        $text .= ' with ';
                    else
                        $text .= 'Get ';

                    $text .= ' Free Shipping!';
                }
                else
                    $text .= '!';

                $promo['id'] = $coupon->id;
                $promo['text'] = $text;
                $promo['code'] = $coupon->coupon;
                $promo['image'] = $coupon->image;

                array_push($promos, $promo);
            }
        }

        return $promos;
    }

    public static function IsActiveCoupon($filter)
    {
        $filter['status'] = 'Y';
        $coupon = Coupon::where($filter)->first();
        $error = false;
        $ts_current = strtotime(date('Y-m-d'));
        if($coupon)
        {
            if ($coupon['date_from'] || $coupon['date_to']) {
                if ($coupon['date_from']) {
                    $ts_from = strtotime($coupon['date_from']);
                    if ($ts_current < $ts_from)
                        $error = true;
                }
                if ($coupon['date_to']) {
                    $ts_to = strtotime($coupon['date_to']);
                    if ($ts_current > $ts_to)
                        $error = true;
                }
            }
        }
        else
        {
            $error = true;
        }

        if (!$error) {
            return $coupon;
        }

        return false;
    }

    public static function removeCouponFromCartItem($cart_item)
    {
        $filter['vendor_id'] = $cart_item->attributes->vendor_id;
        $coupon = self::IsActiveCoupon($filter);
        // $coupon = self::where([
        //     ['vendor_id', $cart_item->attributes->vendor_id]
        // ])->first();

        $cartItemsCountforVendor = 0;

        // Set Cart for items
        $cart = product_cart(session()->get('rand_num'));
        $cartItems = $cart->getContent();
        foreach($cartItems as $cart)
        {
            if($cart->attributes->vendor_id == $cart_item->attributes->vendor_id)
            {
                $cartItemsCountforVendor++;
            }
        }
        if($coupon && $cartItemsCountforVendor==0 && session()->get('ses_vendor_coupon')!=null && !empty(session()->get('ses_vendor_coupon')))
        {
            $conditionName = $coupon['id'].'-'.$coupon['name'];

            // Set Cart for items
            $cart = product_cart(session()->get('rand_num'));
            $cart->removeCartCondition($conditionName);

            $vendor_coupons = session()->get('ses_vendor_coupon');
            if ($vendor_coupons != null) {
                $vendor_coupons = session()->get('ses_vendor_coupon');
                unset($vendor_coupons[$cart_item->attributes->vendor_id]);
                if(!empty($vendor_coupons))
                {
                    session()->put('ses_vendor_coupon', $vendor_coupons);
                }
                else
                {
                    session()->forget('ses_vendor_coupon');
                }
            }
        }
        return true;
    }

    public static function AllowCouponInExistingVendorCart($vendor_id)
    {
        $filter['vendor_id'] = $vendor_id;
        $coupon = self::IsActiveCoupon($filter);

        if($coupon && session()->get('ses_vendor_coupon')!=null && !empty(session()->get('ses_vendor_coupon')[$vendor_id]))
        {
            $vendor_coupons = session()->get('ses_vendor_coupon');

            if ($coupon['type'] == 1) {
                $vendor_coupons[$vendor_id] = ['vendor' => $vendor_id, 'type' => 'amount', 'value' => $coupon['discount'], 'code' => $coupon['coupon'], 'id' => $coupon['id']];
            } else {
                $vendor_coupons[$vendor_id] = ['vendor' => $vendor_id, 'type' => 'percent', 'value' => $coupon['discount'], 'code' => $coupon['coupon'], 'id' => $coupon['id']];
            }

            $conditionName = $coupon['id'].'-'.$coupon['name'];

            // Set Cart for items
            $cart = product_cart(session()->get('rand_num'));
            $cart->removeCartCondition($conditionName);

            $discount = get_vendor_discount('full',$vendor_id);
            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => $coupon['id'].'-'.$coupon['name'],
                'type' => 'coupon',
                'target' => 'total', // this condition will be applied to cart's total when getTotal() is called.
                'value' => '-' . $discount,
                'order' => 1 // the order of calculation of cart base conditions. The bigger the later to be applied.
            ));
            $cart->condition($condition);
        }
    }

    public static function checkToAllowCoupon($coupon, $vendor_id)
    {
        if(!$coupon)
        {
            return false;
        }

        // Set Cart for items
        $cart = product_cart(session()->get('rand_num'));
        $cartItems = $cart->getContent();
        if($cartItems)
        {
            $totalVendorAmount = 0;
            foreach($cartItems as $cart)
            {
                if ($cart->attributes->vendor_id == $vendor_id) {
                    $totalVendorAmount += $cart->price * $cart->quantity;
                }
            }
            if( ((float)$coupon['discount'] < (float)$totalVendorAmount && $coupon['type']==1) || $coupon['type'] != 1 )
            {
                return true;
            }
        }
        return false;
    }


    public static function checkToAllowCouponDvm($coupon, $vendor_id, $customer_id)
    {
        if(!$coupon)
        {
            return false;
        }

        // Set Cart for items
        $customerItems = ProductCart::where('customer_id', $customer_id)->get();
        if(!$customerItems){
            return false;
        } else {
            $products = [];
            $vendors = [];
            foreach ($customerItems as $items) {
                array_push($products, $items->product_id);
                array_push($vendors, $items->vendor_id);
            }
            ;

            foreach ($customerItems as $key => $item) {
                $cartProducts = Vendor::whereIn('id', $vendors)->with([
                    'products' => function ($query) use ($products) {
                        $query->with('cart_items')->whereIn('id', $products)->select('id', 'vendor_id', 'parent_id', 'type', 'level', 'name', 'slug', 'sku', 'price', 'price_catalog', 'price_discounted', 'image', 'status', 'quantity', 'in_stock');
                    }
                ])->select('id', 'name', 'user', 'contact_name', 'email', 'zip_code', 'logo', 'slug', 'status')->get();
            }
            
            if (isset($cartProducts) && count($cartProducts) > 0) {
                $totalVendorAmount = 0;
                foreach ($cartProducts as $cp) {
                    if ($cp->id == $vendor_id) {
                        foreach ($cp->products as $key => $prd) {
                            $totalVendorAmount += $prd->price * $prd->cart_items->quantity;
                        }
                    }
                }
                // dd($totalVendorAmount);
                return $totalVendorAmount;
                if (((float) $coupon['discount'] < (float) $totalVendorAmount && $coupon['type'] == 1) || $coupon['type'] != 1) {
                    return true;
                }
            }
        }
        return false;
    }
}
