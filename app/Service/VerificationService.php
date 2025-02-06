<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class VerificationService
{
    public function sendCode(User $user, string $type = 'email'): string
    {
        $code = Str::random(6);
        $key = "{$type}_verification_{$user->id}";

        Cache::put($key, $code, now()->addMinutes(10));

        if ($type === 'email') {
            // Send email verification
            Mail::to($user->email)->send(new VerificationMail($code));
        }

        return $code;
    }

    public function verifyCode(User $user, string $code, string $type = 'email'): bool
    {
        $key = "{$type}_verification_{$user->id}";
        $storedCode = Cache::get($key);

        if ($storedCode && $storedCode === $code) {
            if ($type === 'email') {
                $user->update([
                    'email_verified_at' => now(),
                    'is_verified'       => true
                ]);
            } else {
                $user->update(['is_verified' => true]);
            }
            Cache::forget($key);
            return true;
        }

        return false;
    }
}
