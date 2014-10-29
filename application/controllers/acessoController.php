<?php

class acessoController extends CI_Controller {

    function index() {
        $this->load->view('acessoView');
    }

    function faca_login() {
        //verifica os dados do usuário 
        $this->load->model('acessoModel');
        $usu = $this->acessoModel->valida_usuario($_POST);

        if ($usu) {
            if ($usu->nome != "") {
                if ($usu->senha == $_POST ['senha'] && $usu->conta == $_POST ['conta'] && ($usu->numero_agencia == $_POST ['numero_agencia'])) {
                    if ($usu->inativo == 'S') {
                        echo 'Usuario Inativo';
                    } else {
                        $this->session->set_flashdata('usuario_nome', $usu->nome);
                        $this->session->set_flashdata('usuario_codigo', $usu->codigo);
                        $this->inserir_acesso('N', $usu);
                        echo 'conectou';
                        redirect('contaController');
                    }
                } else {
                    $this->erro_acesso($usu);
                }
            } else {
                $this->erro_acesso($usu);
            }
        }else{
            echo 'Dados Inválidos';
            $this->load->view('acessoView');
        }
    }

    function inserir_acesso($erro, $usu) {
        $this->load->model('acessoModel');
        $inf = array(
            'usuario_codigo' => $usu->codigo,
            'datahora' => date('Y-m-d H:m:s'),
            'ip' => $_SERVER["REMOTE_ADDR"],
            'erro' => $erro
        );
        $this->acessoModel->inserir_acesso($inf);
    }

    function erro_acesso($usu) {
        $this->load->model('acessoModel');
        $this->inserir_acesso('S', $usu);
        $this->session->set_flashdata('usuario_nome', '');
        $this->session->set_flashdata('usuario_codigo', '');
        $this->session->set_flashdata('msg', 'Dados inválidos');
        if ($this->acessoModel->buscar_erros($usu->codigo) >= 3) {
            $this->acessoModel->bloquear($usu->codigo);
            echo 'Sua conta foi bloqueada, procure a agência mais próxima';
        }
        $this->load->view('acessoView');
    }

}
