<?php 
    class PerfilModel{
        protected $db;
        protected $perfil;
        public function __construct(){
            $this->db = Conectar::Conectar();
            $this->perfil = array();
        }
        public function cambiar($id, $data){
            $consulta = "UPDATE tb_usuario SET Contraseña = '" . $data["pass"] . "'
                                                where Usuario = '$id'";
            $this->db->query($consulta);
        }
        

    }

?>