<?php

namespace App\Controller;

use App\Entity\UserClient;
use App\Exceptions\ResourceForbiddenException;
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

    /**
     * @Rest\Get("/client/{id}", name="showClient", requirements = {"id"="\d+"})
     * @Rest\View( 
     *     statusCode = 200, 
     *     serializerGroups = {"details"} 
     * )
     * 
     * @OA\Get(
     *      tags={"Your clients"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Resource id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns client details",
     *          @OA\JsonContent(ref=@Model(type=UserClient::class, groups={"details"}))
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="If the requested UserClient does not exist in our database",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="This client does not exist in our database"))
     *      ),
     *      @OA\Response(
     *          response="403",
     *          description="If the requested UserClient is not a client of the User",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="This client is not yours"))
     *      ),
     * )
     * 
     * @Security(name="OAuth2")
     */
    public function show(?UserClient $userClient)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $authenticatedUser = $this->getUser();

        if ($userClient) {
            if ($userClient->getUser() === $authenticatedUser) {
                return $userClient;
            } else {
                throw new ResourceForbiddenException("This client is not yours");
            }            
        } else {
            throw new ResourceNotFoundException("This userClient does not exist in our database");
        }        
    }    
}
