<?php
require('./fpdf.php');
require_once __DIR__."../../../models/mainModel.php";

use app\models\mainModel;

class PDF extends FPDF
{
    public $conexion;

    // Constructor para inicializar la conexión a la base de datos
    function __construct()
    {
        parent::__construct();
        $this->conexion = (new mainModel())->conectar(); // Crear la conexión usando el método conectar()
    }

    // Cabecera de página
    function Header()
    {
        // Ahora usa la conexión desde el atributo $conexion
        $consulta_info = $this->conexion->query("SELECT * FROM proveedor ORDER BY documento_NIT ASC");
        $dato_info = $consulta_info->fetch(PDO::FETCH_OBJ);

        $this->Image('logo.png', 270, 5, 20); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
        $this->SetFont('Arial', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(95); // Movernos a la derecha
        $this->SetTextColor(0, 0, 0); //color
        //creamos una celda o fila
        $this->Cell(110, 15, utf8_decode('Pitbull Biker'), 1, 1, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
        $this->Ln(3); // Salto de línea
        $this->SetTextColor(103); //color
  
        /* UBICACION */
        $this->Cell(180);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(96, 10, utf8_decode("Ubicación : Soacha"), 0, 0, '', 0);
        $this->Ln(5);
  
        /* TELEFONO */
        $this->Cell(180);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(59, 10, utf8_decode("Teléfono : 322 796 7630"), 0, 0, '', 0);
        $this->Ln(5);
  
        /* COREEO */
        $this->Cell(180);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
        $this->Ln(5);
  
        /* TELEFONO */
        $this->Cell(180);  // mover a la derecha
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(85, 10, utf8_decode("Sucursal : Soacha"), 0, 0, '', 0);
        $this->Ln(10);
  
        /* TITULO DE LA TABLA */
        //color
        $this->SetTextColor(228, 100, 0);
        $this->Cell(100); // mover a la derecha
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(100, 10, utf8_decode("REPORTE DE PROVEEDORES"), 0, 1, 'C', 0);
        $this->Ln(7);

        /* CAMPOS DE LA TABLA */
        //color
        $this->SetFillColor(228, 100, 0); //colorFondo
        $this->SetTextColor(255, 255, 255); //colorTexto
        $this->SetDrawColor(163, 163, 163); //colorBorde
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(15, 10, utf8_decode('N°'), 1, 0, 'C', 1);
        $this->Cell(80, 10, utf8_decode('NOMBRE'), 1, 0, 'C', 1);
        $this->Cell(30, 10, utf8_decode('CEDULA'), 1, 0, 'C', 1);
        $this->Cell(80, 10, utf8_decode('DIRECION'), 1, 0, 'C', 1);
        $this->Cell(50, 10, utf8_decode('TELEFONO'), 1, 1, 'C', 1);
  
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

        $this->SetY(-15); // Posición: a 1,5 cm del final
        $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
        $hoy = date('d/m/Y');
        $this->Cell(540, 10, $hoy, 0, 0, 'C'); // pie de pagina(fecha de pagina)
    }
}

// Crear el objeto PDF y generar el reporte
$pdf = new PDF();
$pdf->AddPage("landscape"); 
$pdf->AliasNbPages(); 

$i = 0;
$pdf->SetFont('Arial', '', 12);
$pdf->SetDrawColor(163, 163, 163);

$consulta_reporte_asistencia = $pdf->conexion->query("SELECT * FROM proveedor ORDER BY documento_NIT ASC");

while ($datos_reporte = $consulta_reporte_asistencia->fetch(PDO::FETCH_OBJ)) {
    $i++;
    $pdf->Cell(15, 15, $i, 1, 0, 'C', 0);
    $pdf->Cell(80, 15, $datos_reporte->nom_proveedor . ' ' . $datos_reporte->apellido_sociedad, 1, 0, 'C', 0);
    $pdf->Cell(30, 15, $datos_reporte->documento_NIT, 1, 0, 'C', 0);
    $pdf->Cell(80, 15, $datos_reporte->direccion, 1, 0, 'C', 0);
    $pdf->Cell(50, 15, $datos_reporte->telefono, 1, 1, 'C', 0);
}  

$pdf->Output('Reporte Proveedor.pdf', 'I');