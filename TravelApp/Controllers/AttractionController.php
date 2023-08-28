<?php

namespace TravelApp\Controllers;

use TravelApp\Models\Attraction;
use TravelApp\Base\Response;

class AttractionController extends BaseController {

    /**
     * Получение списка всех достопримечательностей.
     *
     * @return Response
     */
    public function index(): Response {
        $order = $_GET['order'] ?? 'asc';
        $field = $_GET['field'] ?? 'id';

        $attractionModel = new Attraction(); 
        $attractions = $attractionModel->all(e($order), e($field));

        if ($attractions) {
            return response(200, $attractions);
        } else {
            return response(404, "Достопримечательности не найдены");
        }
    }

    /**
     * Получение информации о конкретной достопримечательности по ID.
     *
     * @param array $routeParams
     * @return Response
     */
    public function get(array $routeParams): Response {
        $id = $routeParams['id'];

        $attractionModel = new Attraction();
        $attraction = $attractionModel->find($id);

        if ($attraction) {
            return response(200, $attraction);
        } else {
            return response(404, "Достопримечательность не найдена");
        }
    }

    /**
     * Создание новой достопримечательности.
     *
     * @param array $routeParams
     * @param array $postData
     * @return Response
     */
    public function post(array $routeParams, array $postData): Response {
        $attractionModel = new Attraction();

        foreach ($postData as $property => $value) {
            if (property_exists($attractionModel, $property)) {
                $attractionModel->{$property} = $value;
            }
        }

        if ($attractionModel->save()) {
            return response(201, "Достопримечательность создана");
        } else {
            return response(500, "Ошибка при создании достопримечательности");
        }
    }

    /**
     * Обновление достопримечательности по ID.
     *
     * @param array $routeParams
     * @param array $postData
     * @return Response
     */
    public function put(array $routeParams, array $postData): Response {
        $id = $routeParams['id'];

        $attractionModel = new Attraction(); 
        $existingAttraction = $attractionModel->find($id);

        if (!$existingAttraction) {
            return response(404, "Достопримечательность не найден");
        }

        foreach ($postData as $property => $value) {
            if (property_exists($attractionModel, $property)) {
                $existingAttraction->{$property} = $value;
            }
        }

        if ($existingAttraction->update()) {
            return response(200, "Достопримечательность обновлёна");
        } else {
            return response(500, "Ошибка при обновлении достопримечательности");
        }
    }

    /**
     * Удаление достопримечательности по ID.
     *
     * @param array $routeParams
     * @return Response
     */
    public function delete(array $routeParams): Response {
        $id = $routeParams['id'];

        $attractionModel = new Attraction();
        $existingAttraction = $attractionModel->find($id);

        if (!$existingAttraction) {
            return response(404, "Достопримечательность не найден");
        }

        if ($existingAttraction->delete()) {
            return response(200, "Город удалён");
        } else {
            return response(500, "Ошибка при удалении достопримечательности");
        }
    }
}

?>