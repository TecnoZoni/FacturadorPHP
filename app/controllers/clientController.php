<?php

namespace app\controllers;

use app\models\mainModel;


class clientController extends mainModel
{
    public function registrarClienteControlador()
    {

        $nombre = $this->limpiarCadena($_POST['cliente_nombre']);
        $apellido = $this->limpiarCadena($_POST['cliente_apellido']);
        $telefono = $this->limpiarCadena($_POST['cliente_telefono']);
        $email = $this->limpiarCadena($_POST['cliente_email']);

        if ($nombre == "" || $apellido == "" || $telefono == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }


        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El NOMBRE no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El APELLIDO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($this->verificarDatos("^\+?[0-9]{1,3}[ ]?[0-9]{2,4}[ ]?[0-9]{3,4}[ ]?[0-9]{3,4}$", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El TELEFONO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }



        if ($email != "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $check_email = $this->ejecutarConsulta("SELECT cliente_email FROM cliente WHERE cliente_email='$email'");
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

        $cliente_datos_reg = [
            [
                "campo_nombre" => "cliente_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ],
            [
                "campo_nombre" => "cliente_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellido
            ],
            [
                "campo_nombre" => "cliente_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "cliente_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ]
        ];

        $registrar_cliente = $this->guardarDatos("cliente", $cliente_datos_reg);

        if ($registrar_cliente->rowCount() == 1) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Cliente registrado",
                "texto" => "El Cliente " . $nombre . " " . $apellido . " se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar el cliente, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    public function listarClienteControlador($pagina, $registros, $url, $busqueda)
    {

        $pagina = $this->limpiarCadena($pagina);
        $registros = $this->limpiarCadena($registros);

        $url = $this->limpiarCadena($url);
        $url = APP_URL . $url . "/";

        $busqueda = $this->limpiarCadena($busqueda);
        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int) $pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {

            $consulta_datos = "SELECT * FROM cliente WHERE (cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%') ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";

            $consulta_total = "SELECT COUNT(cliente_id) FROM cliente WHERE (cliente_nombre LIKE '%$busqueda%' OR cliente_apellido LIKE '%$busqueda%' OR cliente_email LIKE '%$busqueda%' OR cliente_telefono LIKE '%$busqueda%')";
        } else {

            $consulta_datos = "SELECT * FROM cliente ORDER BY cliente_nombre ASC LIMIT $inicio,$registros";

            $consulta_total = "SELECT COUNT(cliente_id) FROM cliente";
        }

        $datos = $this->ejecutarConsulta($consulta_datos);
        $datos = $datos->fetchAll();

        $total = $this->ejecutarConsulta($consulta_total);
        $total = (int) $total->fetchColumn();

        $numeroPaginas = ceil($total / $registros);

        $tabla .= '
    <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th colspan="3">Opciones</th>
            </tr>
        </thead>
        <tbody>
';

        if ($total >= 1 && $pagina <= $numeroPaginas) {
            $contador = $inicio + 1;
            $pag_inicio = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
            <tr>
                <td>' . $contador . '</td>
                <td>' . $rows['cliente_nombre'] . '</td>
                <td>' . $rows['cliente_apellido'] . '</td>
                <td>' . $rows['cliente_telefono'] . '</td>
                <td>' . $rows['cliente_email'] . '</td>
                <td>
                    <a href="' . APP_URL . 'clientView/' . $rows['cliente_id'] . '/" class="btn btn-info btn-sm">Ver</a>
                </td>
                <td>
                    <a href="' . APP_URL . 'clientUpdate/' . $rows['cliente_id'] . '/" class="btn btn-success btn-sm">Actualizar</a>
                </td>
                <td>
                    <form class="FormularioAjax" action="' . APP_URL . 'app/ajax/clienteAjax.php" method="POST" autocomplete="off">
                        <input type="hidden" name="modulo_cliente" value="eliminar">
                        <input type="hidden" name="cliente_id" value="' . $rows['cliente_id'] . '">
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </td>
            </tr>
        ';
                $contador++;
            }
            $pag_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla .= '
            <tr>
                <td colspan="8">
                    <a href="' . $url . '1/" class="btn btn-primary mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
            } else {
                $tabla .= '
            <tr>
                <td colspan="8">No hay registros en el sistema</td>
            </tr>
        ';
            }
        }

        $tabla .= '</tbody></table></div>';

        if ($total > 0 && $pagina <= $numeroPaginas) {
            $tabla .= '<p class="text-end">Mostrando clientes <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
            $tabla .= $this->paginadorTablas($pagina, $numeroPaginas, $url, 7);
        }

        return $tabla;
    }

    public function eliminarClienteControlador()
    {

        $id = $this->limpiarCadena($_POST['cliente_id']);



        $datos = $this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el cliente en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
        } else {
            $datos = $datos->fetch();
        }

        $eliminarCliente = $this->eliminarRegistro("cliente", "cliente_id", $id);

        if ($eliminarCliente->rowCount() == 1) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Cliente eliminado",
                "texto" => "El cliente " . $datos['cliente_nombre'] . " " . $datos['cliente_apellido'] . " ha sido eliminado del sistema correctamente",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido eliminar el cliente " . $datos['cliente_nombre'] . " " . $datos['cliente_apellido'] . " del sistema, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }

    public function actualizarClienteControlador()
    {

        $id = $this->limpiarCadena($_POST['cliente_id']);


        $datos = $this->ejecutarConsulta("SELECT * FROM cliente WHERE cliente_id='$id'");
        if ($datos->rowCount() <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos encontrado el cliente en el sistema",
                "icono" => "error"
            ];
            return json_encode($alerta);
        } else {
            $datos = $datos->fetch();
        }

        $nombre = $this->limpiarCadena($_POST['cliente_nombre']);
        $apellido = $this->limpiarCadena($_POST['cliente_apellido']);
        $telefono = $this->limpiarCadena($_POST['cliente_telefono']);
        $email = $this->limpiarCadena($_POST['cliente_email']);

        if ($nombre == "" || $apellido == "" || $telefono == "") {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }


        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El NOMBRE no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($this->verificarDatos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El APELLIDO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        if ($this->verificarDatos("^\+?[0-9]{1,3}[ ]?[0-9]{2,4}[ ]?[0-9]{3,4}[ ]?[0-9]{3,4}$", $telefono)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El TELEFONO no coincide con el formato solicitado",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }



        if ($email != "") {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $check_email = $this->ejecutarConsulta("SELECT cliente_email FROM cliente WHERE cliente_email='$email'");
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

        $cliente_datos_up = [
            [
                "campo_nombre" => "cliente_nombre",
                "campo_marcador" => ":Nombre",
                "campo_valor" => $nombre
            ],
            [
                "campo_nombre" => "cliente_apellido",
                "campo_marcador" => ":Apellido",
                "campo_valor" => $apellido
            ],
            [
                "campo_nombre" => "cliente_telefono",
                "campo_marcador" => ":Telefono",
                "campo_valor" => $telefono
            ],
            [
                "campo_nombre" => "cliente_email",
                "campo_marcador" => ":Email",
                "campo_valor" => $email
            ]
        ];

        $condicion = [
            "condicion_campo" => "cliente_id",
            "condicion_marcador" => ":ID",
            "condicion_valor" => $id
        ];

        if ($this->actualizarDatos("cliente", $cliente_datos_up, $condicion)) {

            $alerta = [
                "tipo" => "recargar",
                "titulo" => "Cliente actualizado",
                "texto" => "Los datos del cliente " . $datos['cliente_nombre'] . " " . $datos['cliente_apellido'] . " se actualizaron correctamente",
                "icono" => "success"
            ];
        } else {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No hemos podido actualizar los datos del cliente " . $datos['cliente_nombre'] . " " . $datos['cliente_apellido'] . ", por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}
