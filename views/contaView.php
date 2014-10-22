<!DOCTYPE HTML>
<html lang="en-US">
    <head>

        <!--<link type="text/css" rel="stylesheet" href="http://127.0.0.1/codeigniter/application/views/css/estilo.css"/>-->

        <meta charset="UTF-8"> 
        <title><?php echo $titulo; ?></title> 
        <!-- JQUERY --> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
        <script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script> 
        <!-- TWITTER BOOTSTRAP CSS --> 
        <link href="http://127.0.0.1/codeigniter/application/views/css/bootstrap.css" rel="stylesheet" type="text/css"/>  
        <link href="http://127.0.0.1/codeigniter/application/views/css/estilo.css" rel="stylesheet" type="text/css"/>
        <!-- TWITTER BOOTSTRAP JS --> 
        <script src="http://127.0.0.1/codeigniter/application/views/jquery/js/bootstrap.min.js"></script> 


    </head>
    <body>
        <!-- HEADER --> 
        <header class="container-fluid"> 
            <div class="row-fluid"> 
                <div class="span12"> 
                    <div class="navbar"> 
                        <div class="navbar-inner"> 
                            <div class="container"> 
                                <h2 class="center">Cadastro de Contas</h2> 
                            </div> 
                        </div> 
                    </div> 
                </div> 
            </div> 
        </header> 
        <!-- / HEADER -->
        <div class="container-fluid"> 
            <!-- CLASSE PARA DEFINIR UMA LINHA --> 
            <div class="row-fluid"> 
                <!-- COLUNA OCUPANDO 2 ESPAÇOS NO GRID -->         
                <div class="span12">
                    <div class="well">
                        <?php if ($this->session->flashdata('msg')) { ?>
                            <div class="alert ajuste">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <?php echo $this->session->flashdata('msg'); ?>
                            </div>
                            <?php
                        }

                        
                        $this->table->set_heading('Conta', 'Agencia', 'Data_criação', 'Senha', 'Saldo', 'Ações');
                        foreach ($contas as $p) {
                            $link_alterar = anchor("contaController/alterar_conta/$p->id", '<img src="http://127.0.0.1/codeigniter/application/views/img/edit.png">', 'title="Editar"');
                            $link_eliminar = anchor("contaController/eliminar_conta/$p->id", '<img src="http://127.0.0.1/codeigniter/application/views/img/del.png">', 'title="Excluir"');
                            $link_lancamento = anchor("lancamentoController/index/$p->id", '<img src="http://127.0.0.1/codeigniter/application/views/img/dinheiro.png">', 'title="Listar Lançamento"');
                            $link_movimento = anchor("lancamentoController/atualizaMovimento/$p->id", '<img src="http://127.0.0.1/codeigniter/application/views/img/atu.png">', 'title="Atualiza Movimento"');
                            $link_extrato = anchor("lancamentoController/index2/$p->id", '<img src="http://127.0.0.1/codeigniter/application/views/img/rel.png">', 'title="Extrato de Conta"');

                            $data_criacao = implode('/', array_reverse(explode('-', $p->data_criacao)));
                            $this->table->add_row($p->id, $p->agencia, $data_criacao, $p->senha, $p->saldo, "$link_alterar $link_eliminar $link_lancamento $link_extrato $link_movimento");
                        }
                        
                        ?>
                        
                        <div id="menu">
                            <ul class="nav nav-tabs nav-stacked"> 
                                <li><?php echo anchor("contaController/novo", '<img src="http://127.0.0.1/homebank/application/views/img/novo.png">'); ?></li>                       
                            </ul>
                            
                        </div>
                        <h3 class="center"> <?php echo $titulo; ?> </h3> 
                        <hr />
                        
                        <?php
                        echo $this->table->generate();
                        ?>
                        
                        <hr/>
                        <div class="pagination pagination-centered">
                            <?php
                                echo $paginacao;
                            ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>