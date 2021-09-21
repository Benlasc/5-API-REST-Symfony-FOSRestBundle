<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use KnpU\OAuth2ClientBundle\Security\Authenticator\OAuth2Authenticator;
use KnpU\OAuth2ClientBundle\Client\Provider\GoogleClient;
use League\OAuth2\Client\Provider\GoogleUser;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class GoogleAuthenticator extends OAuth2Authenticator
{
    private $client;
    private $entityManager;

    public function __construct(GoogleClient $client, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): PassportInterface
    {
        $bearer = $request->headers->get('Authorization');

        $accessToken = substr($bearer, 7);

        return new SelfValidatingPassport(new UserBadge($accessToken, function () use ($accessToken) {

            try {
                /** @var GoogleUser $googleUser */
                $googleUser = $this->client->fetchUserFromToken(new AccessToken(["access_token" => $accessToken]));
            } catch (\Exception $e) {
                return null;
            }

            if ($googleUser->toArray()['email_verified']) {

                $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['googleId' => $googleUser->getId()]);

                if ($existingUser) {
                    return $existingUser;
                }
              
            }
            // To test the application -> if the Google user is not registered in our database, we return the first user in the database
            //return $this->entityManager->getRepository(User::class)->find(1);
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // On success, let the request continue to be handled by the controller
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // $message = strtr($exception->getMessageKey(), $exception->getMessageData());

        // return new Response($message, Response::HTTP_FORBIDDEN);

        $response = [
            "Code" => "401",
            "Message" => "Your access token is not valid :("
        ];

        return new Response(json_encode($response), 401);
    }
}
