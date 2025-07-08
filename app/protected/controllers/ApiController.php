<?php

class ApiController extends Controller
{
    public function actionList()
    {
        $tasks = Task::model()->findAll();
        $result = [];

        foreach ($tasks as $task) {
            $result[] = [
                'id' => $task->id,
                'title' => $task->title,
                'is_done' => (bool)$task->is_done,
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        Yii::app()->end();
    }

    public function actionCreate()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);

        if (!isset($data['title']) || trim($data['title']) === '') {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode(['error' => 'Заполните текст задачи.']);
            Yii::app()->end();
        }

        $task = new Task();
        $task->title = trim($data['title']);
        $task->is_done = 0;

        if ($task->validate() && $task->save()) {
            header('Content-Type: application/json');
            echo json_encode([
                'id' => $task->id,
                'title' => $task->title,
                'is_done' => false,
            ]);
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                'error' => 'Ошибка валидации',
                'details' => $task->getErrors(),
            ]);
        }

        Yii::app()->end();
    }

    public function actionUpdate($id)
    {
        $task = Task::model()->findByPk($id);
        if (!$task) {
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Задача ненайдена']);
            Yii::app()->end();
        }

        $task->is_done = 1;

        if ($task->save()) {
            header('Content-Type: application/json');
            echo json_encode([
                'id' => $task->id,
                'title' => $task->title,
                'is_done' => (bool)$task->is_done,
            ]);
        } else {
            header('HTTP/1.1 400 Bad Request');
            echo json_encode([
                'error' => 'Ошибка обновления задачи',
                'details' => $task->getErrors(),
            ]);
        }

        Yii::app()->end();
    }
}
