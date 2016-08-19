<?php

namespace RonasIT\Support\Middleware;

use Closure;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;
use RonasIT\Support\Services\SharedDataService;

/**
 * @property SharedDataService $dataService
*/
class SharedDataMiddleware {
    private $viewFactory;
    private $dataService;

    public function __construct(ViewFactory $viewFactory) {
        $this->viewFactory = $viewFactory;

        $dataServiceClass = config('shared-data.service');

        $this->dataService = app($dataServiceClass);
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->viewFactory->composer('*', function(View $view) use ($request) {
            $this->setSharedData($view, $request);
        });

        return $next($request);
    }

    protected function setSharedData($view, $request) {
        $data = $this->getData($request);

        $viewData = $view->getData();

        foreach($data as $key => $value) {
            if (!array_key_exists($key, $viewData)) {
                $view->with($key, $value);
            }
        }
    }
}
