<?php

namespace App\Traits;

use App\Contracts\Abstracts\BaseService;
use App\Enums\ResponseCode;
use App\Exceptions\RestfulApiException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait ValidationInput
{
    protected array $validatedData;

    /**
     * @param array $data
     * @param Request $request
     * @return array
     * @throws RestfulApiException
     */
    public function validated(array $data, Request $request): array
    {
        if (!$request->authorize())
            throw new RestfulApiException(ResponseCode::ERR_FORBIDDEN_ACCESS, "You are unauthorized to access this resource");

        $validator = Validator::make($data, $request->rules(), $request->messages())->validate();

        $this->setValidatedData($validator);

        return $validator;
    }

    /**
     * Validates inputs.
     *
     * @param array $inputs
     * @param array $rules
     * @param array $messages
     * @param array $attributes
     *
     * @return array
     *
     * @throws ValidationException
     */
    public function validate(array $inputs, array $rules, array $messages = [], array $attributes = []): array
    {
        return Validator::make($inputs, $rules, $messages, $attributes)->validate();
    }


    /**
     * @param array $validatedData
     * @return BaseService|ValidationInput
     */
    protected function setValidatedData(array $validatedData): self
    {
        $this->validatedData = $validatedData;
        return $this;
    }


    /**
     * @return array
     */
    protected function getValidatedData(): array
    {
        return $this->validatedData;
    }
}
