<?php

namespace MiNutCz\Tree\Plugins\SearchPlugin;

use MiNutCz\Tree\Plugins\PluginInterface;

class SearchPlugin implements PluginInterface
{

    public bool $caseSensitive = true;
    public bool $showOnlyMatches = true;

    public function getName(): string
    {
        return 'search';
    }

    public function getConfig(): ?array
    {
        return [
            'case_sensitive' => $this->caseSensitive,
            'show_only_matches' => $this->showOnlyMatches,
            'search_leaves_only' => false,
        ];
    }

    public function setCaseSensitive(bool $caseSensitive = true): SearchPlugin
    {
        $this->caseSensitive = $caseSensitive;
        return $this;
    }

    public function setShowOnlyMatches(bool $showOnlyMatches = true): SearchPlugin
    {
        $this->showOnlyMatches = $showOnlyMatches;
        return $this;
    }

}