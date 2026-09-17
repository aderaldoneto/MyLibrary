<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AuthControllerTest extends WebTestCase
{
    protected static function createKernel(array $options = []): Kernel
    {
        return new Kernel('test', true);
    }

    public function testLoginPageIsAccessible(): void
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Login');
    }

    public function testUserEntityExposesEmailAsIdentifier(): void
    {
        $user = new User();
        $user->setEmail('admin@mylibrary.test');
        $user->setUserName('Admin');
        $user->setUserLastName('Admin');
        $user->setPassword('minha-senha');

        $this->assertSame('admin@mylibrary.test', $user->getUserIdentifier());
        $this->assertSame('minha-senha', $user->getPassword());
    }
}
