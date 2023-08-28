<?php

namespace TravelApp\Controllers;

use TravelApp\Models\Traveler;
use TravelApp\Base\Response;

class TravelerController extends BaseController {

    /**
     * Получение списка всех путешественников.
     *
     * @return Response
     */
    public function index(): Response {
        $travelerModel = new Traveler();

        $order = $_GET['order'] ?? 'asc';
        $field = $_GET['field'] ?? 'id';

        $travelers = $travelerModel->all(e($order), e($field));

        if ($travelers) {
            return response(200, $travelers);
        } else {
            return response(404, "Путешественников не найдено");
        }
    }

    /**
     * Получение информации о конкретном путешественнике по ID.
     *
     * @param int $id
     * @return Response
     */
    public function get(array $routeParams): Response {
        $id = $routeParams['id'];

        $travelerModel = new Traveler();
        $traveler = $travelerModel->find($id);

        if ($traveler) {
            return response(200, $traveler);
        } else {
            return response(404, "Путешественник не найден");
        }
    }

    /**
     * Создание нового путешественника.
     *
     * @param array $data
     * @return Response
     */
    public function post(array $data): Response {
        $travelerModel = new Traveler();

        foreach ($data as $property => $value) {
            if (property_exists($travelerModel, $property)) {
                $travelerModel->{$property} = $value;
            }
        }

        if ($travelerModel->save()) {
            return response(201, "Путешественник создан");
        } else {
            return response(500, "Ошибка при создании путешественника");
        }
    }

    /**
     * Обновление путешественника по ID.
     *
     * @param array $routeParams
     * @param array $data
     * @return Response
     */
    public function put(array $routeParams, array $data): Response {
        $id = $routeParams['id'];

        $travelerModel = new Traveler();
        $existingTraveler = $travelerModel->find($id);

        if (!$existingTraveler) {
            return response(404, "Путешественник не найден");
        }

        foreach ($data as $property => $value) {
            if (property_exists($travelerModel, $property)) {
                $existingTraveler->{$property} = $value;
            }
        }

        if ($existingTraveler->update()) {
            return response(200, "Путешественник обновлён");
        } else {
            return response(500, "Ошибка при обновлении путешественника");
        }
    }

    /**
     * Удаление путешественника по ID.
     *
     * @param array $routeParams
     * @return Response
     */
    public function delete(array $routeParams): Response {
        $id = $routeParams['id'];

        $travelerModel = new Traveler();
        $existingTraveler = $travelerModel->find($id);

        if (!$existingTraveler) {
            return response(404, "Путешественник не найден");
        }

        if ($existingTraveler->delete()) {
            return response(200, "Путешественник удалён");
        } else {
            return response(500, "Ошибка при удалении путешественника");
        }
    }

    /**
     * Получение списка городов, посещенных путешественником по ID путешественника.
     *
     * @param array $routeParams
     * @return Response
     */
    public function getVisitedCities(array $routeParams): Response {
        $travelerId = $routeParams['id'];

        $travelerModel = new Traveler();
        $traveler = $travelerModel->find($travelerId);

        if (!$traveler) {
            return response(404, "Путешественник не найден");
        }

        $visitedCities = $traveler->getVisitedCities();

        if ($visitedCities) {
            return response(200, $visitedCities);
        } else {
            return response(404, "Посещенные города не найдены");
        }
    }

    /**
     * Получение всех отзывов от путешественника.
     *
     * @param array $routeParams
     * @return Response
     */
    public function getAllReviewsByTraveler(array $routeParams): Response {
        $travelerId = $routeParams['id'];

        $travelerModel = new Traveler();
        $traveler = $travelerModel->find($travelerId);

        if (!$traveler) {
            return response(404, "Путешественник не найден");
        }

        $reviews = $traveler->getAllReviews($travelerId);

        if ($reviews) {
            return response(200, $reviews);
        } else {
            return response(404, "Отзывы не найдены");
        }
    }
}

?>