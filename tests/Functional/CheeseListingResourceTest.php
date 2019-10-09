<?php

namespace App\Tests\Functional;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class CheeseListingResourceTest extends ApiTestCase
{
    public function testCreateCheeseListing()
    {
        $client = self::createClient();

        $client->request('POST', '/api/cheeses', [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'json' => []
        ]);
        $this->assertResponseStatusCodeSame(401);

        $user = new User();
        $user->setEmail('toto@toto.com');
        $user->setUsername('toto');
        $user->setPassword('$argon2id$v=19$m=65536,t=4,p=1$vVLMeNjbK3EouSZAN9Zokw$jm7OChGMBss+IItzpuehDSi2FWC+S7UMEa2CYYQ+Z78');

        $em = self::$container->get(EntityManagerInterface::class);
        $em->persist($user);
        $em->flush();

        $client->request('POST', '/login', [
            'headers' => ['Content-Type' => 'application/json'],
            'json' => [
                'email' => 'toto@toto.com',
                'password' => 'foo'
            ],
        ]);
        $this->assertResponseStatusCodeSame(204);
    }
}
