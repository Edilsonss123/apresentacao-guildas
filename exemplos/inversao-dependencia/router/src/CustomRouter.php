<?php
namespace Router;

use Buki\Router\Router;

class CustomRouter extends Router
{
    /**
     * CustomRouterCommand class
     *
     * @return CustomRouterCommand
     */
    protected function routerCommand(): CustomRouterCommand
    {
        return CustomRouterCommand::getInstance(
            $this->baseFolder, $this->paths, $this->namespaces,
            $this->request(), $this->response(),
            $this->getMiddlewares()
        );
    }
}