<?php

namespace FaisalHalim\LaravelEklaimApi\Http\Responses;

use Illuminate\Http\JsonResponse;

class EklaimResponse extends JsonResponse
{
    /**
     * Menjalankan callback pada data respons dan mengembalikan EklaimResponse.
     *
     * @param callable $callback
     * @return self
     */
    public function then(callable $callback)
    {
        $callback($this->getData());
        return $this;
    }
}
