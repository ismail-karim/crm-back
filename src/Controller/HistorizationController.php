<?php

namespace App\Controller;

use App\Entity\Historization;
use App\Entity\Type;
use App\Repository\HistorizationRepository;
use App\Repository\SubtypeRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

class HistorizationController extends AbstractController
{

    #[Route('api/v1/getHistorization', name: 'historization_get', methods: ['GET'])]
    public function getHistorizations(HistorizationRepository $repository, SerializerInterface $serializer): JsonResponse
    {

        $historizationRepo = $repository->findAll();
        $result = $serializer->serialize($historizationRepo, 'json', ['groups'=>'historization']);
        return new JsonResponse($result, Response::HTTP_OK, [], true);
    }

    #[Route('/api/v1/createHistorization', name: 'historization_create', methods: ['POST'])]
    public function createHistorization(Request $request, TypeRepository $repositoryType, SubtypeRepository $repositorySubtype ,EntityManagerInterface $entityManager)
    {
        $historization = new Historization();
        $typeArray = $repositoryType->findTypeByName($request->get('type'));
        $type = $typeArray[0];
        $subtypeArray = $repositorySubtype->findOneByNameAndTypeId($request->get('subtype'), $type->getId());
        dd($subtypeArray);
        $historization->setDate($request->get('date'));
        $historization->setComment($request->get('comment'));
        $historization->setType($type->getId());
        $historization->setType($request->get('subtype'));
        $historization->addFile($request->get('files'));
        $entityManager->persist($historization);
        $entityManager->flush();

        return new JsonResponse('historization created', 200, [], true);
    }
}
