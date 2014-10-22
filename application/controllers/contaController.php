<?php

class contaController extends CI_Controller {

    public function index() {
        $this->listar();
    }

    public function listar() {
        $this->load->model('contaModel');
        $pagina = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $dados = array(
            'contas' => $this->contaModel->listarTudo(numRegPagina(), $pagina),
            'paginacao' => criaPaginacao(
            'contaController', $this->contaModel->contarTudo(), $this->uri->segment(3), 4),
            'titulo' => "Lista de Contas");
        $this->load->view('contaView', $dados);
    }

    function novo() {
        $this->load->model('contaModel');
        $dados['titulo'] = "Cadastro de Conta";
        $this->load->view('contaFormView', $dados);
    }

    function inserir_conta() {
        $this->load->model('contaModel');
        $inf = array(
            'agencia' => $this->input->post('agencia'),
            'data_criacao' => $this->input->post('data_criacao'),           
            'senha' => $this->input->post('senha'),
            'saldo' => $this->input->post('saldo'),
        );

        $inf['data_criacao'] = implode('-', array_reverse(explode('/', $inf['data_criacao'])));
        if ($this->contaModel->inserir($inf)) {
            $this->session->set_flashdata('msg', 'Criado com sucesso!');
            redirect('contaController/index/');
        } else {
            $this->session->set_flashdata('msg', 'Não consegui gravar!');
        }
    }

    function alterar_conta($codigo) {
        $this->load->model('contaModel');
        $dados['titulo'] = "Alteração de conta";
        $dados['conta'] = $this->contaModel->buscar_pelo_codigo($codigo);

        $this->form_validation->set_rules('agencia', 'agencia', 'trim');
        $this->form_validation->set_rules('data_criacao', 'data_criacao', 'trim');
        $this->form_validation->set_rules('senha', 'senha', 'trim');
        $this->form_validation->set_rules('saldo', 'saldo', 'trim');
        $this->form_validation->set_rules('senha', 'senha', 'trim');
        if ($this->form_validation->run()) {
            $this->load->model('lancamentoModel');

            $lancamentos2 = $this->lancamentoModel->consultaAgendamento(date('Y-m-d'));

            if ($lancamentos2 > 0) {
                $this->session->set_flashdata('msg', 'Sua conta possui um ou mais agendamentos, não sera possível alterar!');
                redirect('contaController/index/');
            } else {
                $_POST['id'] = $codigo;
                $_POST['data_criacao'] = implode('-', array_reverse(explode('/', $_POST['data_criacao'])));
                if ($this->contaModel->alterar($_POST)) {
                    $this->session->set_flashdata('msg', 'Alterado com sucesso!');
                    redirect('contaController/index/');
                }
            }
        }
        $this->load->view('contaUpdateView', $dados);
    }

    function eliminar_conta() {
        $this->load->model('contaModel');
        $this->load->model('lancamentoModel');
        $dados['lancamento'] = $this->lancamentoModel->consultaLancamento();
        $titular = $this->contaModel->buscar_pelo_codigo($this->uri->segment(3));
        if ($dados['lancamento']) {
            $this->session->set_flashdata('msg', 'Você não pode excluir uma conta possuindo um lançamento!');
            redirect('contaController/index/');
        } else {
            $del = $this->contaModel->eliminar();
            if ($del > 0) {
                $this->session->set_flashdata('msg', 'Eliminado com sucesso!');
                redirect('contaController/index/');
            }
        }
    }


}
