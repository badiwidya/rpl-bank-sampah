<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendChangePasswordEmail implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::raw(
            "Halo {$this->user->nama_depan}, \n\nPassword akun Anda telah berhasil diganti. \n\nJika ini bukan Anda, segera hubungi tim kami.",
            function ($message) {
                $message->to($this->user->email)
                    ->subject('Password Berhasil diganti');
            }
        );
    }
}
