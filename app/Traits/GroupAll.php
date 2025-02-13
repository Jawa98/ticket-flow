<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait GroupAll
{
    use JSONResponse, Pagination, ApiResponser;

    protected $perPage;
    protected $page;

    public function setConstruct(Request $request, $resource)
    {
        $this->setResource($resource);
        $this->perPage = $this->checkPerPageValue($request);
        $this->page = $this->checkPageValue($request);
    }
}
