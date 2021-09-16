<?php

namespace App\Controller;

use App\Entity\SmartPhone;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcherInterface;

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
     * 
     * @Rest\View( 
     *     statusCode = 200, 
     *     serializerGroups = {"list"} 
     * )
     */
    public function list($brand, $price)
    {
        $smartPhones = $this->getDoctrine()->getRepository(SmartPhone::class)->findBrand(
            $brand, $price
        );

        //moi : seul les propriétés (pas les méthodes) de la classe Articles suivante seront sérialisées en json
        return $smartPhones;
    }
}
