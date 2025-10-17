<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function apply(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|exists:promo_codes,code'
        ]);
        
        $promo = PromoCode::where('code', $validated['code'])
            ->valid()
            ->firstOrFail();
            
        Cart::applyPromo($promo);
        
        return back()->with('success', 'Promo code applied');
    }

}
