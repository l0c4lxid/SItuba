<?php

namespace App\Support;

use App\Enums\UserRole;
use App\Models\User;

class FamilyTreatment
{
    public static function ensure(User $patient, string $status = 'contacted', ?string $nextFollowUp = null, ?string $notes = null): void
    {
        $patient->loadMissing(['detail', 'treatments']);
        $detail = $patient->detail;
        if (!$detail) {
            return;
        }

        if (!$patient->treatments->count()) {
            $patient->treatments()->create([
                'kader_id' => $detail->supervisor_id,
                'status' => $status,
                'next_follow_up_at' => $nextFollowUp,
                'notes' => $notes,
            ]);
        }

        $kk = $detail->family_card_number;
        if (!$kk) {
            return;
        }

        $relatedPatients = User::query()
            ->with(['detail', 'treatments'])
            ->where('role', UserRole::Pasien->value)
            ->where('id', '!=', $patient->id)
            ->whereHas('detail', fn($query) => $query->where('family_card_number', $kk))
            ->get();

        foreach ($relatedPatients as $relative) {
            if (!$relative->treatments->count()) {
                $relative->treatments()->create([
                    'kader_id' => optional($relative->detail)->supervisor_id,
                    'status' => $status,
                    'next_follow_up_at' => $nextFollowUp,
                    'notes' => $notes,
                ]);
            }
        }
    }
}
