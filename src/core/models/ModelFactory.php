<?php

namespace App\Core\Models;

use App\Core\App;

class ModelFactory
{
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        if (App::get('config')['debug']) {
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * Construct the model
     * 
     * @param string $model - name of the model to construct. (Should exists in the App\Models namespace)
     * @return Model $model_object - specified model object
     */
    public function make($model)
    {
        $model_name = $model;
        $model = "App\\Models\\{$model}";
        $table_name = sqlify($model_name);
        $model = new $model($this->pdo, $table_name);

        if (is_subclass_of($model, "Model")) {
            throw new \Exception(
                "{$model_name} does not extend from the Model class."
            );
        }

        return $model;
    }
}
