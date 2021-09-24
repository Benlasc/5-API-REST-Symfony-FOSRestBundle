<?php

namespace App\Controller;

use App\Security\GetGoogleAccessToken;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Rest\Get("/getToken", name="connect_google_start")
     * @OA\Get(
     *      tags={"Get your access token (need a Google account)"},
     *      description="Route to get or refresh your access token. Use this route in a browser to allow authentication by the google oauth2 server.",
     *      @OA\Response(
     *          response="200",
     *          description="The access token provided by the google oauth2 server",
     *          @OA\JsonContent(@OA\Property(property="Your new access token : ", type="string", example="545dfzefzegr6er8rg..."))
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="If the Google user does not exist in our database",
     *          @OA\JsonContent(
     *              @OA\Property(property="code", type="integer", example="404"),
     *              @OA\Property(property="message", type="string", example="You are not registered in our database"))
     *      ),
     * )
     */
    public function connect(ClientRegistry $clientRegistry):RedirectResponse
    {
        // will redirect to Google !
        return $clientRegistry
            ->getClient('google_main') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect(['profile', 'email'], []); // voir https://developers.google.com/identity/protocols/oauth2/scopes
    }

    /**
     * After going to Google, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/google/check", name="connect_google_check")
     */
    public function connectCheck(GetGoogleAccessToken $getGoogleAccessToken,Request $request)
    {
        $response = [
            "Your new access token" => $getGoogleAccessToken->get()
        ];

        return new Response(json_encode($response), 200);
    }
}