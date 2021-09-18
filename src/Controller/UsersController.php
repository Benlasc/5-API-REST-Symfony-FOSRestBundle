<?php

namespace App\Controller;

use App\Entity\UserClient;
use App\Exceptions\ResourceNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use OpenApi\Annotations\JsonContent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;

class UsersController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/clients", name="clients_list")
     * 
     * @Rest\View( 
     *     statusCode = 200, 
     *     serializerGroups = {"list"}
     * )
     * 
     * @OA\Get(
     *      tags={"Your clients"},
     *      @OA\Response(
     *          response="200",
     *          description="Your clients",
     *          @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=UserClient::class, groups={"list"})))
     *      )
     * )
     * 
     * @Security(name="OAuth2")
     */
    public function list()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $authenticatedUser = $this->getUser();
        
        return $authenticatedUser->getUserClients();
    }
}
