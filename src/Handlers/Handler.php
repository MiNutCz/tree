<?php

namespace MiNutCz\Tree\Handlers;

use MiNutCz\Tree\Configurator;
use MiNutCz\Tree\Plugins\ContextmenuPlugin\ContextmenuPlugin;
use MiNutCz\Tree\Response\JsonTreeResponse;
use Nette\Application\Request;
use Nette\Application\Response;

readonly class Handler
{

    /**
     * @param Configurator $configurator
     */
    public function __construct(private Configurator $configurator)
    {
    }

    public function handle(Request $request): Response
    {
        $response = new JsonTreeResponse();
        $args = HandlerArgs::createFromParameters($request->getPost());
        if ($args->getSrc() === 'contextmenu') {
            $plugin = $this->configurator->getPlugin('contextmenu');
            if ($plugin instanceof ContextmenuPlugin) {
                $plugin->handle($args,$response);
            }
        }elseif ($args->getSrc() === 'events'){
            $event = $this->configurator->getEvent($args->getCommand());
            if($event !== null){
                call_user_func($event, $args,$response);
            }
        }
        return $response;
    }
}