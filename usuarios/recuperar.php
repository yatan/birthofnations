<?php

/*
 * Code started by: yatan
 * Batamanta Team
 */

include_once($_SERVER['DOCUMENT_ROOT'] . "/include/funciones.php");
include($_SERVER['DOCUMENT_ROOT'] . "/index_head.php");


if (!isset($_GET['token']))
    die("<h1>" . getString('code_error') . "</h1>");
if (!isset($_GET['mail']))
    die("<h1>" . getString('code_error') . "</h1>");



if (reset_pass($_GET['mail'], $_GET['token']) == FALSE)
    die(getString('code_error'));
else {
?>


    <style>
        .central {
            position: absolute;
            top: 50%;
            left: 50%;
            height: 200px;
            width: 325px;
            margin-top: -100px;
            margin-left: -100px;
            border: 1px solid #ccc;
            background-color: #f3f3f3;
            text-align: center;
        }
    </style>

    <div id="central" class="central">
        <h1><? echo getString("login_recovery_title"); ?></h1>
        <form id="formulario">
            Introduce nuevo password: <input type="password" name="password1" />
            <br>
            Confirma el nuevo password: <input type="password" name="password2" />
            <br>
            <input type="hidden" name="mail" value="<? echo $_GET['mail']; ?>" />
            <input type="button" id="reset" value="enviar" />
        </form>
    </div>
    <div id="central2" class="central" style="display: none;">
        <img src='/images/loading.gif' />
    </div>

    <script>
        $('#reset').click(function() {
            $("#central").hide();
            $("#central2").show();
            $.post("recuperar2.php", $("#formulario").serialize(),
                function(data) {
                    $("#central").html(data);
                    $("#central2").hide();
                    $("#central").show();
                });


        });
    </script>

<?php
}
?>