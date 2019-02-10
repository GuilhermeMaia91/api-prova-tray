# API-prova-tray
Repositorio da API desenvolvido para a prova da Tray

Depois de baixar o código fonte é necessário executar o <b>composer install</b> após isso, crie uma base de dados com o nome <b>prova-tray</b>
execute o comando <b>php artisan migrate</b> que iŕa gerar toda a base de dados.

#Scheduler de envio do Email
Para testar o envio de emails é necessário configurar o arquivo .env adicionando as credenciais do email de envio, como no exemplo:

MAIL_DRIVER=smtp<br>
MAIL_HOST=smtp.gmail.com<br>
MAIL_PORT=465<br>
MAIL_USERNAME=teste@gmail.com<br>
MAIL_PASSWORD=123456<br>
MAIL_ENCRYPTION=ssl<br><br>

*dados ficticios

Após essa configuração execute o comando php artisan send:mailvendas para testar o envio dos Relatório de Vendas e para sistemas 
baseado em Linux\Unix precisa adicionar ao CRON a linha:
* * * * * php /var/www/html/api-tray schedule:run >> /dev/null 2>&1

PRONTO!
