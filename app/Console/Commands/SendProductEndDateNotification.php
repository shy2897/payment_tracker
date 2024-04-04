<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\Annual;
use App\Models\Change;
use App\Models\Capex;
use App\Models\Opex;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderMail;

class SendProductEndDateNotification extends Command
{
    protected $signature = 'product:end_date_notification';

    protected $description = 'Send notification to users one day before product end date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Get products with end_date one day before current date
        $products = Product::whereDate('deadline_date', Carbon::tomorrow())->get();
        $annuals = Annual::whereDate('deadline_date', Carbon::tomorrow())->get();
        $changes = Change::whereDate('deadline_date', Carbon::tomorrow())->get();
        $capexs = Capex::whereDate('deadline_date', Carbon::tomorrow())->get();
        $opexs = Opex::whereDate('deadline_date', Carbon::tomorrow())->get();

        // Send notification emails
        foreach ($products as $product) {
            Mail::to('shaiprd2897@gmail.com')->send(new ReminderMail($product));
        }
        foreach ($annuals as $product) {
            Mail::to('shaiprd2897@gmail.com')->send(new ReminderMail($product));
        }
        foreach ($changes as $product) {
            Mail::to('shaiprd2897@gmail.com')->send(new ReminderMail($product));
        }
        foreach ($capexs as $product) {
            Mail::to('shaiprd2897@gmail.com')->send(new ReminderMail($product));
        }
        foreach ($opexs as $product) {
            Mail::to('shaiprd2897@gmail.com')->send(new ReminderMail($product));
        }
        $this->info('Notification emails sent successfully.');
    }
}