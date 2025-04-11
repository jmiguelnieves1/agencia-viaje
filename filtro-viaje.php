<?php
class FiltroViaje {
    private $nombreHotel;
    private $ciudad;
    private $pais;
    private $fechaViaje;
    private $duracion;
    private $precioMax;

    public function __construct($nombreHotel = '', $ciudad = '', $pais = '', 
                              $fechaViaje = '', $duracion = 0, $precioMax = 0) {
        $this->nombreHotel = $nombreHotel;
        $this->ciudad = $ciudad;
        $this->pais = $pais;
        $this->fechaViaje = $fechaViaje;
        $this->duracion = $duracion;
        $this->precioMax = $precioMax;
    }

    public function filtrarDestinos($destinos) {
        return array_filter($destinos, function($destino) {
            $matchHotel = empty($this->nombreHotel) || 
                        stripos($destino['hotel'], $this->nombreHotel) !== false;
            $matchCiudad = empty($this->ciudad) || 
                        strcasecmp($destino['ciudad'], $this->ciudad) === 0;
            $matchPais = empty($this->pais) || 
                        strcasecmp($destino['pais'], $this->pais) === 0;
            $matchFecha = empty($this->fechaViaje) || 
                        $destino['fecha'] === $this->fechaViaje;
            $matchDuracion = $this->duracion <= 0 || 
                        $destino['duracion'] >= $this->duracion;
            $matchPrecio = $this->precioMax <= 0 || 
                        $destino['precio'] <= $this->precioMax;
            
            return $matchHotel && $matchCiudad && $matchPais && 
                   $matchFecha && $matchDuracion && $matchPrecio;
        });
    }
}
?>