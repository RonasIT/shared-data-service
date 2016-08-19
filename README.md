Данный плагин является плагином для флеймворка Laravel и нужен для того, 
чтоб обеспечить доступ из blade-темплейтов вашего приложения доступ к общим 
глобальным  переменным, которые вы сами можете определить.

Для того, чтоб интегрировать плагин в ваш проект требуется

1. Добавить его в композер
    а. В блок repositories добавить ссылку на этот репозиторий
        "repositories": [
            {
                "type": "git",
                "url": "git@projects.ronasit.com:support/shared-data-service.git"
            }
        ]
    б. В блок required добавить сам плагин
        "ronasit/shared-data": "master-dev"
    в. Выполнить в консоли в папке проекта 
        composer update
2. Интегрировать плагин в проект Laravel
    а. Добавить сервис-провайдер в блок prividers файла config/app.php
        RonasIT\Support\SharedData\SharedDataServiceProvider::class
    б. Выполнить в консоли команду
        php artisan vandor:publish
    в. Добавить SharedDataMiddleware::class в файл app/Http/Kernel.php
       Вы можете добавить его ко всем роутам или только для определенных. 
       Я рекомендую добавлять его в переменную $routeMiddleware
        'shared-data' => SharedDataMiddleware::class
       И потом прописывать его как middleware для конкретных групп роутов.
       
       Например:
        Route::group(['middleware' => ['shared-data']], function() {
            Route::get('/', ['uses' => 'HomeController@index']);
            ......
        });
3. Сконфигурировать плагин.
    а. В папке app/Services должен появиться файл SharedDataService. 
       требуется заменить у него namespace на тот, который используется в вашем 
       проекте, чтоб избежать конфликта имён. 
        namespace App\Services;  
       В методе getData() этого класса вы 
       можете определить какие данные будут видны во всех темплейтах.
    б. В файле config/shared-data.php требуется добавить имя вашего сервиса
        'service' => App\Services\SharedDataService::class
    
    