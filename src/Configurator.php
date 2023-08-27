<?php

namespace MiNutCz\Tree;

use MiNutCz\Tree\Plugins\PluginInterface;

class Configurator
{
    /** @var PluginInterface[] */
    private array $plugins = [];
    /** @var callable[] */
    private array $events = [];
    private string $dataLoadUrl;


    /**
     * @return array<string,mixed>
     * @internal
     */
    public function getTreeConfiguration(): array
    {
        $cfg = [];
        $cfg['core'] = [
            'data' => [
                'url' => $this->dataLoadUrl,
            ],
            'check_callback' => true,
        ];
        $cfg['plugins'] = $this->getRegisteredPlugins();
        foreach ($this->plugins as $plugin) {
            if (empty($plugin->getConfig())) {
                continue;
            }
            $cfg[$plugin->getName()] = $plugin->getConfig();
        }
        $cfg['events'] = array_keys($this->events);
        return $cfg;

    }

    /** @return string[] */
    private function getRegisteredPlugins(): array
    {
        return array_keys($this->plugins);
    }

    public function getEvent(string $getSrc): ?callable
    {
        return array_key_exists($getSrc, $this->events) ? $this->events[$getSrc] : null;
    }

    /** @return PluginInterface[] */
    public function getPlugins(): array
    {
        return $this->plugins;
    }

    /** @return callable[] */
    public function getEvents(): array
    {
        return $this->events;
    }

    public function setUrl(string $url): self
    {
        $this->dataLoadUrl = $url;
        return $this;
    }

    public function getPlugin(string $name): ?PluginInterface
    {
        return array_key_exists($name, $this->plugins) ? $this->plugins[$name] : null;
    }

    public function addEvent(Enum\Event $event, callable $callback): void
    {
        $this->events[$event->value] = $callback;
    }

    public function addPlugin(PluginInterface $plugin): self
    {
        $this->plugins[$plugin->getName()] = $plugin;
        return $this;
    }

    public function hasPlugin(string $string): bool
    {
        return array_key_exists($string, $this->plugins);
    }


}