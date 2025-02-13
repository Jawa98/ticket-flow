<?php

namespace App\Traits;

trait JSONResponse
{
    private $resource;

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        $this->resource = $resource;
    }

    public function collection($collection, $message = '', $status = true, $errors = null)
    {
        $resource = $this->getResource();

        $method = request()->method();

        if($method === 'POST') $message = 'created successfully';
        if($method === 'PUT') $message = 'updated successfully';

        return $resource::collection($collection)->additional([
                'success' => $status,
                'total' => $collection->count()>0?$collection->total():0,
                'errors' => $errors,
                'message' => $message
            ]
        );
    }

    public function resource($collection, $message = '', $status = true, $errors = null)
    {
        $method = request()->method();

        if($method === 'POST') $message = 'created successfully.';
        if($method === 'PUT') $message = 'updated successfully.';
        if($method === 'DELETE') $message = 'deleted successfully.';

        $resourceInstance = new $this->resource($collection);
        $resourceInstance->additional([
            'success' => $status,
            'errors' => $errors,
            'message' => $message
            ]
        );
        return $resourceInstance;
    }
}
