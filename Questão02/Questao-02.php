<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8" />
        <title>Questão 2 - jQuery</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="revisit-after" content="3 days"/>
        <meta name="robots" content="index,follow"/>
        <meta name="dc.language" content="pt-br">
        <meta name="geo.region" content="BR-MG"> 
        <meta name="geo.country" content="br"/>
        <meta name="geo.placename" content="Belo Horizonte"/>
        <script
            src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
        crossorigin="anonymous"></script>
        <style>
            .conteudo{display: none}
        </style>
    </head>
    <body > 
        <h1>Questão 2 - jQuery </h1>


        <p>A div com o conteúdo de cada texto está escondida no CSS.<br>
            Faça um script jQuery que, ao clicar no título do conteúdo, a div respectiva do conteúdo abra.
        </p>

        <?php
        for ($i = 1; $i < 11; $i++) {
            ?>
            <div class="cada-texto">
                <a href="" class="evento-click" data-titulo="<?= $i ?>" >titulo <?= $i ?></a>
                <div class="conteudo" id="conteudo-<?= $i ?>">
                    texto texto <?= $i ?>
                </div>
            </div>
            <?php
        }
        ?>

        <script>
            // iniciar o jQuery
            $(document).ready(function(){
                $(".evento-click").on("click", function(e){
                    // evitar o comportamento padrão do link
                    e.preventDefault(); 

                    // pegar o número do título clicado
                    let numero = $(this).data("titulo");
                    
                    // mostrar ou esconder o conteúdo respectivo
                    $("#conteudo-" + numero).slideToggle();
                });
            });
        </script>
        
        <br><hr><br>
    </body>
</html>
