<?php

namespace App\Service;


use App\Entity\EntityInterface;
use App\Repository\BaseRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseService
{
    /**
     * @param BaseRepository $repository
     * @param EntityInterface $entity
     * @return EntityInterface
     * @throws \Exception
     */
    protected function save(BaseRepository $repository, EntityInterface $entity){
        if ($repository->save($entity)) {
            return $entity;
        } else {
            throw new \Exception('Had problem to save entity, try again.');
        }
    }
}
