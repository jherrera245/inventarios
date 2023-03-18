<?php 
    require_once(dirname(__DIR__)."/config/config.php");
    require_once(PDF."fpdf.php");
    
    class PDF extends FPDF
    {

        public static $title = "";
        public static $practicante = "";
        public static $total = "";
        public static $date = "";

        public function Header() 
        {
            $this->SetFont('helvetica', 'B', 16); //tipo de fuente estilo y tamaño
            $this->Cell(80); //mover a la derecha del titulo
            $this->Cell(30, 10, $this::$title, 0, 0, 'C');
            $this->SetFont('helvetica', 'I', 13); //tipo de fuente estilo y tamaño
            $this->Ln(10); //saltos linea
            $this->Cell(80); //mover el segundo texto de titulo
            $this->Cell(30, 10, $this::$date, 0, 0, 'C');
            $this->Ln(10); //saltos linea
            $this->Cell(80); //mover el cuarto texto de titulo
            $this->Cell(30, 10, $this::$total, 0, 0, 'C');
            $this->Ln(15); //Saltos de linea 
        }

        public function Footer() {
            $this->Image(PDF.'line-firma.png', 70, 260, 70); //logo y dimenciones
            $this->SetY(-30); //Posicion a 1,5 cm del final
            $this->SetFont('helvetica', '', 11); //tipo de fuente estilo y tamaño
            $this->Cell(80); //mover el  tercer texto de titulo
            $this->Cell(30, 10, $this::$practicante, 0, 0, 'C');
            $this->SetFont('Arial', 'I', 8); //Tipo de letra
            $this->Ln(5); //saltos linea
            $this->Cell(0, 10, 'Pagina '.$this->PageNo().'/{nb}', 0, 0, 'C'); //numero de pagina
        }
    }
?>