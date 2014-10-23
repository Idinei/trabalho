<?php

class lancamentoController extends CI_Controller {

    public function index() {
        $this->listar();
    }

    public function index2() {
        $this->listar2();
    }

    public function listar() {
        $this->load->model('lancamentoModel');
        $pagina = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $dados = array(
            'lancamentos' => $this->lancamentoModel->listarTudo(numRegPagina(), $pagina),
            'paginacao' => criaPaginacao(
                    'lancamentoController', $this->lancamentoModel->contarTudo(), $this->uri->segment(3), 4),
            'titulo' => "Lista de lançamentos");
        $this->load->view('lancamentoView', $dados);
    }

    public function listar2() {
        $this->load->model('lancamentoModel');
        $pagina = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $dados = array(
            'lancamentos' => $this->lancamentoModel->listarTudo(numRegPagina2(), $pagina),
            'paginacao' => criaPaginacao(
                    'lancamentoController', $this->lancamentoModel->contarTudo(), $this->uri->segment(3), 4),
            'titulo' => "Lista de lançamentos");
        $this->load->view('relatorioView', $dados);
    }

    function novo() {
        $this->load->model('lancamentoModel');
        $dados['titulo'] = "Cadastro de Lançamentos";
        $dados['lancamentos'] = $this->lancamentoModel->listarTudo();
        $dados['contas'] = $this->listar_contas();
//        $dados['tipos'] = $this->tipo();
//        $dados['atualizado'] = $this->at_lancamento();
        if ($this->uri->segment(3)) {
            $dados['lancamentoAtual'] = $this->uri->segment(3);
        }
        $this->load->view('lancamentoFormView', $dados);
    }

    function inserir_lancamento() {
        $this->load->model('lancamentoModel');
        $inf = array(
            'id' => $this->input->post('codigo'),
            'data' => $this->input->post('data'),
            'conta_codigo' => $this->input->post('conta_codigo'),
//            'tipo' => $this->input->post('tipo'),
//            'descricao' => $this->input->post('descricao'),
            'valor' => $this->input->post('valor'),
            'at_lancamento' => 'N',
        );

        $inf['data'] = implode('-', array_reverse(explode('/', $inf['data'])));
        $this->load->model('contaModel');
        $this->load->model('lancamentoModel');
        $conta = $this->contaModel->buscar_pelo_codigo($inf['conta_codigo']);
        
            if ($this->lancamentoModel->inserir($inf)) {
                $inf['acao'] = 'I';
                $this->alterarSaldo($inf);
                $this->session->set_flashdata('msg', 'Criado com sucesso!');
            }
        
        redirect('lancamentoController/index/' . $_POST['conta_codigo']);
    }

    function alterarSaldo($inf = array()) {
        $this->load->model('contaModel');
        $this->load->model('lancamentoModel');

        $conta = $this->contaModel->buscar_pelo_codigo($inf['conta_codigo']);
        $saldo = $conta->saldo;

//        $lancamentos2 = $this->lancamentoModel->consultaAgendamento(date('Y-m-d'));
//        if($lancamentos2 == 0) {
        if ($inf['acao'] == 'I') { //inclusao
            if ($inf['data'] == date('Y-m-d')) {
                if ($inf['tipo'] == 'C') {
                    $saldo += $inf['valor'];
                } else {
                    $saldo -= $inf['valor'];
                }
                if ($inf['at_lancamento'] == "N") {
                    $inf = array('at_lancamento' => 'S',);
                }
            }
        } else { //exclusao
            if ($inf['tipo'] == 'C') {
                $saldo += $inf['valor'];
            } else {
                $saldo += $inf['valor'];
            }
        }
//        $this->lancamentoModel->gravarMovimento($lancamento, $codigo->codigo);
        $this->contaModel->gravarSaldo($conta->id, $saldo);
    }

    function listar_contas() {
        $this->load->model('contaModel');
        $contas = $this->contaModel->listarTudo2();
        $lista = array();
        foreach ($contas as $c) {
            $lista[$c->id] = "$c->id";
        }
        return $lista;
    }

    function atualizaMovimento($conta) {
        $this->load->model('contaModel');
        $this->load->model('lancamentoModel');
        $movimento = $this->lancamentoModel->buscaMovimento($conta);
        $infConta = $this->contaModel->buscar_pelo_codigo($conta);
        $inf = array();
        foreach ($movimento as $m) {
            $inf['acao'] = 'I';
            $inf['data'] = date('Y-m-d');
//            $inf['tipo'] = $m->tipo;
            $inf['valor'] = $m->valor;
            $inf['conta_codigo'] = $conta;
            $inf['at_lancamento'] = $m->at_lancamento;
            $this->alterarSaldo($inf);
            $this->lancamentoModel->gravarMovimento('S', $m->id);
        }
//        redirect('contaController');
        redirect('contaController/index/');
    }

    function tipo() {
        $tipo = array();
        $tipo['C'] = 'Crédito';
        $tipo['D'] = 'Débito';
        return $tipo;
    }

    function alterar_lancamento($codigo) {
        $this->load->model('lancamentoModel');
        $dados['titulo'] = "Alteração de Lançamento";
        $dados['contas'] = $this->listar_contas();
//        $dados['tipos'] = $this->tipo();
        if ($this->uri->segment(3)) {
            $dados['lancamentoAtual'] = $this->uri->segment(3);
        }
        $dados['lancamento'] = $this->lancamentoModel->buscar_pelo_codigo($codigo);
        $this->load->model('contaModel');
        $this->load->model('lancamentoModel');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_rules('data', 'data', 'trim');
        $this->form_validation->set_rules('conta_codigo', 'conta_codigo', 'trim');
//        $this->form_validation->set_rules('tipo', 'tipo', 'trim');
        $this->form_validation->set_rules('descricao', 'descricao', 'trim');
        $this->form_validation->set_rules('valor', 'valor', 'trim');
        $this->form_validation->set_rules('at_lancamento', 'at_lancamento', 'trim');
        if ($this->form_validation->run()) {
            $conta = $this->contaModel->buscar_pelo_codigo($_POST['conta_codigo']);
            
                $_POST['id'] = $codigo;
                $_POST['data'] = implode('-', array_reverse(explode('/', $_POST['data'])));

                if ($this->lancamentoModel->alterar($_POST)) {
                    $_POST['acao'] = 'I';
                    $this->alterarSaldo($_POST);
                    $this->session->set_flashdata('msg', 'Alterado com sucesso!');
                    redirect('lancamentoController/index/' . $_POST['conta_codigo']);
                }
            
        }
        $this->load->view('lancamentoUpdateView', $dados);
    }

    function eliminar_lancamento() {
        $this->load->model('lancamentoModel');
        $lanc = $this->lancamentoModel->buscar_pelo_codigo($this->uri->segment(3));
        if ($lanc->data < date('Y-m-d')) {
            $this->session->set_flashdata('msg', 'Não pode eliminar lançamento com data retroativa!');
        } else {
            if ($this->lancamentoModel->eliminar()) {
                $inf['conta_codigo'] = $lanc->conta_codigo;
//                $inf['tipo'] = $lanc->tipo;
                $inf['valor'] = $lanc->valor;
                $inf['acao'] = 'E';
                $this->alterarSaldo($inf);
                $this->session->set_flashdata('msg', 'Eliminado com sucesso!');
            } else {
                $this->session->set_flashdata('msg', 'Não consegui eliminar!');
            }
        }
        redirect('lancamentoController/index/' . $lanc->conta_codigo);
    }

}
