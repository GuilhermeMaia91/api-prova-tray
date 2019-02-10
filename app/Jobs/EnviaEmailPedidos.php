<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\EnviaEmailRelatorioVendas;
use Illuminate\Support\Facades\Mail;

class EnviaEmailPedidos implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $orders = Order::whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])->get();

        $data = [];
        foreach ($orders as $order) {
            $user = User::find($order->user_id);

            if (!array_key_exists($user->id, $data)) {
                $data[$user->id] = [
                    'id' => $order->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'data' => date('d/m/Y'),
                    'comissao' => $order->commission,
                    'total' => $order->price_sale
                ];
                continue;
            }

            $data[$user->id]['comissao'] += $order->commission;
            $data[$user->id]['total'] += $order->price_sale;
        }

        foreach ($data as $key => $item) {
            $email = new EnviaEmailRelatorioVendas($item);
            Mail::to($item['email'])->queue($email);
        }
    }
}
