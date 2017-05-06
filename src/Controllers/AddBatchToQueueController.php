<?php

namespace Controllers;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

/**
 * Store multiple URL's in the queue, it's just a wrapper
 * that does responses through AddToQueue controller
 *
 * @package Controllers
 */
class AddBatchToQueueController extends AbstractBaseController
{
    const FAILED_ADDING_TO_QUEUE = 'FAILED_ADDING_MULTIPLE_FILES_TO_QUEUE';

    /**
     * @var App $app
     */
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
        parent::__construct($app);
    }

    /**
     * @param array $data
     * @param string $index
     *
     * @throws \Exception
     */
    private function validateQueueData(array $data, string $index)
    {
        if (!is_array($data)) {
            throw new \Exception('Item at index "' . $index . '" is not an array');
        }

        if (!isset($data['url_address'])) {
            throw new \Exception('Item at index "' . $index . '" is missing "url_address" parameter');
        }

        if (!isset($data['type'])) {
            throw new \Exception('Item at index "' . $index . '" is missing "type" parameter');
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     *
     * @return Response
     */
    public function executeAction(Request $request, Response $response)
    {
        $errors = [];
        $queueData    = $request->getParam('queue_data');
        $count        = 0;

        if (!is_array($queueData)) {
            return $response->withJson([
                'success' => false,
                'code'    => self::ERROR_REQUEST_INVALID,
                'message' => '"queue_data" POST parameter must be an array',
            ]);
        }

        foreach ($queueData as $index => $item) {
            try {
                $this->validateQueueData($item, $index);
            }
            catch (\Exception $e) {
                $errors[] = $e->getMessage();
                continue;
            }

            $preparedRequest = clone $request;
            $preparedRequest = $preparedRequest->withAttribute('escapedUrlAddress', base64_encode($item['url_address']));
            $preparedRequest = $preparedRequest->withAttribute('type', $item['type']);

            $controller = new AddToQueueController($this->app);
            $result = $controller->executeAction($preparedRequest, new Response());
            $decoded = json_decode((string)$result->getBody(), true);


            if ((int)$result->getStatusCode() > 300 || $decoded === false || $decoded['success'] === false) {

                return $response->withJson([
                    'success'     => false,
                    'added_count' => $count,
                    'code'    => self::FAILED_ADDING_TO_QUEUE,
                    'message' => 'Failed adding multiple files to queue, stopped at position ' . $index . ', response: ' . (string)$result->getBody(),
                    'note'    => 'Some entries were added',
                ], 400);
            }

            $this->getLogger()->debug('Batch response: ' . (string)$result->getBody());
            $count++;
        }

        if (count($errors) > 0) {
            return $response->withJson([
                'success' => false,
                'code'    => self::ERROR_REQUEST_INVALID,
                'errors'  => $errors,
            ]);
        }

        return $response->withJson([
            'success'         => true,
            'added_count'     => $count,
        ]);
    }
}
