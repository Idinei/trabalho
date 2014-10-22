<?php

class acessoModel extends CI_Model {

    function valida_usuario($dados = array()) {
        $this->db->where('conta', $dados['conta']);
        $query = $this->db->get('usuario');
        return $query->row(0);
    }

    function inserir_acesso($inf = array()) {
        $this->db->insert('acessos', $inf);
        return $this->db->affected_rows();
    }
    
    function buscar_erros($usuario_codigo){
        $this->db->where('usuario_codigo', $usuario_codigo);
        $this->db->where('erro', 'S');
        $this->db->where('datahora >= ', date('Y-m-d').' 00:00:00');
        $this->db->where('datahora <= ', date('Y-m-d').' 23:59:59');
        $this->db->from('acessos');
        $this->db->get('usuario');
        return $this->db->affected_rows();
    }
    
    function bloquear($usuario_codigo){
        $this->db->set('inativo', 'S');
        $this->db->where('codigo', $usuario_codigo);
        $this->db->update('usuario');
        return $this->db->affected_rows();
        
    }

}


