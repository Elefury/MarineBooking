<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_promo_code_applies_discount()
    {
        $promo = PromoCode::factory()->create([
            'code' => 'TEST2024',
            'discount_value' => 20
        ]);

        $response = $this->post(route('booking.apply-promo'), [
            'promoCode' => 'TEST2024'
        ]);

        $response->assertJson(['discount' => 20]);
    }
}
