<?php

namespace App\Controller;

use App\Exception\EmployeeNotExistException;
use App\Service\EmployeeService;
use Assert\Assertion;
use Assert\AssertionFailedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Employee;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;

class EmployeeController extends BaseController
{
    /**
     * @var EmployeeService
     */
    private $employeeService;

    /**
     * EmployeeController constructor.
     * @param EmployeeService $employeeService
     */
    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Create a new employee
     * @SWG\Response(
     *     response=200,
     *     description="New employee created",
     *     @Model(type=Employee::class, groups={"non_sensitive_data"})
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Missing parameters",
     *     examples={"name parameter is mandatory."}
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
     *     description="Name for new Employee"
     * )
     * @SWG\Parameter(
     *     name="hiringDate",
     *     in="query",
     *     type="string",
     *     description="Hiring date of the employee"
     * )
     * @Route("/employee", name="create_employee", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function create(Request $request)
    {
        $name = $request->get('name');
        $hiringDate = $request->get('hiringDate');
        try {
            Assertion::notEmpty($name, '"name" parameter is mandatory.');
            Assertion::notEmpty($hiringDate, '"hiringDate" parameter is mandatory.');
            Assertion::date($hiringDate, 'Y-m-d H:i:s', '"hiringDate" needs specific format: "Y-m-d H:i:s".');
            $employee = $this->employeeService->createEmployee($name, \DateTime::createFromFormat('Y-m-d H:i:s', $hiringDate));
        } catch (AssertionFailedException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new Response('Had problem to save entity, try again.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($employee);
    }

    /**
     * Update an employee
     * @SWG\Response(
     *     response=200,
     *     description="Employee updated",
     *     @Model(type=Employee::class, groups={"non_sensitive_data"})
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Missing parameters",
     *     examples={"name parameter is mandatory."}
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
     *     description="Name for new Employee"
     * )
     * @SWG\Parameter(
     *     name="hiringDate",
     *     in="query",
     *     type="string",
     *     description="Hiring date of the employee"
     * )
     * @Route("/employee/{id}", name="update_employee", methods={"PUT"})
     * @param Request $request
     * @param string $id
     * @return JsonResponse|Response
     */
    public function update(Request $request, string $id)
    {
        $name = $request->get('name');
        $hiringDate = $request->get('hiringDate');
        try {
            Assertion::notEmpty($name, '"name" parameter is mandatory.');
            Assertion::notEmpty($hiringDate, '"hiringDate" parameter is mandatory.');
            Assertion::date($hiringDate, 'Y-m-d H:i:s', '"hiringDate" needs specific format: "Y-m-d H:i:s".');
            $employee = $this->employeeService->updateEmployee($id, $name, $hiringDate);
        } catch (AssertionFailedException $e) {
            return new Response('"name" and "hiringDate" parameters are mandatory', Response::HTTP_BAD_REQUEST);
        } catch (EmployeeNotExistException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new Response('Had problem to save entity, try again.', Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse($employee);
    }

    /**
     * Delete an employee
     * @SWG\Response(
     *     response=200,
     *     description="Employee deleted",
     *     examples={"Employee deleted"}
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Error in parameters",
     *     examples={"Employee with ID not exist."}
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
     *     description="Name for new Employee"
     * )
     * @SWG\Parameter(
     *     name="hiringDate",
     *     in="query",
     *     type="string",
     *     description="Hiring date of the employee"
     * )
     * @Route("/employee/{id}", name="delete_employee", methods={"DELETE"})
     * @param string $id
     * @return JsonResponse|Response
     */
    public function delete(string $id)
    {
        try {
            $this->employeeService->removeEmployee($id);
            return new Response('Employee deleted.');
        } catch (EmployeeNotExistException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new Response('Had problem to remove entity, try again.');
        }
    }
}
