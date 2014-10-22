<?php
class lancamentoModel extends CI_Model{
//    function listarTudo(){
//        $query = $this->db->get('conta');
//        return $query->result();
//    }
    function listarTudo($limite = 100, $start = 0){
        $this->db->limit($limite, $start);
        $this->db->select('lancamento.codigo,lancamento.data, '
                . 'lancamento.conta_codigo, lancamento.tipo, lancamento.descricao, lancamento.valor, lancamento.at_lancamento, conta.cancelada');
        $this->db->from('lancamento');
        
        if($this->uri->segment(3)){
            $this->db->join('conta', 'conta.codigo = lancamento.conta_codigo'
                    .' and conta.codigo = '. $this->uri->segment(3));
        }else{
            $this->db->join('conta', ' conta.codigo = lancamento.conta_codigo');
        }
        $query = $this->db->get();
        return $query->result();
        
    }
    function contarTudo(){
        $this->db->select('lancamento.codigo, lancamento.data, lancamento.conta_codigo, '
                . 'lancamento.tipo, lancamento.descricao, lancamento.valor, lancamento.at_lancamento');
        $this->db->from('lancamento');

        if ($this->uri->segment(3)) {
            $this->db->join('conta', 'conta.codigo = lancamento.conta_codigo'
                   .' and conta.codigo = ' . $this->uri->segment(3));
        } else {
            $this->db->join('conta', ' conta.codigo = lancamento.conta_codigo');
        }
        $this->db->get();
        return $this->db->affected_rows();
    
    }
    function buscar_pelo_codigo($codigo){
       $this->db->where('codigo', $codigo);
       $query = $this->db->get('lancamento');
        return $query->row(0);
   }
    function buscaMovimento($conta){
        $this->db->from('lancamento');
        $this->db->where('conta_codigo',$conta);
        $this->db->where('at_lancamento <> ', 'S');
        $this->db->where('data <= ', date('Y-m-d'));
        $query = $this->db->get();
        return $query->result();
    }
    
    function consultaLancamento(){
       $this->db->select('lancamento.codigo, lancamento.data, lancamento.conta_codigo, lancamento.valor, lancamento.at_lancamento');
        $this->db->from('lancamento'); 
            $this->db->join('conta', 'conta.codigo = lancamento.conta_codigo'
                    .' and conta.codigo = '. $this->uri->segment(3));
        $query = $this->db->get();
        return $query->result();
    }
    
    function consultaAgendamento($data){
        $this->db->select('lancamento.data');
        $this->db->from('lancamento'); 
        $this->db->where('lancamento.data >', $data);
            $this->db->join('conta', 'conta.codigo = lancamento.conta_codigo'
                    .' and conta.codigo = '. $this->uri->segment(3));
        $query = $this->db->get();
        return $this->db->affected_rows();
    }
    
    function inserir($inf = array()){
        $this->db->insert('lancamento', $inf);
        return $this->db->affected_rows();
    }
    
    function alterar($dados = array()){
        if(isset($dados['data'])){
            $this->db->set('data', $dados['data']);
        }
        if(isset($dados['conta_codigo'])){
            $this->db->set('conta_codigo', $dados['conta_codigo']);
        }
        if(isset($dados['tipo'])){
            $this->db->set('tipo', $dados['tipo']);
        }
        if(isset($dados['descricao'])){
            $this->db->set('descricao', $dados['descricao']);
        }
        if(isset($dados['valor'])){
            $this->db->set('valor', $dados['valor']);
        }
        if(isset($dados['at_lancamento'])){
            $this->db->set('at_lancamento', $dados['at_lancamento']);
        }
        
        $this->db->where('codigo', $this->uri->segment(3));
        $this->db->update('lancamento');
        return $this->db->affected_rows();
    }
    
    //função para atualizar colocar um SIM ou NAO no campo AT_LANCAMENTO````````````````````````
    function gravarMovimento($lancamento, $codigo) {
        $this->db->set('at_lancamento', $lancamento);
        $this->db->where('codigo', $codigo);
        $this->db->update('lancamento');
        return $this->db->affected_rows();
    }
    function eliminar(){
        $this->db->where('codigo', $this->uri->segment(3));
        $this->db->delete('lancamento');
        return $this->db->affected_rows();
    }
    
    function buscar_pela_data($data){
       $this->db->where('data', $data);
       $query = $this->db->get('lancamento');
        return $query->row(0);
   }
   
}
