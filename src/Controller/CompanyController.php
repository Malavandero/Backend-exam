<?php

namespace App\Controller;

use App\Exception\EmployeeNotCompatibleWithCompanyException;
use App\Service\CompanyService;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Company;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class CompanyController extends BaseController
{

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * CompanyController constructor.
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Create a new company
     * @SWG\Response(
     *     response=200,
     *     description="New company created",
     *     @Model(type=Company::class, groups={"non_sensitive_data"})
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Missing parameters",
     *     examples={"name parameter is mandatory"}
     * )
     * @SWG\Response(
     *     response=500,
     *     description="System Error",
     *     examples={"Had problem to save entity, try again"}
     * )
     * @SWG\Parameter(
     *     name="name",
     *     in="query",
     *     type="string",
     *     description="Name for new "
     * )
     * @Route("company", name="create_company", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function create(Request $request)
    {
        try {
            $name = $request->get('name');
            Assertion::notEmpty($name, '"name" parameter is mandatory.');
            $company = $this->companyService->createCompany($name);
        } catch (AssertionFailedException $e) {
            return new Response('"name" parameter is mandatory', Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new Response('Had problem to save entity, try again.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse($company);
    }

    /**
     * Add employee to a company
     *
     * @SWG\Response(
     *     response=200,
     *     description="Add employee to the a company",
     *     @Model(type=Company::class, groups={"non_sensitive_data"})
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Problem with data sent",
     *     examples={"Employee Not compatible with Company", "Missing Parameters"}
     * )

     * @SWG\Response(
     *     response=500,
     *     description="System Error",
     * )
     * @Route("/company/{companyId}/employee/{employeeId}", name="add_employee_to_company", methods={"PUT"})
     * @param string $companyId
     * @param string $employeeId
     * @return Response
     */
    public function addEmployee(string $companyId, string $employeeId)
    {
        try{
            $company = $this->companyService->addEmployeeToCompany($employeeId, $companyId);
        } catch (AssertionFailedException $e) {
            return new Response('"companyId" or "employeeId" parameter is mandatory', Response::HTTP_BAD_REQUEST);
        } catch (EmployeeNotCompatibleWithCompanyException $e){
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e){
            return new Response('Had problem to save entity, try again.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return new JsonResponse($company);
    }
}
