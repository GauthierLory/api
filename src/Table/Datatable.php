<?php

namespace App\Table;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\DataTableFactory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class Datatable
{
    protected const QUERY_TYPE = 'query';
    protected const ARRAY_TYPE = 'array';
    protected const ENTITY_TYPE = 'entity';

    /** @var \Omines\DataTablesBundle\DataTable  */
    private $datatable;

    /** @var string  */
    protected static $entityClass;

    /** @var string */
    protected static $type;

    /** @var array  */
    private static $columns = [];

    /** @var UrlGeneratorInterface  */
    private $router;

    /**
     * @param UrlGeneratorInterface $router
     * @param DataTableFactory $factory
     */
    public function __construct(UrlGeneratorInterface $router, DataTableFactory $factory)
    {
        $this->datatable = $factory->create();
        $this->router = $router;
    }

    abstract protected function builder(): void;

    /**
     * @param string $columnName
     * @param string $type
     * @param array $options
     * @return Datatable
     */
    final protected function add(string $columnName, string $type, $options = []): self
    {
        $this->datatable->add($columnName, $type, $options);
        self::$columns[] = $columnName;
        return $this;
    }

    /**
     * @return array
     */
    public function populate(): array
    {
        return [];
    }

    /**
     * @return Datatable
     */
    private function fillArray(): self
    {
        $this->builder();
        $results = array_map(static function ($value) {
            return array_combine(self::$columns, is_array($value) ? $value : [$value]);
        }, $this->populate());
        $this->datatable->createAdapter(ArrayAdapter::class, $results);
        static::$type = self::ARRAY_TYPE;
        return $this;
    }

    /**
     * @return Datatable
     */
    private function bindEntity(): self
    {
        $this->entityClass();
        $this->builder();
        $this->datatable->createAdapter(ORMAdapter::class, [
            self::ENTITY_TYPE => static::$entityClass
        ]);
        static::$type = self::ENTITY_TYPE;

        return $this;
    }

    /**
     * @param QueryBuilder $builder
     * @return QueryBuilder
     */
    public function query(QueryBuilder $builder): QueryBuilder
    {
        return $builder;
    }

    /**
     * @return Datatable
     */
    private function queryBuilder(): self
    {
        $this->entityClass();
        $this->builder();

        $this->datatable->createAdapter(ORMAdapter::class, [
            self::ENTITY_TYPE => static::$entityClass,
            'hydrate' => Query::HYDRATE_ARRAY,
            'query' => function (QueryBuilder $builder) {
                $this->query($builder);
            },
        ]);
        static::$type = self::QUERY_TYPE;
        return $this;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request): void
    {
        $this->datatable->handleRequest($request);
    }

    /**
     * @return bool
     */
    final public function isCallback(): bool
    {
        return $this->datatable->isCallback();
    }

    /**
     * @return JsonResponse
     */
    final public function response(): JsonResponse
    {
        switch (static::$type) {
            case self::ARRAY_TYPE:
                $this->fillArray();
                break;
            case self::ENTITY_TYPE;
                $this->bindEntity();
                break;
            case self::QUERY_TYPE;
                $this->queryBuilder();
                break;
            default :
                throw new \InvalidArgumentException('Builder is not populate');
                break;
        }
        return $this->datatable->getResponse();
    }

    /**
     * @return \Omines\DataTablesBundle\DataTable
     */
    final public function render(): \Omines\DataTablesBundle\DataTable
    {
        return $this->datatable;
    }

    /**
     * @param string $routeName
     * @param array $option
     * @return string
     */
    final protected function route(string $routeName, array $option = []): string
    {
        return $this->router->generate($routeName, $option, UrlGeneratorInterface::ABSOLUTE_URL);
    }


    private function entityClass(): void
    {
        if (static::$entityClass === null) {
            throw new \InvalidArgumentException('Entity class name is missing');
        }
    }
}