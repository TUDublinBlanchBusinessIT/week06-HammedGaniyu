<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Product;
use App\Models\Scorder;
use App\Models\OrderDetail;
use Flash; // optional for flash messages

class scordersController extends Controller
{
    // Show checkout page
    public function checkout()
    {
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $lineitems = [];

            foreach ($cart as $productid => $qty) {
                $lineitem['product'] = Product::find($productid);
                $lineitem['qty'] = $qty;
                $lineitems[] = $lineitem;
            }

            return view('scorders.checkout')->with('lineitems', $lineitems);
        } else {
            Flash::error("There are no items in your cart");
            return redirect(route('products.displaygrid'));
        }
    }

    // Place order and save to database
    public function placeorder(Request $request)
    {
        $thisOrder = new Scorder();
        $thisOrder->orderdate = now();
        $thisOrder->save();

        $orderID = $thisOrder->id;
        $productids = $request->productid;
        $quantities = $request->quantity;

        for ($i = 0; $i < sizeof($productids); $i++) {
            OrderDetail::create([
                'orderid' => $orderID,
                'productid' => $productids[$i],
                'quantity' => $quantities[$i]
            ]);
        }

        Session::forget('cart');
        Flash::success("Your Order has Been Placed");
        return redirect(route('products.displaygrid'));
    }
}