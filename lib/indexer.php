<?php
namespace OCA\Visual_Bookmarks\Lib;

use OCA\Visual_Bookmarks\Db\Bookmark;
use OCA\Visual_Bookmarks\Db\BookmarkMapper;
use DomDocument;
use DomXPath;

class Indexer
{

    /**
     * indexBookmarks method
     *
     * @return bool
     */
    public static function indexAll()
    {
        $api = new \OCA\AppFramework\Core\API('visual_bookmarks');
        $bookmarkMapper = new BookmarkMapper($api);
        $bookmarks = $bookmarkMapper->findNeedingIndexing();

        if ($bookmarks) {

            foreach($bookmarks as $bookmark) {

                if (($contentType = self::getType($bookmark->url)) != false) {
                    $bookmark->setType($contentType);
                }
                $bookmark->setLastindexed(strtotime('now'));
                $bookmarkMapper->update($bookmark);
            }
        }

        return true;
    }

    /**
     * getType method
     *
     * @param string $url
     * @return mixed false|string
     */
    public static function getType($url)
    {
        if (($response = self::requestSend($url, CURLINFO_CONTENT_TYPE)) != false) {
            return $response;
        }

        return false;
    }

    /**
     * requestSend method
     *
     * To return a header set the $headerOnly variable to valid CURLINFO option
     *
     * @param string $url
     * @param string $headerOnly
     * @return mixed false|string
     */
    public static function requestSend($url, $headerOnly = false)
    {
        $ch = curl_init($url);

        if ($headerOnly) {
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
        }

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);

        if(curl_errno($ch) == CURLE_OK ) {
            return $headerOnly ? curl_getinfo($ch, $headerOnly) : $response ;
        } else {
            return false;
        }

    }

}