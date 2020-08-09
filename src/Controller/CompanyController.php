<?php

namespace App\Controller;

use App\Util\CompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\RequestBody;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company_index", methods={"GET"})
     */
    public function index(CompanyService $companyService)
    {
        return $this->json($companyService->getAll());
    }
    /**
     * @Route("/company", name="company_new", methods={"POST"})
     */
    public function new(Request $request, CompanyService $companyService)
    {
        $data = $request->getContent();
        $companyService->create($data);

        return $this->json([]);
    }
}
