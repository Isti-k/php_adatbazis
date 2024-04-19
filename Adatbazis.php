<?php
class Adatbazis{
    //adattagok
    private $host = "localhost";
    private $felhasznaloNev = "root";
    private $jelszo = "";
    private $adatbazis = "magyarkartya";
    private $kapcsolat;
    //konstruktor
    public function __construct()
    {
        $this->kapcsolat = new mysqli(
            $this->host,
            $this->felhasznaloNev,
            $this->jelszo,
            $this->adatbazis
        );
        $siker = 0;
        if($this->kapcsolat->connect_errno){
            $siker = "Nem sikerült a kapcsolat";
        }
        else
            $siker = "Sikerült a kapcsolat";
        //echo $siker;
        $this->kapcsolat->query("SET NAMES UTF8");
    }
    //metódusok
    public function adatLeker($oszlop, $tabla){
        $sql = "SELECT $oszlop from $tabla";
        return $this->kapcsolat->query($sql);
    }
    public function megjelenit($matrix){
        while ($sor = $matrix->fetch_row()){
            echo "<img src=\"forras/$sor[0]\" alt=\"forras/$sor[0]\">";
        }
    }

    public function adatLeker2($oszlop1,$oszlop2, $tabla){
        $sql = "SELECT $oszlop1, $oszlop2 from $tabla";
        return $this->kapcsolat->query($sql);
    }
    public function megjelenit2($matrix){
        echo "<table>";
        echo "<tr><th>Név</th><th>Kép</th></tr>";
        while ($sor = $matrix->fetch_row()){ 
            echo "<tr><td>$sor[0]</td><td><img src=\"forras/$sor[1]\" alt=\"forras/$sor[0]\"></td></tr>";
        }
        echo "</table>";
    }

    public function rekordokSzama($tabla){
        $sql = "SELECT * FROM $tabla";
        return $this->kapcsolat->query($sql)->num_rows;
    }
    public function kartyaFeltolt(){
        $szinOsszeg = $this->rekordokSzama("szin")+1;
        $formaOsszeg = $this->rekordokSzama("forma")+1;
        for ($szinIndex = 1; $szinIndex < $szinOsszeg; $szinIndex++) { 
            for ($formaIndex= 1; $formaIndex < $formaOsszeg; $formaIndex++) { 
                $sql = "INSERT INTO kartya(szinAzon, formaAzon) VALUES ('$szinIndex','$formaIndex')";
                $this->kapcsolat->query($sql);
            }
        }
    }
    public function kapcsolatBezar(){
        $this->kapcsolat->close();
    }
}
?>