<?php

namespace TravelApp\Base;

use ReflectionClass;
use TravelApp\Core\Database;
use Doctrine\DBAL\Connection;
use TravelApp\Core\QueryParamsValidator;

class BaseModel {

    protected Connection $connection;

    public function __construct() {
        $this->connection = Database::getConnection();
    }

    /**
     * Сохраняет текущий объект в базе данных.
     *
     * @return bool Возвращает true в случае успешного сохранения, иначе false.
     */
    public function save(): bool {
        $reflection = new ReflectionClass($this);
        $tableName = $this->getTableName($reflection);
        $properties = $this->getPropertiesWithFields($reflection);

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->insert($tableName);

        foreach ($properties as $property => $fieldAttribute) {
            $columnName = $fieldAttribute->column;
            $value = $this->$property ?? null;
            $queryBuilder->setValue($columnName, $queryBuilder->createNamedParameter($value));
        }

        try {
            $result = $queryBuilder->execute();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
 
    /**
     * Обновляет данные текущего объекта в базе данных.
     *
     * @return bool Возвращает true в случае успешного обновления, иначе false.
     */
    public function update(): bool {
        $reflection = new ReflectionClass($this);
        $tableName = $this->getTableName($reflection);
        $properties = $this->getPropertiesWithFields($reflection);

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->update($tableName);

        foreach ($properties as $property => $fieldAttribute) {
            $columnName = $fieldAttribute->column;
            $value = $this->$property ?? null;
            $queryBuilder->set($columnName, $queryBuilder->createNamedParameter($value));
        }

        $queryBuilder
            ->where('id = :id')
            ->setParameter('id', $this->id);

        $result = $queryBuilder->execute();

        return true;
    }

    /**
     * Удаляет текущий объект из базы данных.
     *
     * @return bool Возвращает true в случае успешного удаления, иначе false.
     */
    public function delete(): bool {
        $reflection = new ReflectionClass($this);
        $tableName = $this->getTableName($reflection);

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->delete($tableName)
            ->where('id = :id')
            ->setParameter('id', $this->id);

        $result = $queryBuilder->execute();

        return true;
    }

    /**
     * Находит объект в базе данных по его идентификатору.
     *
     * @param int $id Идентификатор объекта.
     * @return object|null Возвращает найденный объект или null, если объект не найден.
     */
    public function find(int $id): ?object {
        $reflection = new ReflectionClass($this);
        
        $tableName = $this->getTableName($reflection);
        
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where('id = :id')
            ->setParameter('id', $id);

        $result = $queryBuilder->execute()->fetchAssociative();

        if ($result) {
            return $this->hydrate($result, static::class);
        }

        return null;
    }

    /**
     * Возвращает массив всех объектов данного типа из базы данных.
     *
     * @return array|null Массив объектов или null, если объекты не найдены.
     */
    public function all(string $order = 'asc', string $field = 'id'): ?array {

        $allowedFields = $this->getSortableFields(/* $this->getExcludedFields() */);
        
        if (!QueryParamsValidator::validateOrder($order)) {
            return null;
        }

        if (!QueryParamsValidator::validateField($field, $allowedFields)) {
            return null;
        }

        $reflection = new ReflectionClass($this);
        
        $tableName = $this->getTableName($reflection);
        
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from($tableName)
            ->orderBy($field, $order);

        $result = $queryBuilder->execute()->fetchAllAssociative();

        if ($result) {
            return $this->hydrateAll($result, static::class);
        }

        return null;
    }

     /**
     * Возвращает имя таблицы для текущей модели.
     *
     * @param ReflectionClass $reflection Рефлексия класса модели.
     * @return string Имя таблицы, связанной с моделью.
     */
    private function getTableName(ReflectionClass $reflection): string {
        
        $modelAttribute = $reflection->getAttributes(\TravelApp\Models\Model::class);
        return $modelAttribute[0]->getArguments()['table'];
    }

    /**
     * Получает свойства модели с атрибутами Field и возвращает их в ассоциативном массиве.
     *
     * @param ReflectionClass $reflection Рефлексия класса модели.
     * @return array Ассоциативный массив свойств с атрибутами Field.
     */
    private function getPropertiesWithFields(ReflectionClass $reflection): array {
        $properties = [];

        foreach ($reflection->getProperties() as $property) {
            $fieldAttribute = $property->getAttributes(\TravelApp\Models\Field::class);
            
            if (!empty($fieldAttribute)) {
                $properties[$property->getName()] = $fieldAttribute[0]->newInstance();
            }
        }

        return $properties;
    }

    /**
     * Преобразует ассоциативный массив данных в экземпляр класса модели.
     *
     * @param array $data Массив данных для инициализации объекта.
     * @param string $className Имя класса модели.
     * @return object Созданный объект модели.
     */
    protected function hydrate(array $data, string $className): object {
        $instance = new $className();
        foreach ($data as $property => $value) {
            if (property_exists($instance, $property)) {
                $instance->{$property} = $value;
            }
        }
        return $instance;
    }

    /**
     * Преобразует массив данных в массив экземпляров классов модели.
     *
     * @param array $results Массив данных для инициализации объектов.
     * @param string $className Имя класса модели.
     * @return array Массив объектов модели.
     */
    protected function hydrateAll(array $results, string $className): array {

        $hydratedInstances = [];
        foreach ($results as $result) {
            $hydratedInstances[] = $this->hydrate($result, $className);
        }
        return $hydratedInstances;
    }

    /**
     * Получает все записи из таблицы, удовлетворяющие определенному условию на конкретной колонке.
     *
     * @param string $columnName Имя колонки, по которой выполняется фильтрация.
     * @param mixed $columnValue Значение колонки, по которой выполняется фильтрация.
     * @return array|null Массив объектов модели, удовлетворяющих условию, или null, если нет результатов.
     */
    protected function allByColumn(string $columnName, $columnValue): ?array {
        $reflection = new ReflectionClass($this);
        $tableName = $this->getTableName($reflection);

        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from($tableName)
            ->where("$columnName = :columnValue")
            ->setParameter('columnValue', $columnValue);

        $result = $queryBuilder->execute()->fetchAllAssociative();

        if ($result) {
            return $this->hydrateAll($result, static::class);
        }

        return null;
    }

    /**
     * Получение списка полей, по которым можно сортировать, с возможностью исключения определенных полей.
     *
     * @param array $excludeFields Поля, которые следует исключить из списка сортируемых полей.
     * @return array Массив полей, по которым можно сортировать.
     */
    protected function getSortableFields(array $excludeFields = []): array {
        $reflection = new ReflectionClass($this);
        $sortableFields = [];

        foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            $fieldAttribute = $property->getAttributes(\TravelApp\Models\Field::class);
            if (!empty($fieldAttribute) /* && !in_array($property->getName(), $excludeFields) */ ) {
                $sortableFields[] = $property->getName();
            }
        }

        return $sortableFields;
    }

    // protected function setExcludeFields(array $excludeFields): void {
    //     $this->excludeFields = $excludeFields;
    // }

    // protected function getExcludedFields(): array {
    //     return $this->excludeFields;
    // }
}

?>