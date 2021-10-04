<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($message, $code)
    {
        return response()->json(['error' => $message, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if ($collection->isEmpty()){
            return $this->successResponse(['data' => $collection]);
        }
        //TODO se usa la variable transformer del modelo, es importante mencionar que los transformer estan tipados a las respuestas de
        // | de los controladores, por es se debe de tener correctamente mapeado con las collections
        $transformer=$collection->first()->transformer;
        $collection=$this->transformerData($collection,$transformer);
        return $this->successResponse( $collection, $code);
    }

    protected function showOne(Model $instance, $code = 200)
    {
        $transformer=$instance->transformer;
        $instance=$this->transformerData($instance,$transformer);

        return $this->successResponse( $instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    /**
     * TODO metodo que realiza la transformacion de la respuesta
     * @param $data
     * @param $transformer
     * @return mixed
     */
    protected function transformerData($data,$transformer)
    {
        $transformation= fractal($data,new $transformer);
        return $transformation->toArray();
    }

}