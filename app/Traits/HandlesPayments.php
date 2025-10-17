<?php

namespace App\Traits;

use App\Models\Payment;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

trait HandlesPayments
{
    protected function createPayment($bookable, $stripeObject, string $type): Payment
    {
        return Payment::create([
            'bookable_type' => $type,
            'bookable_id' => $bookable->id,
            'stripe_payment_id' => $this->getStripePaymentId($stripeObject),
            'amount' => $this->getAmountFromStripeObject($stripeObject),
            'status' => $this->getPaymentStatus($stripeObject),
            'metadata' => [
                'type' => $type,
                'stripe_object' => class_basename($stripeObject)
            ]
        ]);
    }

    protected function updateOrCreatePayment($bookable, $stripeObject, string $type): Payment
    {
        return Payment::updateOrCreate(
            [
                'stripe_payment_id' => $this->getStripePaymentId($stripeObject)
            ],
            [
                'bookable_type' => $type,
                'bookable_id' => $bookable->id,
                'amount' => $this->getAmountFromStripeObject($stripeObject),
                'status' => $this->getPaymentStatus($stripeObject),
                'metadata' => [
                    'type' => $type,
                    'stripe_object' => class_basename($stripeObject)
                ]
            ]
        );
    }

    protected function createPaymentFromSession($bookable, Session $session, string $type): Payment
    {
        return $this->createPayment($bookable, $session, $type);
    }

    private function getStripePaymentId($stripeObject): string
    {
        if ($stripeObject instanceof PaymentIntent) {
            return $stripeObject->id;
        }

        if ($stripeObject instanceof Session) {
            return $stripeObject->payment_intent ?? $stripeObject->id;
        }

        throw new \InvalidArgumentException('Unsupported Stripe object type');
    }

    private function getAmountFromStripeObject($stripeObject): float
    {
        if ($stripeObject instanceof PaymentIntent) {
            return $stripeObject->amount / 100;
        }

        if ($stripeObject instanceof Session) {
            return $stripeObject->amount_total / 100;
        }

        throw new \InvalidArgumentException('Unsupported Stripe object type');
    }

    private function getPaymentStatus($stripeObject): string
    {
        if ($stripeObject instanceof PaymentIntent) {
            return $stripeObject->status;
        }

        if ($stripeObject instanceof Session) {
            return $stripeObject->payment_status;
        }

        throw new \InvalidArgumentException('Unsupported Stripe object type');
    }
}