<?php

namespace app\contoller;

use app\models\viewsModel;

class viewsController extends viewsModel
{
    public function obtenerVistasContolador($vista)
    {
        if (!$vista == "") {
            $respuesta = $this->obtenerVistasModelo($vista);
        }

        return $respuesta;
    }
}
