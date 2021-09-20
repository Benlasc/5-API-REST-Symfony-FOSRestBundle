<?php

namespace App\Controller;

use App\Entity\UserClient;
use App\Exception\ResourceValidationException;
use App\Exceptions\ResourceForbiddenException;
use App\Exceptions\ResourceNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use OpenApi\Annotations\JsonContent;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class UsersController extends AbstractFOSRestController
{

    private $request;
    private $tokenStorage;

    public function __construct(RequestStack $request, TokenStorageInterface $tokenStorage) {
        $this->request = $request;
        $this->tokenStorage = $tokenStorage;
    }

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

        // $this->request->getSession()->invalidate();
        // $this->tokenStorage->setToken(null);
        
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
    
    /**
     * @Rest\Post(
     *    path = "/client/new",
     *    name = "newClient"
     * )
     * @Rest\View(StatusCode = 201)
     * @ParamConverter("userClient", converter="fos_rest.request_body")
     * 
     * @OA\Post(
     *      tags={"Your clients"},
     *      @OA\Response(
     *          response="201",
     *          description="Your new client",
     *          @OA\JsonContent(ref=@Model(type=UserClient::class, groups={"details"})),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref=@Model(type=UserClient::class, groups={"details"}))
     *      )
     * )
     * 
     * @Security(name="OAuth2")
     * 
     */
    public function create(UserClient $userClient, ConstraintViolationList $violations)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (count($violations)) {
            $message = 'The JSON sent contains invalid data. Here are the errors you need to correct: ';
            foreach ($violations as $violation) {
                $message .= sprintf("Field %s: %s ", $violation->getPropertyPath(), $violation->getMessage());
            }

            throw new ResourceValidationException($message);
        }

        $userClient->setUser($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($userClient);
        $em->flush();

        return $this->view(
            $userClient,
            Response::HTTP_CREATED,
            ['location' => $this->generateUrl(
                'app_article_show',
                ['id' => $userClient->getId()],
                UrlGeneratorInterface::ABSOLUTE_URL
            )]
        );
    }

    #[Route('/connect', name: 'connexion', methods: ['GET'])]
    public function connect()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return new Response("Vous êtes bien connecté.");
    }
}
