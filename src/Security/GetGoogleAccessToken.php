<?php

namespace App\Security;

use App\Entity\User;
use App\Exceptions\ResourceNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;

class GetGoogleAccessToken
{
    private $client;
    private $em;

    public function __construct(GoogleClient $client, EntityManagerInterface $em)
    {
        $this->client = $client;
        $this->em = $em;
    }

    public function get()
    {
        $userRepository = $this->em->getRepository(User::class);
        $accessToken = $this->client->getAccessToken();
        $accessTokenValue = $accessToken->getToken();

        /** @var GoogleUser $googleUser */
        $googleUser = $this->client->fetchUserFromToken($accessToken);

        if ($googleUser->toArray()['email_verified']) {
            
            /** @var User $existingUser */
            $existingUser = $userRepository->findOneBy(['googleId' => $googleUser->getId()]);

            if ($existingUser) {
                $existingUser->setToken($accessTokenValue);
                $this->em->flush();
                return $accessTokenValue;
            } else {
                throw new ResourceNotFoundException("You are not registered in our database");                
            }
        }
    }
}
