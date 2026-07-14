<?php

namespace App\Providers;

use App\Models\SmtpConfiguration;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Schema;

class SmtpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        try{
            
        if (Schema::hasTable('smtp_configurations')) {
            $smtp_configuration = SmtpConfiguration::where('is_active', true)->first();
            if ($smtp_configuration !== null) {
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.host' => $smtp_configuration->host,
                    'mail.mailers.smtp.port' => $smtp_configuration->port,
                    'mail.mailers.smtp.username' => $smtp_configuration->username,
                    'mail.mailers.smtp.password' => $smtp_configuration->password,
                    'mail.mailers.smtp.encryption' => $smtp_configuration->encryption,
                    'mail.from.address' => $smtp_configuration->from_address,
                    'mail.from.name' => $smtp_configuration->from_name,
                ]);
            }
        }
        
        }catch (\Exception $e) {
            // Prevent app crash during boot
        }
    }
}
