<?php

namespace App\Console\Commands\Helper;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MakeDbBackupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:backup {--local : Just dump the DB in local} {--download : Generate link download file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbConfigs = config('database.connections.' . config('database.default'));
        $fileName = 'db-backup-' . date("YmdHis") . '.sql';
        $localPath = '/tmp/' . $fileName;
        $s3Path = 'db-backups';

        // Backup database
        $backupCommand = join(' ', Arr::flatten([
            'PGPASSWORD='.$dbConfigs['password'],
            'pg_dump',
            ['-h', $dbConfigs['read']['host']],
            ['-U', $dbConfigs['username']],
            $dbConfigs['database'],
            ['>', $localPath]
        ], 2));
        $this->info('Backup DB:');
        $this->line('   ' . $backupCommand);
        exec($backupCommand);

        if ((bool) $this->option('local')) {
            $this->info('Just dump the file on local');

            return;
        }

        // Move file to S3
        $this->info('Move backup file to:');
        $this->line('   s3://' . $s3Path);
        $backupPath = Storage::putFileAs($s3Path, new File($localPath), $fileName);

        // Remove local backup file
        $removeCommand = 'rm ' . $localPath;
        $this->info('Remove local backup file: ' . $removeCommand);
        $this->line('   ' . $removeCommand);
        exec($removeCommand);

        // Remove old backup files
        $backupFiles = Storage::files($s3Path);
        rsort($backupFiles);
        $backupFiles = array_slice($backupFiles, 5);

        Storage::delete($backupFiles);
        $this->info('Keep the last 5 backup files and remove the older:');
        $this->line('   ' . implode(PHP_EOL, $backupFiles));

        if ((bool) $this->option('download')) {
            $link = Storage::temporaryUrl($backupPath, Carbon::now()->addMinutes(15));
            $this->info($link);
        }
    }
}
