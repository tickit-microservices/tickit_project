<?php

namespace app\controllers;

use app\entities\Pagination;
use app\transformers\BaseTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Yii;
use yii\base\Module;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

class BaseController extends Controller
{
    /**
     * @var Manager
     */
    protected $manager;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string the name of the HTTP header containing the information about total number of data items.
     * This is used when serving a resource collection with pagination.
     */
    public $totalCountHeader = 'X-Pagination-Total-Count';

    /**
     * @var string the name of the HTTP header containing the information about total number of pages of data.
     * This is used when serving a resource collection with pagination.
     */
    public $pageCountHeader = 'X-Pagination-Page-Count';

    /**
     * @var string the name of the HTTP header containing the information about the current page number (1-based).
     * This is used when serving a resource collection with pagination.
     */
    public $currentPageHeader = 'X-Pagination-Current-Page';

    /**
     * @var string the name of the HTTP header containing the information about the number of data items in each page.
     * This is used when serving a resource collection with pagination.
     */
    public $perPageHeader = 'X-Pagination-Per-Page';

    /**
     * BaseController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param Manager $manager
     * @param array $config
     */
    public function __construct($id, Module $module, Manager $manager, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->request = Yii::$app->request;
        $this->manager = $manager;

        $expand = $this->request->get('expand');
        if ($expand) {
            $this->manager->parseIncludes($expand);
        }
    }

    /**
     * @param $action
     *
     * @return bool
     *
     * @throws BadRequestHttpException
     */
    public function beforeAction($action)
    {
        // TODO check this
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }

    /**
     * @param Pagination $pagination
     * @param BaseTransformer $transformer
     *
     * @return mixed
     */
    protected function responsePagination(Pagination $pagination, BaseTransformer $transformer)
    {
        $this->setPaginationHeaders($pagination);

        $collection = new Collection($pagination->getModels(), $transformer);

        return $this->responseCollection($collection);
    }

    /**
     * @param Collection $collection
     *
     * @return mixed
     */
    protected function responseCollection(Collection $collection)
    {
        return $this->outputJsonResponse($this->manager->createData($collection)->toArray());
    }

    /**
     * @param Item $item
     *
     * @return mixed
     */
    protected function responseItem(Item $item)
    {
        return $this->outputJsonResponse($this->manager->createData($item)->toArray());
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    private function outputJsonResponse($data)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        return $data;
    }

    /**
     * @param Pagination $pagination
     */
    private function setPaginationHeaders(Pagination $pagination)
    {
        Yii::$app->response->getHeaders()
            ->set($this->totalCountHeader, $pagination->getTotal())
            ->set($this->pageCountHeader, $pagination->getPageCount())
            ->set($this->currentPageHeader, $pagination->getPage())
            ->set($this->perPageHeader, $pagination->getPageSize());
    }
}