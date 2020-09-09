<?php

namespace App\Controller;

use App\Service\CompanyService;
use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EmployeeController extends AbstractController
{
    protected $serializer;

    public function __construct(
        SerializerInterface $serializer
    ) {
        $this->serializer = $serializer;
    }

    /**
     * @Route("/employee",
     *     name="post_employee",
     *     methods={"POST"})
     * @param Request $httpRequest
     * @param EmployeeService $employeeService
     * @return JsonResponse
     * @throws \Exception
     */
    public function create(Request $httpRequest, EmployeeService $employeeService)
    {
        $jsonData = json_decode($httpRequest->getContent(), true);
        if (!$jsonData) {
            throw new BadRequestException("json is missing from request");
        }
        if (!array_key_exists('name', $jsonData)) {
            throw new \Exception("name required");
        }
        if (!array_key_exists('contractDate', $jsonData)) {
            throw new \Exception("contractDate required");
        }

        $employeeName = $jsonData['name'];
        $contractDate = $jsonData['contractDate'];

        $employeeService->create($employeeName, $contractDate);

        return JsonResponse::fromJsonString('Employee ' . $employeeName . ' was created');
    }

    /**
     * @Route("/employee/{employeeId}",
     *     name="put_employee",
     *     methods={"PUT"})
     * @param Request $httpRequest
     * @param EmployeeService $employeeService
     * @param $employeeId
     * @return JsonResponse
     * @throws \Exception
     */
    public function update(Request $httpRequest, EmployeeService $employeeService, $employeeId)
    {
        $jsonData = json_decode($httpRequest->getContent(), true);
        if (!$jsonData) {
            throw new BadRequestException("json is missing from request");
        }
        if (!array_key_exists('name', $jsonData)) {
            throw new \Exception("name required");
        }
        if (!array_key_exists('contractDate', $jsonData)) {
            throw new \Exception("contractDate required");
        }

        $employeeName = $jsonData['name'];
        $contractDate = $jsonData['contractDate'];

        $employeeService->update($employeeId, $employeeName, $contractDate);

        return JsonResponse::fromJsonString('Employee ' . $employeeName . ' was updated');
    }

    /**
     * @Route("/employee/{employeeId}",
     *     name="delete_employee",
     *     methods={"DELETE"})
     * @param EmployeeService $employeeService
     * @param $employeeId
     * @return JsonResponse
     */
    public function delete(EmployeeService $employeeService, $employeeId)
    {
        $employeeService->delete($employeeId);

        return JsonResponse::fromJsonString('Employee ' . $employeeId . ' was deleted');
    }

    /**
     * @Route("/employee/{employeeId}/company/{companyId}",
     *     name="post_employee_company",
     *     methods={"POST"})
     * @param Request $httpRequest
     * @param EmployeeService $employeeService
     * @param $employeeId
     * @param $companyId
     * @return JsonResponse
     * @throws \Exception
     */
    public function addCompany(EmployeeService $employeeService, $employeeId, $companyId)
    {
        if (!$employeeId) {
            throw new \Exception("employeeId required");
        }
        if (!$companyId) {
            throw new \Exception("companyId required");
        }

        $employeeService->addCompany($employeeId, $companyId);

        return JsonResponse::fromJsonString("Employee " . $employeeId . " was associated with company " . $companyId);
    }
}
