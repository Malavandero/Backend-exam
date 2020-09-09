<?php

namespace App\Controller;

use App\Service\CompanyService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class CompanyController extends AbstractController
{
    protected $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/company",
     *     name="post_company",
     *     methods={"POST"})
     * @param Request $httpRequest
     * @param CompanyService $companyService
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(Request $httpRequest, CompanyService $companyService)
    {
        $jsonData = json_decode($httpRequest->getContent(), true);
        if (!$jsonData) {
            throw new BadRequestException("json is missing from request");
        }
        if (!array_key_exists('name', $jsonData)) {
            throw new \Exception("name required");
        }

        $companyName = $jsonData['name'];

        $companyService->create($companyName);

        return JsonResponse::fromJsonString('Company ' . $companyName . ' was created');
    }
}
