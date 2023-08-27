<?php

namespace MiNutCz\Tree\Source;

use MiNutCz\Tree\Exceptions\RuntimeException;

abstract class DatabaseSource implements SourceInterface
{
    const DEFAULT_COLUMN_ID = 'id';
    const DEFAULT_COLUMN_PARENT = 'parent';
    const DEFAULT_COLUMN_TEXT = 'text';
    const DEFAULT_COLUMN_TYPE = 'type';

    const DEFAULT_COLUMNS = [
        self::DEFAULT_COLUMN_ID,
        self::DEFAULT_COLUMN_PARENT,
        self::DEFAULT_COLUMN_TEXT,
        self::DEFAULT_COLUMN_TYPE,
    ];

    /** @var string[]  */
    protected array $columns = [
        self::DEFAULT_COLUMN_ID => 'id',
        self::DEFAULT_COLUMN_PARENT => 'parentId',
        self::DEFAULT_COLUMN_TEXT => 'text',
        self::DEFAULT_COLUMN_TYPE => 'type',
    ];

    /**
     * Add more columns to tree
     * @param string $key
     * @param string $column
     * @return $this
     */
    public function addColumn(string $key, string $column): self
    {
        if (array_key_exists($key, $this->columns)) {
            throw new RuntimeException("Column with key $key already exists");
        }
        $this->columns[$key] = $column;
        return $this;
    }

    /**
     * Remove column from tree. Except default columns
     * @param string $key
     * @return $this
     */
    public function removeColumn(string $key): self
    {
        if (!array_key_exists($key, $this->columns)) {
            throw new RuntimeException("Column with key $key does not exists");
        }
        if (in_array($key, self::DEFAULT_COLUMNS, true)) {
            throw new RuntimeException("Column with key $key is default column and cannot be removed");
        }
        unset($this->columns[$key]);
        return $this;
    }

    /**
     * Change default column name
     * @param string $key
     * @param string $name
     * @return $this
     */
    public function changeDefaultColumnName(string $key, string $name): self
    {
        if (!array_key_exists($key, $this->columns)) {
            throw new RuntimeException("Column with key $key does not exists");
        }
        if (!in_array($key, self::DEFAULT_COLUMNS, true)) {
            throw new RuntimeException("Column with key $key is not default column and cannot be renamed");
        }
        $this->columns[$key] = $name;
        return $this;

    }

}