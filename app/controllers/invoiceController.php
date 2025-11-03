<?php

namespace app\controllers;

use app\models\mainModel;

class invoiceController extends mainModel
{

    public function registrarFacturaControlador()
    {

        $cliente_id = $this->limpiarCadena($_POST['cliente_id'] ?? '');
        $factura_total = 0;

        $ids   = $_POST['producto_id'] ?? [];
        $codigos   = $_POST['producto_codigo'] ?? [];
        $nombres   = $_POST['producto_nombre'] ?? [];
        $precios   = $_POST['producto_precio'] ?? [];
        $cantidades = $_POST['producto_cantidad'] ?? [];

        $productos = [];

        for ($i = 0; $i < count($codigos); $i++) {
            $id = $this->limpiarCadena($ids[$i]);
            $codigo = $this->limpiarCadena($codigos[$i]);
            $nombre = $this->limpiarCadena($nombres[$i]);
            $precio = floatval($precios[$i]);
            $cantidad = intval($cantidades[$i]);

            if ($codigo && $nombre && $precio > 0 && $cantidad > 0) {
                $productos[] = [
                    'id' => $id,
                    'codigo' => $codigo,
                    'nombre' => $nombre,
                    'precio' => $precio,
                    'cantidad' => $cantidad,
                    'subtotal' => $precio * $cantidad
                ];
            }
            $factura_total += $precio * $cantidad;
        }

        if ($cliente_id == "" || empty($ids) || empty($codigos) || empty($nombres) || empty($precios) || empty($cantidades)) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No has llenado todos los campos que son obligatorios",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $check_cliente = $this->ejecutarConsulta("SELECT cliente_id FROM cliente WHERE cliente_id='$cliente_id'");
        if ($check_cliente->rowCount() == 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "El CLIENTE ingresado no se encuentra registrado, por favor elija otro",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $factura_datos_reg = [
            [
                "campo_nombre" => "cliente_id",
                "campo_marcador" => ":Cliente_id",
                "campo_valor" => $cliente_id
            ],
            [
                "campo_nombre" => "factura_total",
                "campo_marcador" => ":Factura_total",
                "campo_valor" => $factura_total
            ],
            [
                "campo_nombre" => "factura_fecha",
                "campo_marcador" => ":Factura_fecha",
                "campo_valor" => date("Y-m-d H:i:s")
            ]
        ];

        $registrar_factura = $this->guardarDatos("factura", $factura_datos_reg);
        $factura_id = $registrar_factura['id'];

        if (!is_numeric($factura_id) || $factura_id <= 0) {
            $alerta = [
                "tipo" => "simple",
                "titulo" => "Error al guardar",
                "texto" => "No se pudo obtener el ID de la factura",
                "icono" => "error"
            ];
            return json_encode($alerta);
        }

        $detalles_guardados = 0;

        foreach ($productos as $producto) {
            $detalle_factura_datos_reg = [
                [
                    "campo_nombre" => "factura_id",
                    "campo_marcador" => ":Factura_id",
                    "campo_valor" => $factura_id
                ],
                [
                    "campo_nombre" => "producto_id",
                    "campo_marcador" => ":Producto_id",
                    "campo_valor" => $producto['id']
                ],
                [
                    "campo_nombre" => "detalle_factura_cantidad",
                    "campo_marcador" => ":Detalle_factura_cantidad",
                    "campo_valor" => $producto['cantidad']
                ],
                [
                    "campo_nombre" => "detalle_factura_precio_unitario",
                    "campo_marcador" => ":Detalle_factura_precio_unitario",
                    "campo_valor" => $producto['precio']
                ],
                [
                    "campo_nombre" => "detalle_factura_subtotal",
                    "campo_marcador" => ":Detalle_factura_subtotal",
                    "campo_valor" => $producto['subtotal']
                ],
            ];

            $registrar_detalle_factura = $this->guardarDatos("detalle_factura", $detalle_factura_datos_reg);
            if ($registrar_detalle_factura['stmt']->rowCount() == 1) {
                $detalles_guardados++;
            }
        };


        if ($registrar_factura['stmt']->rowCount() == 1 && $detalles_guardados == count($productos)) {
            $alerta = [
                "tipo" => "limpiar",
                "titulo" => "Factura registrada",
                "texto" => "La factura se registro con exito",
                "icono" => "success"
            ];
        } else {

            $alerta = [
                "tipo" => "simple",
                "titulo" => "Ocurrió un error inesperado",
                "texto" => "No se pudo registrar la factura, por favor intente nuevamente",
                "icono" => "error"
            ];
        }

        return json_encode($alerta);
    }
}
