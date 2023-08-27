<?php

namespace MiNutCz\Tree\Source;

use Nette\Database\Table\Selection;

class NetteDatabaseExplorerSource extends DatabaseSource
{

    public function __construct(private readonly Selection $table)
    {
    }

    /** @inheritDoc */
    public function getTreeNodes(): array
    {
        $table = $this->table;
        foreach ($this->columns as $tree => $db) {
            if ($tree === 'parent') {
                $table->select(" CASE WHEN $db IS NULL THEN '#' ELSE $db END AS $tree");
                continue;
            }
            $table->select("$db AS $tree");
        }
        return array_values($table->fetchAssoc('id'));
    }
}