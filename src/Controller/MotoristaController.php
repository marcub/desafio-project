<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Motorista;
use App\Entity\Cnh;
use App\Repository\MotoristaRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/motoristas', name: 'motorista_')]
class MotoristaController extends AbstractController
{

    private $motoristaRepository;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, MotoristaRepository $motoristaRepository)
    {
        $this->motoristaRepository = $motoristaRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'getMotoristas', methods: ['GET'])]
    public function getMotoristas(): Response
    {
        $motoristas = $this->motoristaRepository->findAll();
        return $this->json($motoristas, Response::HTTP_OK, [], ['groups' => 'motorista']);
    }

    #[Route('/{id}', name: 'getMotoristaById', methods: ['GET'])]
    public function getMotoristaById(Motorista $motorista): Response
    {
        return $this->json($motorista, Response::HTTP_OK, [], ['groups' => 'motorista']);
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $data = $request->getContentTypeFormat() === 'json' ? json_decode($request->getContent(), true) : $request->request->all();

        $timezone = new \DateTimeZone('America/Sao_Paulo');

        $motorista = new Motorista();
        $motorista->setNome($data['nome']);
        $motorista->setCpf($data['cpf']);
        $motorista->setRg($data['rg']);

        $cnh = new Cnh();
        $cnh->setNumero($data['cnh']);
        $cnh->setValidade(new \DateTime($data['validade'], $timezone));
        $cnh->setCategoria($data['categoria']);

        $motorista->setCnh($cnh);
        $motorista->setDataNascimento(new \DateTime($data['dataNascimento'], $timezone));
        $motorista->setCreatedAt(new \DateTimeImmutable('now', $timezone));
        $motorista->setUpdatedAt(new \DateTimeImmutable('now', $timezone));

        $this->entityManager->getConnection()->beginTransaction();

        try {
            $this->entityManager->persist($cnh);
            $this->entityManager->persist($motorista);
            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $this->json($motorista, Response::HTTP_CREATED, [], ['groups' => 'motorista']);
    }

    #[Route('/update/{id}', name: 'update', methods: ['PUT'])]
    public function update(Motorista $motorista, Request $request): Response
    {
        $timezone = new \DateTimeZone('America/Sao_Paulo');

        if(!$motorista) {
            throw $this->createNotFoundException();
        }

        $motorista->setNome($request->get('nome'));
        $motorista->setCpf($request->get('cpf'));
        $motorista->setRg($request->get('rg'));
        $motorista->getCnh()->setNumero($request->get('cnh'));
        $motorista->getCnh()->setValidade(new \DateTime($request->get('validade'), $timezone));
        $motorista->getCnh()->setCategoria($request->get('categoria'));
        $motorista->setDataNascimento(new \DateTime($request->get('dataNascimento'), $timezone));
        $motorista->setUpdatedAt(new \DateTimeImmutable('now', $timezone));

        $this->entityManager->getConnection()->beginTransaction();

        try {

            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $this->json($motorista, Response::HTTP_CREATED, [], ['groups' => 'motorista']);
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['DELETE'])]
    public function remove(Motorista $motorista): Response
    {

        if(!$motorista) {
            throw $this->createNotFoundException();
        }

        $this->entityManager->getConnection()->beginTransaction();

        try {

            $this->entityManager->remove($motorista);
            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (\Exception $e) {
            $this->entityManager->rollback();
            throw $e;
        }

        return $this->json(['message' => "Motorista deletado com sucesso"], Response::HTTP_OK, [], []);
    }
}
