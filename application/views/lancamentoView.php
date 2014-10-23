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
        <link href="http://127.0.0.1/homebankxx/application/views/css/bootstrap.css" rel="stylesheet" type="text/css"/>  
        <link href="http ://127.0.0.1/homebankxx/application/views/css/estilo.css" rel="stylesheet" type="text/css"/>
        <!-- TWITTER BOOTSTRAP JS --> 
        <script src="http://127.0.0.1/homebankxx/application/views/jquery/js/bootstrap.min.js"></script> 

        <style type="text/css">
            .center{
                text-align: center;
            }
            #menu ul li{
                /*width: 50px;*/
                list-style-type:none;
                text-align: center;
                position: absolute;
                margin-top: 10px;
                /*border: 1px solid red;*/
            }

            table{
                /*    max-width: 1170px;
                    min-width: 900px;  */
                width: 900px;
                margin: 0 auto;
                box-shadow: 0px 0px 10px gray;
                -webkit-box-shadow: 0px 0px 10px gray;
                -moz-box-shadow: 0px 0px 10px gray;
            }
            table tr th{
                border-bottom: 1px solid #ccc;
                background: #e8e8e8;
                font-variant: small-caps;
                text-shadow: 2px 2px 2px #ccc;
                -moz-box-shadow: 2px 2px 2px #ccc;
                -webkit-box-shadow: 2px 2px 2px #ccc;
            }
            tbody tr:hover > td,
            tbody tr:hover > th {
                background-color: #e8e8e8;
            }

            table tr td{
                border-bottom: 1px solid #ccc;
                border-left: 3px solid #fff;
                text-align: center;
            }
            .ajuste{
                position: absolute;
                margin-left: 900px;

            }
            .movimento{
               padding: 30px;
               margin-left: 90px;
               margin-top: -40px;
            }

            fieldset{
                /*width: 900px;*/
                margin: 0 auto;
                padding-left: 50px;
                padding-right: 50px;
                width:300px;   
                border-bottom: 1px solid #ccc;
                background: #e8e8e8;
                font-variant: small-caps;
                text-shadow: 2px 2px 2px #ccc;
                -moz-box-shadow: 2px 2px 2px #ccc;
                -webkit-box-shadow: 2px 2px 2px #ccc;
            }
        </style>


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

                        $this->table->set_heading('Código', 'Data', 'Conta_código', 'Valor', 'S_atualizado', 'Ações');
                        foreach ($lancamentos as $l) {
                            
                                $link_alterar = anchor("lancamentoController/alterar_lancamento/$l->id", '<img src="http://127.0.0.1/homebankxx/application/views/img/edit.png">');
                                $link_eliminar = anchor("lancamentoController/eliminar_lancamento/$l->id", '<img src="http://127.0.0.1/homebankxx/application/views/img/del.png">');
//            $link_lancamento = anchor("lancamentoController/index/$p->codigo", "Listar Lançamento");
                            
                            $data = implode('/', array_reverse(explode('-', $l->data)));
                            $this->table->add_row($l->id, $data, $l->conta_codigo, $l->valor, $l->at_lancamento, "$link_alterar $link_eliminar");
                        }
                        ?>
                        <div id="menu">
                            <ul class="nav nav-tabs nav-stacked"> 
                                <li><?php echo anchor("lancamentoController/novo", '<img src="http://127.0.0.1/homebankxx/application/views/img/novo.png">'); ?></li>                       
                            </ul>
<!--                            <ul class="nav nav-tabs nav-stacked movimento"> 
                                <li><?php echo anchor("contaController/index/$l->conta_codigo", 'Lista contas'); ?></li>                       
                            </ul>-->
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