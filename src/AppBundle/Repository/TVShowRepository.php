<?php

namespace AppBundle\Repository;

/**
 * TVShowRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TVShowRepository extends \Doctrine\ORM\EntityRepository
{
    public function myTvShowsBySearch($term = '')
    {
        $query = $this->createQueryBuilder('tv_show')
            ->where('tv_show.name like :tv_show_name')
            ->orWhere('tv_show.synopsis like :tv_show_synopsis')
            ->orderBy('tv_show.id', 'ASC')
            ->setParameter('tv_show_name', '%' . $term . '%')
            ->setParameter('tv_show_synopsis', '%' . $term . '%')
            ->getQuery();
        return $query->getResult();
    }
}
