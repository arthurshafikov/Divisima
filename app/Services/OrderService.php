<?php

namespace App\Services;

use App\Events\OrderPlaced;
use App\Includes\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function createOrder(Collection $checkoutFields): Order
    {
        $cartData = Cart::getCart();

        if (!$this->checkItemsAreValid($cartData['items'])) {
            throw new Exception(__('cart.invalid'));
        }

        $user = Auth::user();
        if ($user === null) {
            $user = User::create($checkoutFields->only('email', 'name', 'password')->toArray());
            Auth::attempt($checkoutFields->only('email', 'password')->toArray());
        }

        $this->saveUserProfileInfoFromCheckoutFields($user, $checkoutFields);

        $orderData = $checkoutFields->only('address', 'zip', 'phone', 'country', 'delivery', 'additional');
        $orderData['user_id'] = $user->id;
        $orderData['subtotal'] = $cartData['subtotal'];
        $orderData['discount'] = $cartData['discount'];
        $orderData['total'] = $cartData['numericTotal'];

        $order = Order::create($orderData->toArray());

        $cartData['items']->each(function ($item) use ($order) {
            $order->products()->attach($item->id, [
                'qty' => $item['qty'],
                'attributes' => $item['attributes'],
                'subtotal' => $item['number_subtotal'],
            ]);
        });

        Cart::resetCart();

        event(new OrderPlaced($order));

        return $order;
    }

    public function incrementProductsTotalSales(Order $order)
    {
        $order->products->each(function (Product $product) {
            $product->total_sales += $product->pivot->qty;
            $product->save();
        });
    }

    private function saveUserProfileInfoFromCheckoutFields(User $user, Collection $checkoutFields)
    {
        $profileData = array_merge(
            $checkoutFields->only('first_name', 'surname', 'address', 'country', 'zip', 'phone')->toArray(),
            [
                'user_id' => $user->id,
            ],
        );
        $user->profile()->updateOrCreate($profileData);
    }

    private function checkItemsAreValid(Collection $cartItems): bool
    {
        $cartItemsAreValid = true;
        foreach ($cartItems as $cartItem) {
            $cartAttributes = $cartItem->attributes;
            if (empty($cartAttributes)) {
                continue;
            }

            foreach ($cartAttributes as $cartAttribute => $cartAttributeVariation) {
                $res = $cartItem->attributeVariations()->whereHas('attribute', function (Builder $query) use ($cartAttribute) {
                    $query->whereName($cartAttribute);
                })->whereName($cartAttributeVariation)->exists();
                if (!$res) {
                    $cartItemsAreValid = false;
                    app(Cart::class)->removeFromCart($cartItem->id);
                }
            }
        }

        return $cartItemsAreValid;
    }
}
