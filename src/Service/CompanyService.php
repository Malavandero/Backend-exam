<?php

namespace App\Service;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class CompanyService
{
    /** @var CompanyRepository $itemRepository */
    private $itemRepository;

    public function __construct(
        CompanyRepository $itemRepository
    )
    {
        $this->itemRepository = $itemRepository;
    }

    public function create($name)
    {
        $item = new Company();
        $item->setName($name);

        try {
            $this->itemRepository->save($item);
        } catch (\Exception $e) {
            throw new BadRequestException($e->getMessage());
        }

        return $item;
    }
}