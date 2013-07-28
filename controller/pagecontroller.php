<?php
namespace OCA\Visual_Bookmarks\Controller;

use OCA\AppFramework\Controller\Controller;
use OCA\AppFramework\Http\RedirectResponse;
use OCA\Visual_Bookmarks\Db\Bookmark;
use OCA\Visual_Bookmarks\Db\BookmarkMapper;
use DomDocument;

class PageController extends Controller
{
    /**
     * @var BookmarkMapper $bookmarkMapper
     */
    private $bookmarkMapper;

    /**
     * __construct method
     *
     * @param Request $request: an instance of the request
     * @param API $api: an api wrapper instance
     * @param BookmarkMapper $bookmarkMapper: an bookmarkmapper instance
     */
    public function __construct($api, $request)
    {
        parent::__construct($api, $request);
        $this->bookmarkMapper = new BookmarkMapper($api);
    }

    /**
     * index method
     *
     * @CSRFExemption
     * @brief renders the index page
     * @return an instance of a Response implementation
     */
    public function index()
    {
        $bookmarks = $this->bookmarkMapper->findAllByUserId($this->api->getUserId());

        return $this->render('index', compact('bookmarks'));
    }

    /**
     * view method
     *
     * @brief renders the index page
     * @return an instance of a Response implementation
     */
    public function view()
    {
        $bookmark = $this->bookmarkMapper->findOneByIdAndUserId($this->params('id'), $this->api->getUserId());

        return $this->render('view', compact('bookmark'), null);
    }

    /**
     * add method
     *
     * @CSRFExemption
     * @return an instance of a Response implementation
     */
    public function add()
    {
        $bookmark = new Bookmark();
        if($this->request->method === 'POST') {
            $data = $this->params('data');
            $bookmark->set($data['Bookmark'], array('title', 'url', 'description'));
            $bookmark->setUserId($this->api->getUserId());

            if ($bookmark = $this->bookmarkMapper->insert($bookmark) !== false) {
                $flash = array(
                    'state' => 'success',
                    'message' => 'Bookmark was successfully saved.'
                );
            } else {
                $flash = array(
                    'state' => 'error',
                    'message' => 'Bookmark could not be save.'
                );
            }
        }

        return $this->render('add', compact('bookmark', 'flash'), null);
    }

    /**
     * edit method
     *
     * @return an instance of a Response implementation
     */
    public function edit()
    {
        $bookmark = $this->bookmarkMapper->findOneByIdAndUserId($this->params('id'), $this->api->getUserId());

        if($this->request->method === 'POST') {
            $data = $this->params('data');
            $bookmark->set($data['Bookmark'], array('title', 'url', 'description'));

            if ($bookmark && $this->bookmarkMapper->update($bookmark) !== false) {
                $flash = array(
                    'state' => 'success',
                    'message' => 'Bookmark was successfully saved.'
                );
            } else {
                $flash = array(
                    'state' => 'error',
                    'message' => 'Bookmark could not be save.'
                );
            }
        }

        return $this->render('edit', compact('bookmark', 'flash'), null);
    }

    /**
     * delete method
     *
     * @return an instance of a Response implementation
     */
    public function delete()
    {
        $bookmark = $this->bookmarkMapper->findOneByIdAndUserId($this->params('id'), $this->api->getUserId());

        if($this->request->method === 'POST') {

            if ($bookmark
                && $this->bookmarkMapper->deletebyIdAndUserId($this->params('id'), $this->api->getUserId())) {

                $flash = array(
                    'state' => 'success',
                    'message' => 'Bookmark was successfully deleted.'
                );
            } else {
                $flash = array(
                    'state' => 'error',
                    'message' => 'Bookmark could not be deleted.'
                );
            }
        }

        return $this->render('delete', compact('bookmark', 'flash'), null);
    }

    /**
     * redirect method
     *
     * @CSRFExemption
     * @return an instance of a Response implementation
     */
    public function redirect()
    {
        $bookmark = $this->bookmarkMapper->findOneByIdAndUserId($this->params('id'), $this->api->getUserId());
        $this->bookmarkMapper->addClick($this->params('id'), $this->api->getUserId());

        return new RedirectResponse($bookmark->url);
    }

    /**
     * import method
     *
     * @CSRFExemption
     * @return an instance of a Response implementation
     */
    public function import()
    {
        $file = $this->getUploadedFile('import_file');

        if ($file && $file['type'] == 'text/html') {
            libxml_use_internal_errors(true);
            $dom = new domDocument();
            $dom->loadHTMLFile($file['tmp_name']);
            $links = $dom->getElementsByTagName('a');

            foreach($links as $link) {
                $url = $link->getAttribute("href");
                $skipped = true;

                if ($url && !$this->bookmarkMapper->findOneByUrlAndUserId($url, $this->api->getUserId())) {

                    $bookmark = new Bookmark();
                    $bookmark->setUrl($url);
                    $bookmark->setUserId($this->api->getUserId());
                    $bookmark->setTitle($link->nodeValue);

                    if($link->hasAttribute("description")) {
                        $bookmark->setDescription($link->getAttribute("description"));
                    }

                    $this->bookmarkMapper->insert($bookmark);
                    $skipped = false;

                }

                $messages[] = array(
                    'url' => $url,
                    'status' => $skipped ? 'skipped' : 'imported'
                );
            }

        }

        return $this->render('import', compact('messages'));

    }

    /**
     * export method
     *
     * @CSRFExemption
     * @return an instance of a Response implementation
     */
    public function export()
    {
        $bookmarks = $this->bookmarkMapper->findAllByUserId($this->api->getUserId());
        $response = $this->render('export', compact('bookmarks'), null);
        $userName = \OC_USER::getDisplayName($this->api->getUserId())
                  ? \OC_USER::getDisplayName($this->api->getUserId()) : $this->api->getUserId();
        $exportName = '"ownCloud Bookmarks (' . $userName . ') (' . date('Y-m-d') . ').html"';

        $response->addHeader('Cache-Control', 'private');
        $response->addHeader('Content-Type', 'application/stream');
        $response->addHeader('Content-Disposition', 'attachment; filename=' . $exportName);

        return $response;
    }

}