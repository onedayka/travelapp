<?php

/**
 * Модель для представления данных о путешественниках.
 * Используется для взаимодействия с таблицей "travelers" в базе данных.
 */

namespace TravelApp\Models;

use TravelApp\Base\BaseModel;
use TravelApp\Models\Field;

#[Model(table: 'travelers')]
class Traveler extends BaseModel {
    #[Field(column: 'id', type: 'int', primary: true)]
    public int $id;

    #[Field(column: 'name', type: 'string')]
    public string $name;

    public function __construct() {
        parent::__construct();
    }

    /**
     * Получение списка городов, посещенных путешественником.
     *
     * @return City[]|null
     */
    public function getVisitedCities(): ?array {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('c.*')
            ->from('cities', 'c')
            ->join('c', 'ratings', 'r', 'c.id = r.attraction_id')
            ->where('r.traveler_id = :traveler_id')
            ->setParameter('traveler_id', $this->id)
            ->groupBy('c.id');

        $result = $queryBuilder->execute()->fetchAllAssociative();

        if ($result) {
            return $this->hydrateAll($result, City::class);
        }

        return null;
    }

    /**
     * Получение всех отзывов от путешественника.
     *
     * @return array|null Массив объектов класса Attraction или null, если достопримечательности отсутствуют.
     */
    public function getAllReviews(): ?array {

        if ($this->id) {
            $attractionModel = new Rating();
            return $attractionModel->allByColumn('traveler_id', $this->id);
        }

        return null;
    }
}

?>