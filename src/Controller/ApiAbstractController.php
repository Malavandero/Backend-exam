<?php

namespace App\Controller;
use App\Domain\Company\CompanyNotExists;
use App\Domain\Company\EmployeeCanNotBelongToCompany;
use App\Domain\Employee\EmployeeNotExists;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

class ApiAbstractController extends AbstractController
{
    protected $serializer;


    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param $content
     * @param array $keys
     * @return array
     * @throws Exception
     */
    protected function ensureJsonBodyAndKeysExists($content, array $keys): array
    {
        $jsonData = json_decode($content, true);
        if (!$jsonData) {
            throw new Exception('missing json body', Response::HTTP_BAD_REQUEST);
        }
        foreach ($keys as $key) {
            if (!array_key_exists($key, $jsonData)) {
                throw new Exception("Missing Argument: $key", Response::HTTP_BAD_REQUEST);
            }
        }
        return $jsonData;
    }

    /**
     * @param Exception $e
     * @return JsonResponse
     */
    protected function returnJsonErrorResponse(Exception $e):JsonResponse
    {
        $codes = [Response::HTTP_BAD_REQUEST, Response::HTTP_NOT_FOUND];
        $data = $this->serializer->serialize(['error'=> $e->getMessage()], 'json', ['groups' => 'error'] );

        if ($e instanceof EmployeeNotExists){
            return JsonResponse::fromJsonString($data, Response::HTTP_NOT_FOUND);
        }
        if ($e instanceof CompanyNotExists){
            return JsonResponse::fromJsonString($data, Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof EmployeeCanNotBelongToCompany){
            return JsonResponse::fromJsonString($data, Response::HTTP_BAD_REQUEST);
        }

        if (!$e->getCode() || ! in_array($e->getCode(), $codes, false) ){
            $returnCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        } else {
            $returnCode = $e->getCode();
        }

        return JsonResponse::fromJsonString($data, $returnCode);
    }
}