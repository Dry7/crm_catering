<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;

/**
 * Class AcachaAdminLTELaravelTest.
 */
class AcachaAdminLTELaravelTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test Landing Page.
     *
     * @return void
     */
    public function testLandingPage()
    {
        $this->visit('/')
             ->see('Login');
    }

    /**
     * Test Landing Page.
     *
     * @return void
     */
    public function testLandingPageWithUserLogged()
    {
        $user = factory(App\User::class)->create(['active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)
            ->visit('/calendar')
            ->see($user->name);
    }

    /**
     * Test Login Page.
     *
     * @return void
     */
    public function testLoginPage()
    {
        $this->visit('/login')
            ->see('Войти');
    }

    /**
     * Test Login.
     *
     * @return void
     */
    public function testLogin()
    {
        $user = factory(App\User::class)->create(['username' => 'username', 'password' => 'passw0RD', 'active' => 1, 'work_hours' => 0]);

        $this->visit('/login')
            ->type('username', 'username')
            ->type('passw0RD', 'password')
            ->press('Войти')
            ->seePageIs('/home')
            ->see($user->name);
    }

    /**
     * Test Login.
     *
     * @return void
     */
    public function testLoginRequiredFields()
    {
        $this->visit('/login')
            ->type('', 'username')
            ->type('', 'password')
            ->press('Войти')
            ->see('Поле username обязательно для заполнения.')
            ->see('Поле password обязательно для заполнения.');
    }

    /**
     * Test Register Page.
     *
     * @return void
     */
    public function testRegisterPage()
    {
        $this->visit('/register')
            ->seePageIs('/login');
    }

    /**
     * Test Password reset Page.
     *
     * @return void
     */
    public function testPasswordResetPage()
    {
        $this->visit('/password/reset')
            ->seePageIs('/login');
    }

    /**
     * Test home page is only for authorized Users.
     *
     * @return void
     */
    public function testHomePageForUnauthenticatedUsers()
    {
        $this->visit('/home')
            ->seePageIs('/login');
    }

    /**
     * Test home page works with Authenticated Users.
     *
     * @return void
     */
    public function testHomePageForAuthenticatedUsers()
    {
        $user = factory(App\User::class)->create(['active' => 1, 'work_hours' => 0]);

        $this->actingAs($user)
            ->visit('/home')
            ->see($user->name);
    }

    /**
     * Test log out.
     *
     * @return void
     */
    public function testLogout()
    {
        $user = factory(App\User::class)->create();

        $response = $this->actingAs($user)
            ->call('POST', '/logout', [
                '_token' => csrf_token()
            ]);

        $this->assertEquals(302, $response->getStatusCode());
    }

    /**
     * Test 404 Error page.
     *
     * @return void
     */
    public function test404Page()
    {
        $this->get('asdasdjlapmnnk')
            ->seeStatusCode(404)
            ->see('404');
    }
}
