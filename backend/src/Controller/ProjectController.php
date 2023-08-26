<?php

namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): JsonResponse
    {
        return $this->json($projectRepository->findAll());
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(ProjectRepository $projectRepository, int $id): JsonResponse
    {
        $project = $projectRepository->find($id);

        if(!$project) {
            return $this->json([
                'error' => 'No project found for id ' . $id
            ], 404);
        }

        return $this->json($project);
    }

    #[Route('/', name: 'app_project_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = new Project();

        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));
        $project->setStartDate(new \DateTime($request->request->get('startDate'), new \DateTimeZone('America/Sao_Paulo')));
        $project->setEndDate(new \DateTime($request->request->get('endDate'), new \DateTimeZone('America/Sao_Paulo')));

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json($project);
    }

    #[Route('/', name: 'app_project_update', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($request->request->get('id'));

        if(!$project) {
            return $this->json([
                'error' => 'No project found for id ' . $request->request->get('id')
            ], 404);
        }

        $project->setName($request->request->get('name'));
        $project->setDescription($request->request->get('description'));
        $project->setStartDate(new \DateTime($request->request->get('startDate'), new \DateTimeZone('America/Sao_Paulo')));
        $project->setEndDate(new \DateTime($request->request->get('endDate'), new \DateTimeZone('America/Sao_Paulo')));

        $entityManager->flush();

        return $this->json($project);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $entityManager, int $id) : JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        if(!$project) {
            return $this->json([
                'error' => 'No project found for id ' . $id
            ], 404);
        }

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json([
            'message' => 'Project deleted'
        ], 204);
    }

}
