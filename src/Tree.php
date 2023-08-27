<?php

namespace MiNutCz\Tree;

use JetBrains\PhpStorm\NoReturn;
use MiNutCz\Tree\Exceptions\RuntimeException;
use MiNutCz\Tree\Exceptions\TreeException;
use MiNutCz\Tree\Handlers\Handler;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\ContextmenuPlugin;
use MiNutCz\Tree\Plugins\NodeManipulationPlugin\NodeManipulationPlugin;
use MiNutCz\Tree\Plugins\SearchPlugin\SearchPlugin;
use MiNutCz\Tree\Plugins\TreeDragAndDropPlugin\TreeDragAndDropPlugin;
use MiNutCz\Tree\Plugins\TypesPlugin\TypesPlugin;
use MiNutCz\Tree\Source\SourceInterface;
use Nette\Application\UI\Control;
use Nette\Application\UI\InvalidLinkException;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;

class Tree extends Control
{
    private Configurator $configurator;
    private Handler $handler;
    private SourceInterface $source;

    public function __construct()
    {
        $this->configurator = new Configurator();
        $this->handler = new Handler($this->configurator);
    }

    /**
     * @throws InvalidLinkException
     */
    public function render(): void
    {
        $this->configurator->setUrl($this->link('getTreeData!'));
        /** @var DefaultTemplate $template */
        $template = $this->getTemplate();
        $template->add('jsTreeConfiguration', $this->configurator->getTreeConfiguration());
        $template->add('actionUrl', $this->link('action!'));
        $template->add('treeId', $this->getUniqueId());
        $template->add('searchEnabled', $this->configurator->hasPlugin('search'));
        $template->setFile(__DIR__ . '/Templates/tree.latte');
        $template->render();
    }


    /**
     * @param array<int,mixed>|SourceInterface $source
     * @return $this
     */
    public function setSource(array|SourceInterface $source): self
    {
        if (is_array($source)) {
            $source = new Source\ArraySource($source);
        }
        $this->source = $source;
        return $this;
    }

    /**
     * Add types plugin to tree
     * @return TypesPlugin
     */
    public function addTypesPlugin(): TypesPlugin
    {
        $plugin = new TypesPlugin();
        $this->configurator->addPlugin($plugin);
        return $plugin;
    }

    /**
     * Add drag and drop plugin to tree
     * @return TreeDragAndDropPlugin
     */
    public function addDragAndDropPlugin(): TreeDragAndDropPlugin
    {
        $plugin = new TreeDragAndDropPlugin();
        $this->configurator->addPlugin($plugin);
        return $plugin;
    }

    /**
     * Add contextmenu plugin to tree
     * @return ContextmenuPlugin
     */
    public function addContextmenuPlugin(): ContextmenuPlugin
    {
        $plugin = new ContextmenuPlugin();
        $this->configurator->addPlugin($plugin);
        return $plugin;
    }

    public function addNodeManipulationPlugin(): NodeManipulationPlugin
    {
        $plugin = new NodeManipulationPlugin();
        $this->configurator->addPlugin($plugin);
        return $plugin;
    }

    public function addSearchPlugin(): SearchPlugin
    {
        $plugin = new SearchPlugin();
        $this->configurator->addPlugin($plugin);
        return $plugin;
    }

    /**
     * @param Enum\Event $event
     * @param callable $callback function (HandlerArgs $args, JsonTreeResponse $response): void
     * @return $this
     */
    public function addEvent(Enum\Event $event, callable $callback): self
    {
        $this->configurator->addEvent($event, $callback);
        return $this;
    }

    /**
     * @internal
     */
    public function handleAction(): void
    {
        $request = $this->getPresenter()->getRequest();
        if ($request !== null) {
            $response = $this->handler->handle($request);
            $this->getPresenter()->sendResponse($response);
        }
    }

    /**
     * @return void
     * @throws TreeException
     * @internal
     */
    public function handleGetTreeData(): void
    {
        if (!isset($this->source)) {
            throw new TreeException('No source set!');
        }
        $data = $this->source->getTreeNodes();
        $this->validateData($data);
        $this->getPresenter()->sendJson($data);
    }

    /**
     * @param array<int,array<string,mixed>> $data
     * @return void
     */
    private function validateData(array $data): void
    {
        foreach ($data as $node) {
            if (!array_key_exists('id', $node)) {
                throw new RuntimeException('Node id is missing');
            }
            if (!array_key_exists('text', $node)) {
                throw new RuntimeException('Node text is missing');
            }
            if (!array_key_exists('parent', $node)) {
                throw new RuntimeException('Node parent is missing');
            }
            if (!array_key_exists('type', $node)) {
                throw new RuntimeException('Node type is missing');
            }
        }
    }

}
