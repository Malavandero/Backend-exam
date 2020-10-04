<?php

namespace App\Controller;

use App\Application\Company\AddEmployee\AddEmployeeUseCase;
use App\Application\Company\Create\CreateUseCase;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("api/v1/")
 */
class Companies extends ApiAbstractController
{

    /**
     * @param string $companyId
     * @param Request $httpRequest
     * @param AddEmployeeUseCase $useCase
     * @return JsonResponse
     * @Route("companies/{companyId}/employees", name="api_add_employee_company", methods={"POST"} )
     */
    public function addEmployee(string $companyId, Request $httpRequest, AddEmployeeUseCase $useCase):JsonResponse
    {
        try {
            $jsonData = $this->ensureJsonBodyAndKeysExists($httpRequest->getContent(), ['employeeId']);
            $useCase->__invoke($companyId, $jsonData['employeeId']);
            return new JsonResponse();
        }catch (Exception $e){
            return $this->returnJsonErrorResponse($e);
        }
    }

    /**
     * @param Request $httpRequest
     * @param CreateUseCase $useCase
     * @return JsonResponse
     * @Route("companies", name="api_create_company", methods={"POST"} )
     */
    public function create(Request $httpRequest, CreateUseCase $useCase):JsonResponse
    {
        try {
            $jsonData = $this->ensureJsonBodyAndKeysExists($httpRequest->getContent(), ['name']);
            $company = $useCase->__invoke($jsonData['name']);
            $data = $this->serializer->serialize($company, 'json',['groups' => ['api']]);
            return JsonResponse::fromJsonString($data);
        }catch (Exception $e){
            return $this->returnJsonErrorResponse($e);
        }
    }

}