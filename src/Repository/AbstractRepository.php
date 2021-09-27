<?php

namespace App\Repository;

use App\Exceptions\ResourceValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;

abstract class AbstractRepository extends ServiceEntityRepository
{
    // limit = nombre d'éléments par page
    // offset = (index de l'élément qu'on veut voir sur la page courante) + 1
    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 1)
    {
        if (0 == $limit || 0 == $offset) {
            throw new ResourceValidationException('$limit & $offstet must be greater than 0.');
        }
        $pager = new Pagerfanta(new QueryAdapter($qb));
        $currentPage = ceil(($offset) / $limit);
        $pager->setMaxPerPage((int) $limit);
        $pager->setCurrentPage($currentPage);

        return $pager;
    }
}
