-- Таблица Города
CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Таблица Достопримечательности
CREATE TABLE attractions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    distance_from_center DECIMAL(10, 2) NOT NULL,
    city_id INT,
    average_rating DECIMAL(3, 1) NOT NULL DEFAULT 0,
    FOREIGN KEY (city_id) REFERENCES cities(id)
);

-- Таблица Путешественники
CREATE TABLE travelers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Таблица Оценки
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    traveler_id INT,
    attraction_id INT,
    rating DECIMAL(3, 1) NOT NULL,
    FOREIGN KEY (traveler_id) REFERENCES travelers(id),
    FOREIGN KEY (attraction_id) REFERENCES attractions(id)
);

-- Процедура обновления рейтинга при добавлении новых оценок
DELIMITER //

CREATE TRIGGER update_average_rating AFTER INSERT ON ratings
FOR EACH ROW
BEGIN
    DECLARE new_average DECIMAL(3, 1);
    
    SELECT AVG(rating) INTO new_average FROM ratings WHERE attraction_id = NEW.attraction_id;
    
    UPDATE attractions SET average_rating = new_average WHERE id = NEW.attraction_id;
END;

//
DELIMITER ;

-- Наполнение таблицы случайными данными

INSERT INTO travelers (name) VALUES
    ('Иван'),
    ('Анна'),
    ('Михаил'),
    ('София'),
    ('Дмитрий');

INSERT INTO cities (name) VALUES
    ('Москва'),
    ('Санкт-Петербург'),
    ('Казань'),
    ('Екатеринбург'),
    ('Сочи');

-- Для Москвы
INSERT INTO attractions (name, distance_from_center, city_id) VALUES
    ('Красная площадь', 0.5, 1),
    ('Кремль', 0.3, 1),
    ('Спасская башня', 0.4, 1);

-- Для Санкт-Петербурга
INSERT INTO attractions (name, distance_from_center, city_id) VALUES
    ('Эрмитаж', 0.2, 2),
    ('Петропавловская крепость', 0.3, 2),
    ('Исаакиевский собор', 0.4, 2);

-- Для Казани
INSERT INTO attractions (name, distance_from_center, city_id) VALUES
    ('Казанский Кремль', 0.4, 3),
    ('Кул Шариф', 0.6, 3),
    ('улица Баумана', 0.2, 3);

-- Для Екатеринбурга
INSERT INTO attractions (name, distance_from_center, city_id) VALUES
    ('Храм на Крови', 0.3, 4),
    ('Ганина Яма', 0.5, 4),
    ('Центральный стадион', 0.6, 4);

-- Для Сочи
INSERT INTO attractions (name, distance_from_center, city_id) VALUES
    ('Олимпийский парк', 0.4, 5),
    ('Дендрарий', 0.3, 5),
    ('Роза Хутор', 0.5, 5);

-- Рейтинги 
INSERT INTO ratings (traveler_id, attraction_id, rating) VALUES
    (1, 1, FLOOR(RAND() * 5) + 1),
    (2, 1, FLOOR(RAND() * 5) + 1),
    (3, 2, FLOOR(RAND() * 5) + 1),
    (4, 2, FLOOR(RAND() * 5) + 1),
    (1, 3, FLOOR(RAND() * 5) + 1),
    (2, 3, FLOOR(RAND() * 5) + 1),
    (3, 3, FLOOR(RAND() * 5) + 1),
    (4, 4, FLOOR(RAND() * 5) + 1),
    (5, 4, FLOOR(RAND() * 5) + 1),
    (1, 5, FLOOR(RAND() * 5) + 1),
    (2, 5, FLOOR(RAND() * 5) + 1),
    (3, 6, FLOOR(RAND() * 5) + 1),
    (4, 6, FLOOR(RAND() * 5) + 1),
    (5, 6, FLOOR(RAND() * 5) + 1),
    (1, 7, FLOOR(RAND() * 5) + 1),
    (2, 7, FLOOR(RAND() * 5) + 1),
    (3, 8, FLOOR(RAND() * 5) + 1),
    (4, 8, FLOOR(RAND() * 5) + 1),
    (5, 8, FLOOR(RAND() * 5) + 1),
    (1, 9, FLOOR(RAND() * 5) + 1),
    (2, 9, FLOOR(RAND() * 5) + 1),
    (3, 9, FLOOR(RAND() * 5) + 1),
    (4, 9, FLOOR(RAND() * 5) + 1),
    (5, 9, FLOOR(RAND() * 5) + 1),
    (1, 10, FLOOR(RAND() * 5) + 1),
    (2, 10, FLOOR(RAND() * 5) + 1),
    (3, 10, FLOOR(RAND() * 5) + 1),
    (4, 10, FLOOR(RAND() * 5) + 1),
    (5, 10, FLOOR(RAND() * 5) + 1),
    (1, 11, FLOOR(RAND() * 5) + 1),
    (2, 11, FLOOR(RAND() * 5) + 1),
    (3, 11, FLOOR(RAND() * 5) + 1),
    (4, 11, FLOOR(RAND() * 5) + 1),
    (5, 11, FLOOR(RAND() * 5) + 1),
    (1, 12, FLOOR(RAND() * 5) + 1),
    (2, 12, FLOOR(RAND() * 5) + 1),
    (3, 12, FLOOR(RAND() * 5) + 1),
    (4, 12, FLOOR(RAND() * 5) + 1),
    (5, 12, FLOOR(RAND() * 5) + 1),
    (1, 13, FLOOR(RAND() * 5) + 1),
    (2, 13, FLOOR(RAND() * 5) + 1),
    (3, 13, FLOOR(RAND() * 5) + 1),
    (4, 13, FLOOR(RAND() * 5) + 1),
    (5, 13, FLOOR(RAND() * 5) + 1),
    (1, 14, FLOOR(RAND() * 5) + 1),
    (2, 14, FLOOR(RAND() * 5) + 1),
    (3, 14, FLOOR(RAND() * 5) + 1),
    (4, 14, FLOOR(RAND() * 5) + 1),
    (5, 14, FLOOR(RAND() * 5) + 1),
    (1, 15, FLOOR(RAND() * 5) + 1),
    (2, 15, FLOOR(RAND() * 5) + 1),
    (3, 15, FLOOR(RAND() * 5) + 1),
    (4, 15, FLOOR(RAND() * 5) + 1),
    (5, 15, FLOOR(RAND() * 5) + 1);