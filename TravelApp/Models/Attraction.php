<?php
/**
 * Модель для представления достопримечательности.
 * Используется для взаимодействия с таблицей "attractions" в базе данных.
 *
 * @package TravelApp\Models
 */
namespace TravelApp\Models;

use TravelApp\Base\BaseModel;

#[Model(table: 'attractions')]
class Attraction extends BaseModel {
    #[Field(column: 'id', type: 'int', primary: true)]
    public int $id;

    #[Field(column: 'name', type: 'string')]
    public string $name;

    #[Field(column: 'distance_from_center', type: 'decimal')]
    public float $distance_from_center;

    #[Field(column: 'city_id', type: 'int')]
    public int $city_id;

    #[Field(column: 'average_rating', type: 'decimal')]
    public float $average_rating;

    public function __construct() {
        parent::__construct();
    }
}

?>