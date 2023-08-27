<?php

namespace MiNutCz\Tree\Source;

use Nette\Database\Connection;

class NetteDatabaseSource extends DatabaseSource
{


    public function __construct(private readonly Connection $connection, private readonly string $tableName)
    {
    }

    /** @inheritDoc */
    public function getTreeNodes(): array
    {
        $sql = "SELECT ";
        $params = [];
        $columns = [];
        foreach ($this->columns as $key => $column) {
            if ($key === 'parent') {
                $columns[] = " CASE WHEN ?name IS NULL THEN '#' ELSE ?name END as ?name";
                $params [] = $column;
                $params [] = $column;
                $params [] = $key;
                continue;
            }
            $columns[] = " ?name as ?name";
            $params [] = $column;
            $params [] = $key;

        }
        $sql .= implode(', ', $columns) . " FROM ?name ORDER BY parent ASC";
        $params [] = $this->tableName;
        return array_values($this->connection->query($sql, ...$params)->fetchAssoc('id'));
    }


}