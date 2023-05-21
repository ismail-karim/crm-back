<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManager;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TypeController extends AbstractController
{
    #[Route('/type', name: 'app_type')]
    public function index(): Response
    {
        return $this->render('type/index.html.twig', [
            'controller_name' => 'TypeController',
        ]);
    }

    #[Route('/api/v1/getTypes', name: 'type_getTypes', methods: ['GET'])]
    public function getTypes(SerializerInterface $serializer, TypeRepository $repository): JsonResponse
    {
        $types = $repository->findAll();
        $jsonTypes = $serializer->serialize($types, 'json',['groups'=>['types']]);
        return new  JsonResponse($jsonTypes, Response::HTTP_OK, [], true);
    }

    #[Route('/api/v1/getTypeById/{id}', name: 'type_getTypeByName', requirements: ['id'=>'\d+'], methods: ['GET'])]
    public function getTypeById($id, TypeRepository $repository, SerializerInterface $serializer):JsonResponse
    {
        $type = $repository->findTypeById($id);
        $jsonType = $serializer->serialize($type, 'json', ['groups'=>['types']]);
        return  new JsonResponse($jsonType, Response::HTTP_OK, [], true);
    }

    #[Route('api/v1/getSubtypes/{typeName}', name: 'type_getSubtypes',  methods: ['GET'])]
    public function getSubtypes()
    {

    }
}
