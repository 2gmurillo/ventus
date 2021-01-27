<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use App\Traits\UpdateOrderStatus as UpdateOrder;

class UpdateOrderStatus extends Command
{
    use UpdateOrder;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will ask for orders statuses and update the ones that do not have a final status';

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
     * @return void
     */
    public function handle(): void
    {
        $ordersWithoutFinalStatus = Order::withoutFinalStatus()->get();
        foreach ($ordersWithoutFinalStatus as $order) {
            $this->updateOrderStatus($order);
        }
    }
}
