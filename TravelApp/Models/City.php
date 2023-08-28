<?php
/**
 * Модель для представления Городов.
 * Используется для взаимодействия с таблицей "cities" в базе данных.
 *
 * @package TravelApp\Models
 */
namespace TravelApp\Models;

use TravelApp\Base\BaseModel;
use TravelApp\Models\Field;

#[Model(table: 'cities')]
class City extends BaseModel {
    #[Field(column: 'id', type: 'int', primary: true)]
    public int $id;

    #[Field(column: 'name', type: 'string')]
    public string $name;

    public function __construct() {
        parent::__construct();
        // $this->setExcludeFields([]);
    }

    /**
     * Получение всех достопримечательностей в данном городе.
     *
     * @return array|null Массив объектов класса Attraction или null, если достопримечательности отсутствуют.
     */
    public function getAttractions(): ?array {
        if ($this->id) {
            $attractionModel = new Attraction();
            return $attractionModel->allByColumn('city_id', $this->id);
        }

        return null;
    }

    /**
     * Получение списка путешественников, побывавших в данном городе.
     *
     * @param int $cityId
     * @return Traveler[]|null
     */
    public function getTravelersVisitedCity(int $cityId): ?array {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('t.*')
            ->from('travelers', 't')
            ->join('t', 'ratings', 'r', 't.id = r.traveler_id')
            ->join('r', 'attractions', 'a', 'r.attraction_id = a.id')
            ->where('a.city_id = :city_id')
            ->setParameter('city_id', $cityId)
            ->groupBy('t.id');

        $result = $queryBuilder->execute()->fetchAllAssociative();

        if ($result) {
            return $this->hydrateAll($result, Traveler::class);
        }

        return null;
    }
}

?>