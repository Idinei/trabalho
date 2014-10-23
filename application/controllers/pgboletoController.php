<?php

class pgboletoController extends CI_Controller {

    public function index() {
        $this->listar();
    }

    public function listar() {
        $this->load->model('pgboletoModel');
        $pagina = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $dados = array(
            'boletos' => $this->contaModel->listarTudo(numRegPagina(), $pagina),
            'paginacao' => criaPaginacao(
            'pgboletoController', $this->contaModel->contarTudo(), $this->uri->segment(3), 4),
            'titulo' => "Lista de Boletos");
        $this->load->view('pgboletoView', $dados);
    }

    function novo() {
        $this->load->model('pgboletoModel');
        $dados['titulo'] = "Cadastro de Boletos";
        $this->load->view('pgboletoFormView', $dados);
    }

    function inserir_pgboleto() {
        $this->load->model('pgboletoModel');
        $inf = array(
            'cod_barra' => $this->input->post('cod_barra'),
            'data_pag' => $this->input->post('data_pag'),           
            'valor' => $this->input->post('valor'),
            'senha' => $this->input->post('senha'),
        );

        $inf['data_pag'] = implode('-', array_reverse(explode('/', $inf['data_pag'])));
        if ($this->pgboletoModel->inserir($inf)) {
            $this->session->set_flashdata('msg', 'Pagamento efetuado com sucesso !');
            redirect('pgboletoController/index/');
        } else {
            $this->session->set_flashdata('msg', 'Pagamento nao realizado!');
        }
    }

    function alterar_pgboleto($cod_barra) {
        $this->load->model('pgboletoModel');
        $dados['titulo'] = "Registros alterados com sucesso";
        $dados['boleto'] = $this->contaModel->buscar_pelo_codigo($cod_barra);

        $this->form_validation->set_rules('cod_barra', 'acod_barra', 'trim');
        $this->form_validation->set_rules('data_pag', 'data_pag', 'trim');
        $this->form_validation->set_rules('valor', 'valor', 'trim');
        $this->form_validation->set_rules('senha', 'senha', 'trim');
        if ($this->form_validation->run()) {
            $this->load->model('pgboletoModel');

            $data_pag1 = $this->pgboletoModel->consultaData(date('Y-m-d'));

            if ($data_pag12 > 0) {
                $this->session->set_flashdata('msg', 'Seu boleto possui pagamentos agendado, não sera possível alterar!');
                redirect('pgboletoController/index/');
            } else {
                $_POST['cod_barra'] = $cod_barra;
                $_POST['data_pag'] = implode('-', array_reverse(explode('/', $_POST['data_pag'])));
                if ($this->pgboletoModel->alterar($_POST)) {
                    $this->session->set_flashdata('msg', 'Alterado com sucesso!');
                    redirect('pgboletoController/index/');
                }
            }
        }
        $this->load->view('pgboletoUpdateView', $dados);
    }

    function eliminar_pgboleto() {
        $this->load->model('pgboletoModel');
        $this->load->model('pgboletoModel');
        $dados['boleto'] = $this->pgboletoModel->consultaBoleto();
        $titular = $this->pgboletoModel->buscar_pelo_codigo($this->uri->segment(3));
        if ($dados['boleto']) {
            $this->session->set_flashdata('msg', 'Você não pode excluir esse codigo de barras de lançamento!');
            redirect('pgboletoController/index/');
        } else {
            $del = $this->pgboletoModel->eliminar();
            if ($del > 0) {
                $this->session->set_flashdata('msg', 'Eliminado com sucesso!');
                redirect('pgboletoController/index/');
            }
        }
    }


}
