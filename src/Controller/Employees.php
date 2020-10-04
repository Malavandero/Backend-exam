<?php

namespace App\Controller;

use App\Application\Employee\Create\CreateUseCase;
use App\Application\Employee\Delete\DeleteUseCase;
use App\Application\Employee\Update\UpdateUseCase;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("api/v1/")
 */
class Employees extends ApiAbstractController
{

    /**
     * @param Request $httpRequest
     * @param CreateUseCase $useCase
     * @return JsonResponse
     * @Route("employees", name="api_create_employee", methods={"POST"} )
     */
    public function create(Request $httpRequest, CreateUseCase $useCase):JsonResponse
    {
        try {
            $jsonData = $this->ensureJsonBodyAndKeysExists($httpRequest->getContent(), ['name', 'hiringDate', 'companyId']);
            $employee = $useCase->__invoke(
                $jsonData['name'],
                new DateTime($jsonData['hiringDate']),
                $jsonData['companyId']
            );
            $data = $this->serializer->serialize($employee, 'json',['groups' => ['api']]);
            return JsonResponse::fromJsonString($data);
        }catch (Exception $e){
            return $this->returnJsonErrorResponse($e);
        }
    }

    /**
     * @param string $employeeId
     * @param Request $httpRequest
     * @param UpdateUseCase $useCase
     * @return JsonResponse
     * @Route("employees/{employeeId}", name="api_update_employee", methods={"PUT"} )
     */
    public function update(string $employeeId, Request $httpRequest, UpdateUseCase $useCase):JsonResponse
    {
        try {
            $jsonData = $this->ensureJsonBodyAndKeysExists($httpRequest->getContent(), ['name', 'hiringDate', 'companyId']);
            $employee = $useCase->__invoke(
                $employeeId,
                $jsonData['name'],
                new DateTime($jsonData['hiringDate']),
                $jsonData['companyId']
            );
            $data = $this->serializer->serialize($employee, 'json',['groups' => ['api']]);
            return JsonResponse::fromJsonString($data);
        }catch (Exception $e){
            return $this->returnJsonErrorResponse($e);
        }
    }

    /**
     *
     * @param string $employeeId
     * @param DeleteUseCase $useCase
     * @return JsonResponse
     * @Route("employees/{employeeId}", name="api_delete_employee", methods={"DELETE"} )
     */
    public function delete(string $employeeId, DeleteUseCase $useCase):JsonResponse
    {
        try {
            $useCase->__invoke($employeeId);
            return new JsonResponse();
        }catch (Exception $e){
            return $this->returnJsonErrorResponse($e);
        }
    }

}