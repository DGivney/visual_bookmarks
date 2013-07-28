<?php
namespace OCA\Visual_Bookmarks\Db;

use \OCA\AppFramework\Core\API;
use \OCA\AppFramework\Db\Mapper;

class BookmarkMapper extends Mapper
{

    /**
     * __construct method
     *
     * @param API $api: Instance of the API abstraction layer
     */
    public function __construct($api)
    {
        parent::__construct($api, 'bookmarks');
    }

    /**
     * findOneByIdAndUserId method
     *
     * @throws DoesNotExistException: if the item does not exist
     * @throws MultipleObjectsReturnedException if more than one item exist
     * @return the item
     */
    public function findOneByIdAndUserId($id, $userId)
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE `id` = ? AND `user_id` = ?';
        $row = $this->findOneQuery($sql, array($id, $userId));

        $bookmark = new Bookmark();
        $bookmark->fromRow($row);

        return $bookmark;
    }

    /**
     * findOneByUrlAndUserId method
     *
     * @return the item
     */
    public function findOneByUrlAndUserId($url, $userId)
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE `url` = ? AND `user_id` = ?';
        $result = $this->execute($sql, array($url, $userId));

        if ($result->rowCount() === 0) {
            return false;
        }

        $bookmark = new Bookmark();
        while($row = $result->fetchRow()) {
            $bookmark->fromRow($row);
        }

        return $bookmark;
    }

    /**
     * Finds all bookmarks by user id
     *
     * @param string $userId: the id of the user that we want to find
     * @return array containing all items
     */
    public function findAllByUserId($userId)
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE `user_id` = ? ORDER BY clickcount DESC, lastmodified DESC';
        $result = $this->execute($sql, array($userId));

        $entityList = array();
        while($row = $result->fetchRow()){
            $bookmark = new Bookmark();
            $bookmark->fromRow($row);
            array_push($entityList, $bookmark);
        }

        return $entityList;
    }

    /**
     * Finds all bookmarks that need indexing
     *
     * @param string $interval: time quantifier to pass
     * @param string $limit
     * @return array containing all items
     */
    public function findNeedingIndexing($interval = '-1 month')
    {
        $sql = 'SELECT * FROM `' . $this->getTableName() . '` WHERE `lastindexed` IS NULL OR `lastindexed` <= ? ORDER BY id DESC LIMIT 2';
        $result = $this->execute($sql, array(strtotime($interval)));

        $entityList = array();
        while($row = $result->fetchRow()){
            $bookmark = new Bookmark();
            $bookmark->fromRow($row);
            array_push($entityList, $bookmark);
        }

        return $entityList;
    }

    /**
     * Adds a click to a bookmark by id
     *
     * @throws DoesNotExistException: if the item does not exist
     * @throws MultipleObjectsReturnedException if more than one item exist
     * @return bool
     */
    public function addClick($id, $userId)
    {
        $sql = 'UPDATE `' . $this->getTableName() . '` SET clickcount=COALESCE(clickcount, 0) + 1 WHERE `id` = ? AND `user_id` = ?';

        return $this->execute($sql, array($id, $userId));
    }

    /**
     * deleteByIdAndUserId method
     *
     * @throws DoesNotExistException: if the item does not exist
     * @param integer $id
     * @param integer $userId
     * @return bool
     */
    public function deleteByIdAndUserId($id, $userId)
    {
        $sql = 'DELETE FROM `' . $this->getTableName() . '` WHERE `id` = ? AND `user_id` = ?';

        return $this->execute($sql, array($id, $userId));
    }

}
