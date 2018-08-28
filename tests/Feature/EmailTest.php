<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Mail\OTPMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class EmailTest extends TestCase
{
	use DatabaseMigrations;

	/**
	 * @test
	 */
    public function an_otp_email_is_sent_when_user_is_logged_in()
    {
    	Mail::fake();
		$this->withoutExceptionHandling();
    	$user = factory(User::class)->create();
    	$res = $this->post('/login', ['email' => $user->email, 'password' => 'secret']);
    	Mail::assertSent(OTPMail::class);
	}
	
	/**
	 * @test
	 */
	public function an_otp_email_is_not_sent_if_credencials_are_incorrect() {
		Mail::fake();
    	$user = factory(User::class)->create();
    	$res = $this->post('/login', ['email' => $user->email, 'password' => 'secrhhet']);
    	Mail::assertNotSent(OTPMail::class);
	}
}
