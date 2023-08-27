<?php

namespace MiNutCz\Tree\Plugins;

interface PluginInterface
{
    public function getName():string;

    /**
     * @internal
     * @return array<string,mixed>|null
     */
    public function getConfig():?array;
}