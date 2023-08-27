<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): JsonResponse
    {
        return $this->json($entityManager->getRepository(Project::class)->findAll());
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        $this->verifyProjectExists($project, $id);

        return $this->json($project);
    }

    #[Route('/', name: 'app_project_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent());

        $project = new Project();

        $project->setName($data->name);
        $project->setDescription($data->description);
        $project->setStartDate(new \DateTime($data->startDate, new \DateTimeZone('America/Sao_Paulo')));
        $project->setEndDate(new \DateTime($data->endDate, new \DateTimeZone('America/Sao_Paulo')));

        $errors = $validator->validate($project);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return $this->json([
                'errors' => $errorsString
            ], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($project);
        $entityManager->flush();

        return $this->json($project, Response::HTTP_CREATED);
    }

    #[Route('/', name: 'app_project_update', methods: ['PUT'])]
    public function update(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent());
        $project = $entityManager->getRepository(Project::class)->find($data->id);

        $this->verifyProjectExists($project, $data->id);

        $project->setName($data->name);
        $project->setDescription($data->description);
        $project->setStartDate(new \DateTime($data->startDate, new \DateTimeZone('America/Sao_Paulo')));
        $project->setEndDate(new \DateTime($data->endDate, new \DateTimeZone('America/Sao_Paulo')));

        $entityManager->flush();

        return $this->json($project);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['DELETE'])]
    public function delete(int $id, EntityManagerInterface $entityManager) : JsonResponse
    {
        $project = $entityManager->getRepository(Project::class)->find($id);

        $this->verifyProjectExists($project, $id);

        $entityManager->remove($project);
        $entityManager->flush();

        return $this->json([
            'message' => 'Project deleted'
        ], Response::HTTP_NO_CONTENT);
    }

    private function verifyProjectExists(Project $project = null, int $id)
    {
        if(!$project) {
            throw new NotFoundHttpException('No project found for id ' . $id);
        }
    }

}
