<?php

namespace App\Controller;

use App\Entity\Veiculo;
use App\Repository\VeiculoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/veiculos', name: 'veiculo_')]
class VeiculoController extends AbstractController
{
    private $veiculoRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, VeiculoRepository $veiculoRepository)
    {
        $this->veiculoRepository = $veiculoRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'getVeiculos', methods: ['GET'])]
    public function index(): Response
    {
        $veiculos = $this->veiculoRepository->findAll();
        return $this->json($veiculos, Response::HTTP_OK, [], ['groups' => 'veiculo']);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = $request->getContentTypeFormat() === 'json' ? json_decode($request->getContent(), true) : $request->request->all();

        $timezone = new \DateTimeZone('America/Sao_Paulo');

        $veiculo = new Veiculo();
        $veiculo->setCrlv($data['crlv']);
        $veiculo->setNomeDoProprietario($data['nomeProprietario']);
        $veiculo->setTipo($data['tipo']);
        $veiculo->setCreatedAt(new \DateTimeImmutable('now', $timezone));
        $veiculo->setUpdatedAt(new \DateTimeImmutable('now', $timezone));

        $this->entityManager->getConnection()->beginTransaction();

        try {

            $this->entityManager->persist($veiculo);
            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $this->json($veiculo, Response::HTTP_CREATED, [], ['groups' => 'veiculo']);
    }

    #[Route('/update/{id}', name: 'update', methods: ['PUT'])]
    public function update(Veiculo $veiculo, Request $request): Response
    {
        $timezone = new \DateTimeZone('America/Sao_Paulo');

        if(!$veiculo) {
            throw $this->createNotFoundException();
        }

        $veiculo->setCrlv($request->get('crlv'));
        $veiculo->setNomeDoProprietario($request->get('nomeProprietario'));
        $veiculo->setTipo($request->get('tipo'));
        $veiculo->setUpdatedAt(new \DateTimeImmutable('now', $timezone));

        $this->entityManager->getConnection()->beginTransaction();

        try {

            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $this->json($veiculo, Response::HTTP_CREATED, [], ['groups' => 'veiculo']);
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['DELETE'])]
    public function remove(Veiculo $veiculo): Response
    {

        if(!$veiculo) {
            throw $this->createNotFoundException();
        }

        $this->entityManager->getConnection()->beginTransaction();

        try {

            $this->entityManager->remove($veiculo);
            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $this->json(['message' => "Veículo deletado com sucesso"], Response::HTTP_OK, [], []);
    }
}
