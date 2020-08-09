<?php

namespace App\Controller;

use App\Util\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class EmployeeController extends AbstractController
{
    /**
     * @Route("/employee", name="employee_index", methods={"GET"})
     */
    public function index(EmployeeService $employeeService)
    {
        return $this->json($employeeService->getAll());
    }
    /**
     * @Route("/employee", name="employee_new", methods={"POST"}),
     * 
     */
    public function new(Request $request, EmployeeService $employeeService)
    {
        $data = $request->getContent();
        $employeeService->create($data);

        return $this->json([]);
    }
    /**
     * @Route("/employee/{id}", name="employee_delete", methods={"DELETE"})
     */
    public function delete($id, EmployeeService $employeeService)
    {

        $employeeService->delete($id);
        return $this->json([]);
    }
    /**
     * @Route("/employee/{id}", name="employee_modify", methods={"PUT"})
     */
    public function modify($id, Request $request, EmployeeService $employeeService)
    {
        $data = $request->getContent();
        $employeeService->modify($id, $data);

        return $this->json([]);
    }
}

     

