<?php
namespace OCA\Visual_Bookmarks\DependencyInjection;

use OCA\AppFramework\DependencyInjection\DIContainer as BaseContainer;
use OCA\Visual_Bookmarks\Controller\PageController;

class DIContainer extends BaseContainer
{

    public function __construct()
    {
        parent::__construct('visual_bookmarks');
        $this['TwigTemplateDirectory'] = __DIR__ . '/../templates';
        $this['PageController'] = function($c) {
            return new PageController($c['API'], $c['Request']);
        };
    }

}