<html>
    <head>
        <meta charset="utf-8"/>  
     
        <title><?php echo $titulo; ?></title> 
        <!-- JQUERY --> 
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> 
        <script>window.jQuery || document.write('<script src="js/jquery-1.7.1.min.js"><\/script>')</script> 
        <!-- TWITTER BOOTSTRAP CSS --> 
        <link href="<?php echo base_url('homebankxx/views/css/bootstrap.css') ?>" rel="stylesheet" type="text/css"/>  
        <link href="<?php echo base_url('homebankxx/views/css/estilo.css') ?>" rel="stylesheet" type="text/css"/>
        <!-- TWITTER BOOTSTRAP JS --> 
        <script src="<?php echo base_url('homebankxx/views/jquery/js/bootstrap.min.js') ?>"></script> 


    </head>
    <body>
        <!-- HEADER --> 
        <header class="container-fluid"> 
            <div class="row-fluid"> 
                <div class="span12"> 
                    <div class="navbar"> 
                        <div class="navbar-inner"> 
                            <div class="container"> 

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
                        echo form_open('acessoController/faca_login'); //isenrir_pessoa
                        echo form_fieldset('Faça o seu Login');//conta
                        echo form_label("Conta: ");
                        echo form_input('conta', '', 'size="50" class="campo" required');
                        echo br();
                        echo br();
                        echo form_label("Número da Agência: ");
                        echo form_input('numero_agencia', '', 'size="50" class="campo" required');
                        echo br();
                        echo br();

                        echo form_label("Senha: ");
                        echo form_password('senha', '', 'size="10" class="campo" ');
                        echo br();
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


