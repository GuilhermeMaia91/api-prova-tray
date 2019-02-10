<?php

namespace App\Console\Commands;

use App\Jobs\EnviaEmailPedidos;
use Illuminate\Console\Command;

class RelatorioVendas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mailvendas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia diariamente emails para todos o vendedores com o relatório de vendas do dia';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $envia = new EnviaEmailPedidos();
        $envia->handle();

        $this->info('Emails adicionado na fila de envio!');
    }
}
