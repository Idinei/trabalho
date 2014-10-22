<html>
    <head>
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
        <script type="text/javascript" src="http://127.0.0.1/codeigniter/application/views/jquery/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="http://127.0.0.1/codeigniter/application/views/jquery/js/jquery.maskMoney.js"></script>
        <link href="http://127.0.0.1/codeigniter/application/views/jquery/css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="http://127.0.0.1/codeigniter/application/views/jquery/js/jquery-ui.js"></script>
        <script type="text/javascript">
            $(document).ready(function(e) {
                $("#datepicker").datepicker({
                    dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],
                    dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
                    dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                    montNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    dateFormat: 'dd/mm/yy',
                    nextText: 'Próximo',
                    prevText: 'Anterior'

                });
            });

        </script>  
    </head>
    <body>
        <!-- HEADER --> 
        <header class="container-fluid"> 
            <div class="row-fluid"> 
                <div class="span12"> 
                    <div class="navbar"> 
                        <div class="navbar-inner"> 
                            <div class="container"> 
                                <h2 class="center"><?php echo $titulo; ?></h2> 
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
                        <?php
                        if ($this->session->flashdata('msg')) {
                            echo $this->session->flashdata('msg');
                        }

                        $codigo = 0;
                        $codigo = @$lancamento->codigo;

                        $data_criacao = 0;
                        $codigo = @$lancamento->codigo;

                        $data_criacao = "";
                        $data_criacao = implode('/', array_reverse(explode('-', $lancamento->data)));

                        echo form_open("lancamentoController/alterar_lancamento/$codigo");
                        echo form_fieldset('Informações do Lançamento');

                        echo form_label("Código:");
                        echo form_input('codigo', set_value('codigo', @$lancamento->codigo), 'size="6" class="campo"');
                        echo br();

                        echo form_label("Data:");
                        echo form_input('data', set_value('data', @$data_criacao), 'size="10" class="campo" id="datepicker" required');
                        echo br();

                        echo form_label("conta_código:");
                        //var_dump($contas);
                        echo form_dropdown('conta_codigo', $contas, set_value('conta_codigo', @$lancamento->conta_codigo), 'required');
                        echo br();

                        echo form_label("Tipo: ");
                        echo form_dropdown('tipo', $tipos, set_value('tipo', @$lancamento->tipo), 'class="campo" required');
                        echo br();

                        echo form_label("Descrição:");
                        echo form_input('descricao', set_value('descricao', @$lancamento->descricao), 'size="10" class="campo" required');
                        echo br();

                        echo form_label("valor:");
                        echo form_input('valor', set_value('valor', @$lancamento->valor), 'size="45" class="campo" required');
                        echo br();

                        echo form_label("at_lancamento:");
                        echo form_input('at_lancamento', set_value('at_lancamento', @$lancamento->at_lancamento), 'size="3" class="campo"');
                        echo br();

                        echo form_submit('submit', 'Enviar', 'class="botao1"');
                        echo form_reset('reset', 'Limpar');

                        echo form_fieldset_close();
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<?php


