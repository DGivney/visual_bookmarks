<?php
namespace OCA\Visual_Bookmarks;

$api = new \OCA\AppFramework\Core\API('visual_bookmarks');
$api->addNavigationEntry(array(
  'id' => $api->getAppName(),
  'order' => 80,
  'href' => $api->linkToRoute('visual_bookmarks_index'),
  'icon' => $api->imagePath('bookmarks.png'),
  'name' => $api->getTrans()->t('Bookmarks')
));
$api->addRegularTask('OCA\Visual_Bookmarks\Lib\Indexer', 'indexAll');