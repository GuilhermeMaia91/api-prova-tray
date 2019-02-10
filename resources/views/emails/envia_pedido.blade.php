<!DOCTYPE html>
<html>
<head>
    <title>Relatório de Vendas</title>
</head>
<body>

<p>Olá, Senhor(a) {{ $email['name'] }}</p>
<p>Neste dia {{ $email['data'] }} você vendeu R$ {{ number_format($email['total'], 2, ',', '.') }}, totalizando em comissão R$ {{ number_format($email['comissao'], 2, ',', '.') }}!</p>

<strong>Obrigado. :)</strong>

</body>
</html>