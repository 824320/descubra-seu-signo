<?php include('layouts/header.php'); ?>

<div class="container mt-5 text-center">
    <?php
    // 12. Recebe a data de nascimento do formulário
    $data_nascimento = $_POST['data_nascimento'];

    // 13. Carrega o arquivo XML de signos
    $signos = simplexml_load_file("signos.xml");

    // 16. Converte a data de nascimento para facilitar a comparação
    $data_nasc_objeto = new DateTime($data_nascimento);
    $dia_mes_nascimento = $data_nasc_objeto->format('m-d');

    $signo_encontrado = null;

    // 14. Itera sobre as informações do arquivo XML
    foreach ($signos->signo as $signo) {
        // Converte as datas do XML (dd/mm) para o formato (mm-dd)
        $data_inicio = DateTime::createFromFormat('d/m', (string)$signo->dataInicio)->format('m-d');
        $data_fim = DateTime::createFromFormat('d/m', (string)$signo->dataFim)->format('m-d');

        // 15. Lógica para verificar se a data está no intervalo
        if ($data_inicio > $data_fim) {
            if ($dia_mes_nascimento >= $data_inicio || $dia_mes_nascimento <= $data_fim) {
                $signo_encontrado = $signo;
                break;
            }
        } else {
            if ($dia_mes_nascimento >= $data_inicio && $dia_mes_nascimento <= $data_fim) {
                $signo_encontrado = $signo;
                break;
            }
        }
    }

    // Exibe o resultado conforme o roteiro
    if ($signo_encontrado): ?>
        <div class="card shadow p-4 mx-auto" style="max-width: 600px;">
            <h1 class="text-primary"><?php echo $signo_encontrado->signoNome; ?></h1>
            <p class="lead mt-3"><?php echo $signo_encontrado->descricao; ?></p>
            <a href="index.php" class="btn btn-secondary mt-4">Voltar</a> 
        </div>
    <?php else: ?>
        <p class="alert alert-danger">Data inválida ou signo não encontrado.</p>
        <a href="index.php" class="btn btn-secondary">Tentar novamente</a>
    <?php endif; ?>
</div>

</body>
</html>