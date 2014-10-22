<?php

class contaModel extends CI_Model {

   
    function listarTudo($limite = 100, $start = 0){
        $this->db->limit($limite, $start);
        $this->db->select('conta.id, conta.agencia, conta.data_criacao, '
                . 'conta.senha, conta.saldo');
        $this->db->from('conta');

        $query = $this->db->get();
        return $query->result();
    }
    
    function contarTudo(){
        $this->db->select('conta.id, conta.agencia, conta.data_criacao, '
                . 'conta.senha, conta.saldo');
        $this->db->from('conta');

        $this->db->get();
        return $this->db->affected_rows();
    
    }
    function buscaMovimento(){
        $this->db->from('lancamento');
        $this->db->where('conta_codigo');
        $this->db->where('at_lancamento <> ', 'S');
        $this->db->where('data <= ', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }

    function consultaConta() {
        $this->db->select('conta.id, conta.saldo');
        $this->db->from('conta');
        $query = $this->db->get();
        return $query->result();
    }

    function listarTudo2() {
        $this->db->select('conta.id, conta.agencia, conta.data_criacao, '
                . 'conta.senha, conta.saldo');
        $this->db->from('conta');

        $query = $this->db->get();
        return $query->result();
    }

    function inserir($inf = array()) {
        $this->db->insert('conta', $inf);
        return $this->db->affected_rows();
    }

    function alterar($dados = array()) {
        if (isset($dados['agencia'])) {
            $this->db->set('agencia', $dados['agencia']);
        }
        if (isset($dados['data_criacao'])) {
            $this->db->set('data_criacao', $dados['data_criacao']);
        }
        if (isset($dados['senha'])) {
            $this->db->set('senha', $dados['senha']);
        }
        if (isset($dados['saldo'])) {
            $this->db->set('saldo', $dados['saldo']);
        }
        $this->db->where('id', $this->uri->segment(3));
        $this->db->update('conta');
        return $this->db->affected_rows();
    }

    function gravarSaldo($conta, $saldo) {
        $this->db->set('saldo', $saldo);
        $this->db->where('id', $conta);
        $this->db->update('conta');
        return $this->db->affected_rows();
    }

    function eliminar() {
        $this->db->where('id', $this->uri->segment(3));
        $this->db->delete('conta');
        return $this->db->affected_rows();
    }

    function buscar_pelo_codigo($codigo) {
        $this->db->where('id', $codigo);
        $query = $this->db->get('conta');
        return $query->row(0);
    }

}
