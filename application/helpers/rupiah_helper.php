<?php
function rupiah($angka){
    $rupiah=number_format($angka,0,',','.');
    return "Rp ".$rupiah;
}
function bilanganbulat($teks) { 
    $teks=preg_replace("/[^0-9]/", "", $teks);
    return $teks;
}
function tgl_indo($date) {  
    $BulanIndo = array("Januari", "Februari", "Maret",
    "April", "Mei", "Juni",
    "Juli", "Agustus", "September",
    "Oktober", "November", "Desember"); 
    $tahun = substr($date, 0, 4); 
    $bulan = substr($date, 5, 2);  
    $tgl   = substr($date, 8, 2);   
    $result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;
    return($result);
} 
