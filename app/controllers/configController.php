<?php

namespace app\controllers;

use app\models\mainModel;

class configController extends mainModel
{

    public function actualizarConfiguracionControlador()
    {
        $id = 1;
        $datos = $this->ejecutarConsulta("SELECT * FROM configuracion WHERE configuracion_id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado las configuraciones en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
        } else {
            $datos = $datos->fetch();
        }

        $nombre = $this->limpiarCadena($_POST['configuracion_nombre']);
        $telefono = $this->limpiarCadena($_POST['configuracion_telefono']);
        $direccion = $this->limpiarCadena($_POST['configuracion_direccion']);
        $email = $this->limpiarCadena($_POST['configuracion_email']);
        $cuit = $this->limpiarCadena($_POST['configuracion_cuit']);
        $inicio_actividad = $this->limpiarCadena($_POST['configuracion_inicio_actividad']);

        if ($nombre == "" || $telefono == "" || $direccion == "" || $cuit == "" || $inicio_actividad == "" || $email == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($this->verificarDatos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ .-]{3,60}", $nombre)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El NOMBRE no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($this->verificarDatos("\+?[0-9]{1,3}[ ]?[0-9]{2,4}[ ]?[0-9]{3,4}[ ]?[0-9]{3,4}", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El TELEFONO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }


        if ($this->verificarDatos("\d{2}-\d{8}-\d{1}", $cuit)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El CUIT no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        # Verificando email #
        if ($email != "" && $datos['configuracion_email'] != $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $check_email = $this->ejecutarConsulta("SELECT configuracion_email FROM configuracion WHERE configuracion_email='$email'");
                if ($check_email->rowCount() > 0) {
                    $alerta = [
                        "tipo" => "simple",
                        "titulo" => "Ocurrió un error inesperado",
                        "texto" => "El EMAIL que acaba de ingresar ya se encuentra registrado en el sistema, por favor verifique e intente nuevamente",
                        "icono" => "error"
                    ];
                    return json_encode($alerta);
                }
            } else {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "Ha ingresado un correo electrónico no valido",
                    "icono" => "error"
                ];
                return json_encode($alerta);
            }
        }


        $configuracion_datos_up = [
            [
                "campo_nombre" => "configuracion_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ],
            [
                "campo_nombre" => "configuracion_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "configuracion_direccion",
                "campo_marcador" => ":Direccion",
                "campo_valor" => $direccion
            ],
            [
                "campo_nombre" => "configuracion_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ],
            [
                "campo_nombre" => "configuracion_cuit",
                "campo_marcador" => ":Cuit",
                "campo_valor" => $cuit
            ],
            [
                "campo_nombre" => "configuracion_inicio_actividad",
                "campo_marcador" => ":Inicio_actividad",
                "campo_valor" => $inicio_actividad
            ]
        ];

        $condicion = [
            "condicion_campo" => "configuracion_id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("configuracion", $configuracion_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Configuracion actualizada",
                "texto" => "Los datos de la empresa " . $datos['configuracion_nombre'] . " se actualizaron correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos de la empresa " . $datos['configuracion_nombre'] . ", por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    public function eliminarFotoConfiguracionControlador()
    {

        $id = 1;

        $datos = $this->ejecutarConsulta("SELECT * FROM configuracion WHERE configuracion_id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado las configuraciones en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
        } else {
            $datos = $datos->fetch();
        }

        $img_dir = "../views/fotos/";

        chmod($img_dir, 0777);

        if (is_file($img_dir . $datos['configuracion_logo'])) {

            chmod($img_dir . $datos['configuracion_logo'], 0777);

            if (!unlink($img_dir . $datos['configuracion_logo'])) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "Error al intentar eliminar el logo de la empresa, por favor intente nuevamente",
                    "icono" => "error"
                ];
                return json_encode($alerta);
            }
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el logo de la empresa en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $configuracion_datos_up = [
            [
                "campo_nombre" => "configuracion_logo",
                "campo_marcador" => ":Logo",
                "campo_valor" => ""
            ]
        ];

        $condicion = [
            "condicion_campo" => "configuracion_id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("configuracion", $configuracion_datos_up, $condicion)) {


            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Logo eliminado",
                "texto" => "El logo de la empresa  " . $datos['configuracion_nombre'] . " se elimino correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Logo eliminado",
                "texto" => "No hemos podido actualizar algunos datos de la configuracion " . $datos['configuracion_nombre'] . ", sin embargo la foto ha sido eliminada correctamente",
                "icono" => "warning"
            ];
        }

        return json_encode($alerta);
    }

    public function actualizarFotoConfiguracionControlador()
    {

        $id = 1;

        $datos = $this->ejecutarConsulta("SELECT * FROM configuracion WHERE configuracion_id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado la configuracion en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
        } else {
            $datos = $datos->fetch();
        }

        $img_dir = "../views/fotos/";

        if ($_FILES['configuracion_logo']['name'] == "" && $_FILES['configuracion_logo']['size'] <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No ha seleccionado una foto para el configuracion",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if (!file_exists($img_dir)) {
            if (!mkdir($img_dir, 0777)) {
                $alerta = [
                    "tipo" => "simple",
                    "titulo" => "Ocurrió un error inesperado",
                    "texto" => "Error al crear el directorio",
                    "icono" => "error"
                ];
                return json_encode($alerta);
            }
        }

        if (mime_content_type($_FILES['configuracion_logo']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['configuracion_logo']['tmp_name']) != "image/png") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La imagen que ha seleccionado es de un formato no permitido",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if (($_FILES['configuracion_logo']['size'] / 1024) > 5120) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "La imagen que ha seleccionado supera el peso permitido",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($datos['configuracion_logo'] != "") {
            $foto = explode(".", $datos['configuracion_logo']);
            $foto = $foto[0];
        } else {
            $foto = str_ireplace(" ", "_", $datos['configuracion_nombre']);
            $foto = $foto . "_" . rand(0, 100);
        }

        switch (mime_content_type($_FILES['configuracion_logo']['tmp_name'])) {
            case 'image/jpeg':
                $foto = $foto . ".jpg";
                break;
            case 'image/png':
                $foto = $foto . ".png";
                break;
        }

        chmod($img_dir, 0777);

        if (!move_uploaded_file($_FILES['configuracion_logo']['tmp_name'], $img_dir . $foto)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No podemos subir la imagen al sistema en este momento",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if (is_file($img_dir . $datos['configuracion_logo']) && $datos['configuracion_logo'] != $foto) {
            chmod($img_dir . $datos['configuracion_logo'], 0777);
            unlink($img_dir . $datos['configuracion_logo']);
        }

        $configuracion_datos_up = [
            [
                "campo_nombre" => "configuracion_logo",
                "campo_marcador" => ":Foto",
                "campo_valor" => $foto
            ]
        ];

        $condicion = [
            "condicion_campo" => "configuracion_id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("configuracion", $configuracion_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Logo actualizado",
                "texto" => "El logo de la empresa " . $datos['configuracion_nombre'] . " se actualizo correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Logo actualizado",
                "texto" => "No hemos podido actualizar algunos datos de la empresa " . $datos['configuracion_nombre'] . ", sin embargo el logo ha sido actualizada",
                "icono" => "warning"
            ];
        }

        return json_encode($alerta);
    }
}
