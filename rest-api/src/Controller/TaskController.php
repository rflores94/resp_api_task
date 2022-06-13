<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Task;
use DateTime;
use Doctrine\Common\Collections\Expr\Value;
use Doctrine\Persistence\ManagerRegistry;
use Laminas\Code\Generator\DocBlock\Tag;

const file_database = '../bd.json';

/**
 * @Route("/api", name="api_")
 */
class TaskController extends AbstractController
{

    public $max_id = 0;

    /**
     * @Route("/tasks", name="get_all_tasks", methods={"GET"})
     */
    public function get_all_tasks(): JsonResponse
    {
        $this->exist_database();
        $tasks = file_get_contents(file_database);
        $array = json_decode($tasks);
        $data = [
            'status' => 'success',
            'code' => 200,
            'tasks' => $array
        ];
        return $this->json($data);
    }

    /**
     * @Route("/task", name="task_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $this->exist_database();

        $tasks = file_get_contents(file_database);
        $array = json_decode($tasks);

        foreach ($array as $key => $value) {
            if ($value->id > $this->max_id)
                $this->max_id = $value->id;
        }

        if (trim(strtolower($request->request->get('done'))) != "true" && trim(strtolower($request->request->get('done'))) != "false") {
            $data = [
                'status' => 'error',
                'code' => 404,
                'message' => 'Done not is boolean value',
            ];
            return $this->json($data);
        }

        $task = new Task();
        $task->setId($this->max_id + 1);
        $task->setTitle($request->request->get('title'));
        if (trim(strtolower($request->request->get('done'))) == "true")
            $task->setDone(true);
        else
            $task->setDone(false);
        $task->setCreatedData(new DateTime());
        $task->setUpdatedData(new DateTime());
        $array[] = $task;

        file_put_contents(file_database, json_encode($array));


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
    public function show(int $id): Response
    {
        $this->exist_database();

        $tasks = file_get_contents(file_database);
        $array = json_decode($tasks);

        foreach ($array as $key => $value) {
            if ($value->id == $id) {
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'task' => $value
                ];
                return $this->json($data);
            }
        }

        $data = [
            'status' => 'error',
            'code' => 404,
            'message' => 'No task found for id ' . $id
        ];
        return $this->json($data);
    }

    /**
     * @Route("/task/{id}", name="task_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $this->exist_database();

        $tasks = file_get_contents(file_database);
        $array = json_decode($tasks);

        foreach ($array as $key => $value) {
            if ($value->id == $id) {

                if (trim(strtolower($request->request->get('done'))) != "true" && trim(strtolower($request->request->get('done'))) != "false") {
                    $data = [
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'Done not is boolean value',
                    ];
                    return $this->json($data);
                }
                $value->title = $request->request->get('title');
                if (trim(strtolower($request->request->get('done'))) == "true")
                    $value->done = true;
                else
                    $value->done = false;
                $value->updated_data = new DateTime();
                file_put_contents(file_database, json_encode($array));
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Task updated successfully',
                    'task' => $value
                ];
                return $this->json($data);
            }
        }

        $data = [
            'status' => 'error',
            'code' => 404,
            'message' => 'No task found for id ' . $id
        ];
        return $this->json($data);
    }

    /**
     * @Route("/task/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(int $id): Response
    {
        $this->exist_database();

        $tasks = file_get_contents(file_database);
        $array = json_decode($tasks);

        foreach ($array as $key => $value) {
            if ($value->id == $id) {
                unset($array[$key]);
                file_put_contents(file_database, json_encode($array));
                $data = [
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Deleted a task successfully with id ' . $id
                ];
                return $this->json($data);
            }
        }

        $data = [
            'status' => 'error',
            'code' => 404,
            'message' => 'No task found for id ' . $id
        ];
        return $this->json($data);
    }

    private function exist_database()
    {
        if (!file_exists(file_database))
            file_put_contents(file_database, '[]');
    }
}
