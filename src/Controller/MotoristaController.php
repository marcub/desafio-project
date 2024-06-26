<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Motorista;
use App\Entity\Cnh;
use App\Repository\MotoristaRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    #[Route('/page', name: 'getMotoristasByPage', methods: ['GET'])]
    public function getMotoristasByPage(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = $request->query->getInt('pageSize', 20);
        $searchNome = $request->query->get('nome');
        $searchCategoria = $request->query->get('categoria');
        $searchStartDate = $request->query->get('startDate');
        $searchEndDate = $request->query->get('endDate');

        $query = $this->entityManager->createQueryBuilder();
        $query->select('m')
                ->from('App\Entity\Motorista', 'm')
                ->innerJoin("m.cnh", "c", "m.cnh = c.id")
                ->orderBy('m.id', 'DESC')
                ->setFirstResult(($page - 1) * $pageSize)
                ->setMaxResults($pageSize)
                ->getQuery();

        if (!empty($searchNome)) {
            $query->andWhere("UPPER(m.nome) LIKE :nome")
                ->setParameter('nome', '%' . strtoupper($searchNome) . '%');
        }
        
        if (!empty($searchStartDate)) {
            $query->andWhere("m.dataNascimento >= :startDate")
                ->setParameter('startDate', $searchStartDate);
        }

        if (!empty($searchEndDate)) {
            $query->andWhere("m.dataNascimento <= :endDate")
                ->setParameter('endDate', $searchEndDate);
        }
        
        if (!empty($searchCategoria)) {
            $query->andWhere("c.categoria = :categoria")
                ->setParameter('categoria', $searchCategoria);
        }

        $paginator = new Paginator($query);

        $motoristas = [];

        foreach ($paginator as $motorista) {
            $motoristas[] = $motorista;
        }

        $totalMotoristas = count($paginator);
        $totalPages = ceil($totalMotoristas / $pageSize);

        return $this->json([
            'totalItems' => $totalMotoristas,
            'motoristas' => $motoristas,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ], Response::HTTP_OK, [], ['groups' => 'motorista']);
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
        $data = $request->getContentTypeFormat() === 'json' ? json_decode($request->getContent(), true) : $request->request->all();

        $timezone = new \DateTimeZone('America/Sao_Paulo');

        if(!$motorista) {
            throw $this->createNotFoundException();
        }

        $motorista->setNome($data['nome']);
        $motorista->setCpf($data['cpf']);
        $motorista->setRg($data['rg']);
        $motorista->getCnh()->setNumero($data['cnh']['numero']);
        $motorista->getCnh()->setValidade(new \DateTime($data['cnh']['validade'], $timezone));
        $motorista->getCnh()->setCategoria($data['cnh']['categoria']);
        $motorista->setDataNascimento(new \DateTime($data['dataNascimento'], $timezone));
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
