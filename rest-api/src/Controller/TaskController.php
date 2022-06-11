<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Laminas\Code\Generator\DocBlock\Tag;

/**
 * @Route("/api", name="api_")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="get_all_tasks", methods={"GET"})
     */
    public function get_all_tasks(ManagerRegistry $doctrine): JsonResponse
    {
       $tasks = $doctrine
            ->getRepository(Task::class)
            ->findAll();

        $data = [
            'status' => 'success',
            'code' => 200,
            'tasks' => $tasks
        ];
        return $this->json($data);
    }

    /**
     * @Route("/task", name="task_new", methods={"POST"})
     */
    public function new(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
 
        $task = new Task();
        $task->setTitle($request->request->get('title'));
        $task->setDone($request->request->get('done'));
        $task->setCreatedData(new DateTime());
        $task->setUpdatedData(new DateTime());
 
        $entityManager->persist($task);
        $entityManager->flush();
 
        $data = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Created new task successfully',
            'task' => $task
        ];
        return $this->json($data);
    }
 
    /**
     * @Route("/task/{id}", name="task_show", methods={"GET"})
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $task = $doctrine
            ->getRepository(Task::class)
            ->find($id);
 
        if (!$task) {
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'No task found for id ' . $id
            ];
            return $this->json($data);
        }
         
        $data = [
            'status' => 'success',
            'code' => 200,
            'task' => $task
        ];
        return $this->json($data);
    }
 
    /**
     * @Route("/task/{id}", name="task_edit", methods={"PUT"})
     */
    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
 
        if (!$task) {
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'No task found for id ' . $id
            ];
            return $this->json($data);
        }
 
        $task->setTitle($request->request->get('title'));
        $task->setDone($request->request->get('done'));
        $task->setUpdatedData(new DateTime());
        $entityManager->flush();
         
        $data = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Task updated successfully',
            'task' => $task
        ];
        return $this->json($data);
    }
 
    /**
     * @Route("/task/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $task = $entityManager->getRepository(Task::class)->find($id);
 
        if (!$task) {
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'No task found for id ' . $id
            ];
            return $this->json($data);
        }
 
        $entityManager->remove($task);
        $entityManager->flush();
 
        $data = [
            'status' => 'success',
            'code' => 200,
            'message' => 'Deleted a task successfully with id ' . $id
        ];
        return $this->json($data);
    }
}
