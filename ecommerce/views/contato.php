<?php require_once '../includes/menu.php'; ?>
</body>
<head>
    <link rel="stylesheet" href="../assets/estilo/contato.css">
    <link rel="shortcut icon" href="../assets/images/favicon/bag-icon-2.svg" type="image/x-icon">
</head>
<body>
    <main>
        <h1 class="titulo-contato">Entre em Contato</h1>
        <div class="container">
            <div class="onde-encontrar">
                <h2>Onde nos encontrar?</h2>
                <ul class="links">
                    <a href="">
                        <li>contato@oneclick.com</li>
                    </a>
                    <a href="">
                        <li>instagram.com/oneclick</li>
                    </a>
                    <a href="">
                        <li>facebook.com/oneclick</li>
                    </a>
                    <a href="">
                        <li>twitter.com/oneclick</li>
                    </a>
                </ul>
                <div class="endereco">
                    <h3>Endereço</h3>
                    <p>Rua São João Roberto Filho, 200 <br> Novo Centro, São Paulo - SP</p>
                </div>
            </div>
            <form class="enviar-form" action="../controllers/ContatoController.php" method="post">
                <div class="input-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                    <label for="mensagem">Mensagem</label>
                    <textarea name="mensagem" id="mensagem" cols="30" rows="8"></textarea>
                </div>
                <input class="btn-enviar" type="submit" value="Enviar Mensagem">
            </form>
        </div>
    </main>
</body>
</html>
