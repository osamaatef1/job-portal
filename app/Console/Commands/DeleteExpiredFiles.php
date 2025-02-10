<?php

namespace App\Console\Commands;

use App\Service\FileService;
use Illuminate\Console\Command;

class DeleteExpiredFiles extends Command
{
    protected $signature = 'files:delete-expired';
    protected $description = 'Delete all expired files';

    public function handle(FileService $fileService)
    {
        $fileService->deleteExpired();
        $this->info('Expired files deleted successfully');
    }
}
