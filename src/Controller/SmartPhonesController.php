<?php

namespace App\Controller;

use App\Entity\SmartPhone;
use App\Exceptions\ResourceNotFoundException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;
use OpenApi\Annotations\JsonContent;
use Nelmio\ApiDocBundle\Annotation\Model;

class SmartPhonesController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/phones", name="phones_list")
     * @Rest\QueryParam( 
     *     name="brand", 
     *     requirements="[a-zA-Z0-9]+", 
     *     nullable=true, 
     *     description="The brand to search for." 
     * )
     * @Rest\QueryParam( 
     *     name="price", 
     *     requirements="asc|desc", 
     *     default="asc",
     *     description="Price sort order (asc or desc)" 
     * )
     * @Rest\View( 
     *     statusCode = 200, 
     *     serializerGroups = {"list"}
     * )
     * 
     * @OA\Get(
     *      tags={"Smartphones"},
     *      @OA\Response(
     *          response="200",
     *          description="Our smartphones",
     *          @OA\JsonContent(type="array", @OA\Items(ref=@Model(type=SmartPhone::class, groups={"list"})))
     *      )
     * )
     */
    public function list($brand, $price)
    {
        $smartPhones = $this->getDoctrine()->getRepository(SmartPhone::class)->findBrand(
            $brand, $price
        );

        return $smartPhones;
    }

    /**
     * @Rest\Get("/phone/{id}", name="show", requirements = {"id"="\d+"})
     * @Rest\View( 
     *     statusCode = 200, 
     *     serializerGroups = {"details"} 
     * )
     * 
     * @OA\Get(
     *      tags={"Smartphones"},
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Resource id",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns phone details",
     *          @OA\JsonContent(ref=@Model(type=SmartPhone::class, groups={"details"}))
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="If the requested smartphone does not exist in our database",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="This phone does not exist in our database")
     *      )
     * )
     * )
     */
    public function show(?SmartPhone $smartPhone)
    {
        if ($smartPhone) {
            return $smartPhone;
        } else {
            throw new ResourceNotFoundException("This phone does not exist in our database");
        }
        
        
    }    
}
