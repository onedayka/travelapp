<?php

/**
 * Пример для добавления сортировки.
 * 
 * Вы можете использовать параметры "order" и "field" в запросе,
 * чтобы задать направление сортировки и поле, по которому сортировать.
 * 
 * Например: /attractions?order=desc&field=average_rating
 * 
 * Где:
 * - "order" может быть "asc" (по возрастанию) или "desc" (по убыванию).
 * - "average_rating" - это поле, по которому будет производиться сортировка.
 * 
 * Работает в методах index.
 */

return [
    ['GET', '/', 'AttractionController@index'],

    //Города
    ['GET', '/cities', 'CityController@index'],
    ['GET', '/cities/{id}', 'CityController@get'],
    ['POST', '/cities', 'CityController@post'],
    ['POST', '/cities/{id}', 'CityController@put'],
    ['GET', '/cities/delete/{id}', 'CityController@delete'],
    ['GET', '/cities/{id}/attractions', 'CityController@getAttractions'], // Достопримечательности в городе
    ['GET', '/cities/{id}/travelers', 'CityController@getTravelersVisitedCity'], // Путешественники, посетившие город

    //Достопримечательности
    ['GET', '/attractions', 'AttractionController@index'],
    ['GET', '/attractions/{id}', 'AttractionController@get'],
    ['POST', '/attractions', 'AttractionController@post'],
    ['POST', '/attractions/{id}', 'AttractionController@put'],
    ['GET', '/attractions/delete/{id}', 'AttractionController@delete'],

    //Туристы
    ['GET', '/travelers', 'TravelerController@index'],
    ['GET', '/travelers/{id}', 'TravelerController@get'],
    ['POST', '/travelers', 'TravelerController@post'],
    ['POST', '/travelers/{id}', 'TravelerController@put'],
    ['GET', '/travelers/delete/{id}', 'TravelerController@delete'],
    ['GET', '/travelers/{id}/cities', 'TravelerController@getVisitedCities'], // Посещённые города
    ['GET', '/travelers/{id}/ratings', 'TravelerController@getAllReviewsByTraveler'], // Все отзывы от путешественика

    // Отзывы
    ['GET', '/ratings', 'RatingController@index'],
    ['GET', '/ratings/{id}', 'RatingController@get'],
    ['POST', '/ratings', 'RatingController@post'],
    ['POST', '/ratings/{id}', 'RatingController@put'],
    ['GET', '/ratings/delete/{id}', 'RatingController@delete'],
];