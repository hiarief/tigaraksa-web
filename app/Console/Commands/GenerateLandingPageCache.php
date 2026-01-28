<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\LandingPageController;

class GenerateLandingPageCache extends Command
{
    protected $signature = 'cache:landing-page';
    protected $description = 'Generate cache for landing page';

    public function handle()
    {
        $controller = new LandingPageController();

        $this->info('Generating cache...');
        $controller->getKeyMetrics();
        $controller->getDemografiKK();
        $controller->getEkonomi();
        $controller->getBantuan();
        $controller->getKesehatan();
        $controller->getPendidikanPekerjaan();
        $controller->getStatistikPenduduk();
        $controller->getDataDesa();

        $this->info('Cache generated successfully!');
    }
}
