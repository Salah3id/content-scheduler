<?php

namespace App\Traits;

use Inertia\Inertia;

trait ControllerResponseTrait
{
    protected array $responseData = [];
    protected array $filterData = [];
    protected string|null $resourceClass = null;
    protected string|null $view = null;
    protected bool $isCollection = false;

    public function addData(string $key, $value): static
    {
        $this->responseData[$key] = $value;
        return $this;
    }

    public function addFilterData(array $value): static
    {
        $this->filterData = $value;
        return $this;
    }

    public function useResource(string $resourceClass, bool $isCollection = false): static
    {
        $this->resourceClass = $resourceClass;
        $this->isCollection = $isCollection;
        return $this;
    }

    public function useView(string $view): static
    {
        $this->view = $view;
        return $this;
    }

    public function response()
    {
        if ($this->resourceClass) {
            $mainKey = array_key_first($this->responseData);

            $mainValue = $this->responseData[$mainKey];

            if ($this->isCollection) {
                $resource = $this->resourceClass::collection($mainValue);
            } else {
                $resource = new $this->resourceClass($mainValue);
            }

            if (request()->wantsJson()) {
                return $resource->additional([
                    'filters' => $this->filterData,
                ]);
            }

            return Inertia::render($this->view ?? $this->guessView(), array_merge(
                [$mainKey => $resource],
                ['filters' => $this->filterData],
            ));
        }

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $this->responseData,
                'filters' => $this->filterData,
            ]);
        }

        return Inertia::render($this->view ?? $this->guessView(), array_merge(
            $this->responseData,
            ['filters' => $this->filterData]
        ));
    }

    protected function guessView(): string
    {
        return request()->route()?->getName() ?? 'Dashboard';
    }
}
