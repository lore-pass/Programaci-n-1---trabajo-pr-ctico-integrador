<?php

require_once 'Usuario.php';
require_once '.env.php';
require_once 'Anuncio.php';

class RepositorioAnuncios
{
    
    private $conexion;

    public function __construct() {
        $credenciales = credenciales();
        $this->conexion = new mysqli($credenciales['servidor'], $credenciales['usuario'], $credenciales['clave'], $credenciales['base_de_datos']);
        if ($this->conexion->connect_error) {
            die("Conexión fallida: " . $this->conexion->connect_error);
        }
    }
      
    public function leer() {
        $anuncios = [];
        $sql = "SELECT id, titulo, texto, fecha_publicacion, usuarios_id FROM anuncios WHERE vigente = 1";
        $result = $this->conexion->query($sql);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $anuncio = new Anuncio($row['titulo'], $row['texto'], $row['fecha_publicacion'], $row['usuarios_id'], [], $row['id']);
                $anuncios[] = $anuncio;
            }
        }
        return $anuncios;
    }

        // SELECT a.id, a.titulo, a.texto, a.fecha_publicacion, a.usuarios_id
        // FROM anuncios a
        // JOIN anuncios_comisiones ac ON a.id = ac.comisiones_id
        // WHERE a.vigente = 1 AND ac.comisiones_id = ?;
    
        public function guardar(Anuncio $anuncio) {
            
            $sql = "INSERT INTO anuncios (titulo, texto, fecha_publicacion, vigente, usuarios_id) ";
            $sql.= " VALUES (?, ?, NOW(), 1, ?)";
            $query = self::$conexion->prepare($sql);
            $titulo = $anuncio->titulo;
            $texto = $anuncio->texto;
            $id_usuario = $anuncio->id_usuario;
            $query->bind_param("ssi", $titulo, $texto, $id_usuario);
            if ($query->execute())  {
                $id = self::$conexion->insert_id;
                $anuncio->setId($id);
                $query->close();
                foreach ($anuncio->comisiones as $unaComision) {
                    $sql = "INSERT INTO anuncios_comisiones (anuncios_id, comisiones_id) ";
                    $sql.= "VALUES (?, ?)";
                    $query = self::$conexion->prepare($sql);
                    $query->bind_param("ii", $id, $unaComision);
                    $query->execute();
                    $query->close();
                }
                return true;
            } else {
                return false;
            }
        }
               
        // UPDATE anuncios SET vigente = ? WHERE id = ?;   -- vigente puede ser 0 o 1.
        
        // DELETE FROM anuncios WHERE id = ?
        
}

// SELECT id, titulo, texto, fecha_publicacion, usuarios_id
        // FROM anuncios
        // WHERE vigente = 1;