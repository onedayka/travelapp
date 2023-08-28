<?php

namespace TravelApp\Controllers;

use TravelApp\Models\City;
use TravelApp\Base\Response;

class CityController extends BaseController {

    /**
     * Получение списка всех городов.
     *
     * @return Response
     */
    public function index(): Response {
        $cityModel = new City();

        $order = $_GET['order'] ?? 'asc';
        $field = $_GET['field'] ?? 'id';

        $cities = $cityModel->all(e($order), e($field));

        if ($cities) {
            return response(200, $cities);
        } else {
            return response(404, "Города не найдены");
        }
    }

    /**
     * Получение информации о конкретном городе по ID.
     *
     * @param int $id
     * @return Response
     */
    public function get(array $routeParams): Response {
        $id = $routeParams['id'];

        $cityModel = new City();
        $city = $cityModel->find($id);

        if ($city) {
            return response(200, $city);
        } else {
            return response(404, "Город не найден");
        }
    }

    /**
     * Создание нового города.
     *
     * @param array $data
     * @return Response
     */
    public function post(array $routeParams, array $postData): Response {

        $cityModel = new City();

        foreach ($postData as $property => $value) {
            if (property_exists($cityModel, $property)) {
                $cityModel->{$property} = $value;
            }
        }

        if ($cityModel->save()) {
            return response(201, "Город создан");
        } else {
            return response(500, "Ошибка при создании города");
        }
    }

    /**
     * Обновление города по ID.
     *
     * @param array $routeParams
     * @param array $data
     * @return Response
     */
    public function put(array $routeParams, array $postData): Response {
        $id = $routeParams['id'];

        $cityModel = new City();
        $existingCity = $cityModel->find($id);

        if (!$existingCity) {
            return response(404, "Город не найден");
        }

        foreach ($postData as $property => $value) {
            if (property_exists($cityModel, $property)) {
                $existingCity->{$property} = $value;
            }
        }

        if ($existingCity->update()) {
            return response(200, "Город обновлён");
        } else {
            return response(500, "Ошибка при обновлении города");
        }
    }

    /**
     * Удаление города по ID.
     *
     * @param array $routeParams
     * @return Response
     */
    public function delete(array $routeParams): Response {
        $id = $routeParams['id'];

        $cityModel = new City();
        $existingCity = $cityModel->find($id);

        if (!$existingCity) {
            return response(404, "Город не найден");
        }

        if ($existingCity->delete()) {
            return response(200, "Город удалён");
        } else {
            return response(500, "Ошибка при удалении города");
        }
    }

    /**
     * Получение всех достопримечательностей города по ID города.
     *
     * @param array $routeParams
     * @return Response
     */
    public function getAttractions(array $routeParams): Response {
        $cityId = $routeParams['id'];

        $cityModel = new City();
        $city = $cityModel->find($cityId);

        if (!$city) {
            return response(404, "Город не найден");
        }

        $attractions = $city->getAttractions();

        if ($attractions) {
            return response(200, $attractions);
        } else {
            return response(404, "Достопримечательности не найдены");
        }
    }

    /**
     * Получение списка путешественников, побывавших в данном городе.
     *
     * @param array $routeParams
     * @return Response
     */
    public function getTravelersVisitedCity(array $routeParams): Response {
        $cityId = $routeParams['id'];

        $cityModel = new City();
        $travelers = $cityModel->getTravelersVisitedCity($cityId);

        if ($travelers) {
            return response(200, $travelers);
        } else {
            return response(404, "Путешественники не найдены");
        }
    }
}
?>