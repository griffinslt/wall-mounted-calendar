<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    use RefreshDatabase;
    protected bool $seed = true;

    public function test_admin()

    {
        $response = $this->get('/admin');
        $response->assertStatus(302); //redirection
        $response->assertRedirectToRoute('bookings.index');
    }

    public function test_set_cookie()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->get('/tablet-setup');
        $response->assertStatus(200);
        
    }

    public function test_tablet_view_no_cookie()
    {
        $response = $this->get('/tablet-view');
        $response->assertStatus(403);
    }

    public function test_tablet_view_with_cookie()
    {
        $response = $this->withCookie('tablet_room', '1')->get('/tablet-view');   
        $response->assertStatus(200);
    }

    public function test_tablet_view_with_wrong_cookie()
    {
        $response = $this->withCookie('tablet_room', '10000')->get('/tablet-view');   
        $response->assertStatus(404);
    }



    public function test_tablet_setup()
    {
        $response = $this->post('/tablet-setup/set-cookie', ['room' => 1, 'building' => 1]);
        $response->assertCookie('tablet_room', 1);
    }

    public function test_book_room_valid()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->post('/admin/bookings/', [
            "room_id" =>1,
            "duration" => 30,
            "year" => 2024,
            "month" => 12,
            "day" => 1,
            "hour" => 12,
            "minute" => 0,
        ]);
        $response->assertSessionHas("message",'Booking was Created.');
    }

    //tests an entry into the data base where there already is one
    public function test_book_room_invalid()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->post('/admin/bookings/', [
            "room_id" =>201,
            "duration" => 30,
            "year" => 2023,
            "month" => 2,
            "day" => 1,
            "hour" => 10,
            "minute" => 30,
        ]);
        $response->assertSessionHas("error",'Booking was Not Created.');
    }

    public function test_delete_booking()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->delete('/bookings/' . 1);
        $response->assertSessionHas('message', 'Booking was Deleted.');
    }

    public function test_delete_booking_without_access()
    {
        $user = User::find(2);
        $response = $this->actingAs($user)->delete('/bookings/' . 1);
        $response->assertStatus(403);
    }


    





    





    
}
