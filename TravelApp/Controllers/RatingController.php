<?php

namespace TravelApp\Controllers;

use TravelApp\Models\Rating;
use TravelApp\Base\Response;

class RatingController extends BaseController {

    /**
     * Получение списка всех отзывов.
     *
     * @return Response
     */
    public function index(): Response {
        $ratingModel = new Rating();

        $order = $_GET['order'] ?? 'asc';
        $field = $_GET['field'] ?? 'id';

        $ratings = $ratingModel->all(e($order), e($field));

        if ($ratings) {
            return response(200, $ratings);
        } else {
            return response(404, "Отзывов не найдено");
        }
    }

    /**
     * Получение конкретного отзыва по ID.
     *
     * @param array $routeParams
     * @return Response
     */
    public function get(array $routeParams): Response {
        $id = $routeParams['id'];

        $ratingModel = new Rating();
        $rating = $ratingModel->find($id);

        if ($rating) {
            return response(200, $rating);
        } else {
            return response(404, "Отзыв не найден");
        }
    }

    /**
     * Создание нового отзыва.
     *
     * @param array $data
     * @return Response
     */
    public function post(array $data): Response {
        $ratingModel = new Rating();

        foreach ($data as $property => $value) {
            if (property_exists($ratingModel, $property)) {
                $ratingModel->{$property} = $value;
            }
        }

        if ($ratingModel->save()) {
            return response(201, "Отзыв создан");
        } else {
            return response(500, "Ошибка при создании отзыва");
        }
    }

    /**
     * Обновление отзыва по ID.
     *
     * @param array $routeParams
     * @param array $data
     * @return Response
     */
    public function put(array $routeParams, array $data): Response {
        $id = $routeParams['id'];

        $ratingModel = new Rating();
        $existingRating = $ratingModel->find($id);

        if (!$existingRating) {
            return response(404, "Отзыв не найден");
        }

        foreach ($data as $property => $value) {
            if (property_exists($ratingModel, $property)) {
                $existingRating->{$property} = $value;
            }
        }

        if ($existingRating->update()) {
            return response(200, "Отзыв обновлён");
        } else {
            return response(500, "Ошибка при обновлении отзыва");
        }
    }

    /**
     * Удаление отзыва по ID.
     *
     * @param array $routeParams
     * @return Response
     */
    public function delete(array $routeParams): Response {
        $ratingModel = new Rating();
        $existingRating = $ratingModel->find($id);

        if (!$existingRating) {
            return response(404, "Отзыв не найден");
        }

        if ($existingRating->delete()) {
            return response(200, "Отзыв удалён");
        } else {
            return response(500, "Ошибка при удалении отзыва");
        }
    }

}

?>