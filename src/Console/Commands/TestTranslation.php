<?php

namespace Marshmallow\TranslatedCom\Console\Commands;

use Illuminate\Console\Command;
use Marshmallow\TranslatedCom\Facades\TranslatedCom;

class TestTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate-com:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a test translation to validate the callback is working correctly';

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
     * @return int
     */
    public function handle()
    {
        $qoute_repsonse = TranslatedCom::qoute('Test string')->setSandbox(true)->run();
        TranslatedCom::confirm($qoute_repsonse->json()['pid'])->run();

        $this->newLine();
        $this->info('🎉 The test was successfully created. The callback will be send to ' . TranslatedCom::getCallbackPath(config('translated-com.endpoint')));
        return 0;
    }
}
