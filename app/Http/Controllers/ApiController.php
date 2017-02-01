<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use League\Fractal\Manager;

class ApiController extends Controller
{
    public function __construct(Manager $manager)
    {
        $this->fractal = $manager;
        if (RequestFacade::has('include')) {
            $this->fractal->parseIncludes(RequestFacade::get('include'));
        }
    }

    public function respondWithItem($item, \League\Fractal\TransformerAbstract $transformer)
    {
        $resource = new \League\Fractal\Resource\Item($item, $transformer);
        return response()->json(
            $this->fractal->createData($resource)->toArray()
        );
    }

    public function respondWithCollection($collection, \League\Fractal\TransformerAbstract $transformer)
    {
        if ($collection instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $queryParams = array_diff_key($_GET, array_flip(['page']));
            $collection->appends($queryParams);

            $resource = new \League\Fractal\Resource\Collection(
                $collection->getCollection(),
                $transformer
            );

            $resource->setPaginator(
                new \League\Fractal\Pagination\IlluminatePaginatorAdapter($collection)
            );
        } else {
            $resource = new \League\Fractal\Resource\Collection($collection, $transformer);
        }

        return response()->json(
            $this->fractal
                ->createData($resource)
                ->toArray()
        );
    }
}
