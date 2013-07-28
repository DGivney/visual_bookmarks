<?php
namespace OCA\Visual_Bookmarks;

use \OCA\AppFramework\App;
use \OCA\Visual_Bookmarks\DependencyInjection\DIContainer;

$this->create('visual_bookmarks_index', '/')->action(
    function($params) {
        App::main('PageController', 'index', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_add', '/add')->action(
    function($params){
        App::main('PageController', 'add', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_view', '/view/{id}')->action(
    function($params){
        App::main('PageController', 'view', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_edit', '/edit/{id}')->action(
    function($params){
        App::main('PageController', 'edit', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_delete', '/delete/{id}')->action(
    function($params){
        App::main('PageController', 'delete', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_redirect', '/redirect/{id}')->action(
    function($params){
        App::main('PageController', 'redirect', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_export', '/export')->action(
    function($params){
        App::main('PageController', 'export', $params, new DIContainer());
    }
);

$this->create('visual_bookmarks_import', '/import')->action(
    function($params){
        App::main('PageController', 'import', $params, new DIContainer());
    }
);