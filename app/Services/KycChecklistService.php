<?php

namespace App\Services;

use App\Models\DocumentVerification;
use App\Models\KycPartner;
use App\Models\UserDetail;
use Illuminate\Support\Collection;

class KycChecklistService
{
    public function getChecklistForEntity(string $entity): array
    {
        $entities = config('kyc.entities', []);
        return $entities[$entity] ?? [];
    }

    public function getSteps(string $entity): array
    {
        $config = $this->getChecklistForEntity($entity);
        $steps = $config['steps'] ?? [];
        return collect($steps)->sortBy('order')->values()->all();
    }

    /**
     * Required document_type keys for document_verifications (excludes partner docs).
     */
    public function getRequiredDocumentTypes(string $entity): array
    {
        $config = $this->getChecklistForEntity($entity);
        $documents = $config['documents'] ?? [];
        return collect($documents)->filter(fn ($d) => ($d['required'] ?? true))->keys()->all();
    }

    public function getUploadedDocuments(int $userId): Collection
    {
        return DocumentVerification::where('user_id', $userId)
            ->whereNotNull('document_type')
            ->with('file:id,filename,originalname')
            ->get()
            ->keyBy('document_type');
    }

    /**
     * For partnership: required docs + at least 1 partner with aadhaar & pan.
     */
    public function hasAllRequiredDocuments(int $userId, string $entity): bool
    {
        $required = $this->getRequiredDocumentTypes($entity);
        $uploaded = DocumentVerification::where('user_id', $userId)
            ->whereNotNull('document_type')
            ->whereIn('document_type', $required)
            ->whereNotNull('file_id')
            ->pluck('document_type')
            ->toArray();

        if (count(array_diff($required, $uploaded)) > 0) {
            return false;
        }

        if ($entity === 'partnership') {
            $partners = KycPartner::where('user_id', $userId)->get();
            if ($partners->isEmpty()) {
                return false;
            }
            foreach ($partners as $p) {
                if (empty($p->aadhaar_number) || empty($p->aadhaar_file_id) || empty($p->pan_number) || empty($p->pan_file_id)) {
                    return false;
                }
            }
        }

        return true;
    }

    public function getProgress(int $userId, string $entity): array
    {
        $required = $this->getRequiredDocumentTypes($entity);
        $uploaded = DocumentVerification::where('user_id', $userId)
            ->whereNotNull('document_type')
            ->whereIn('document_type', $required)
            ->whereNotNull('file_id')
            ->count();

        $total = count($required);
        if ($entity === 'partnership') {
            $partners = KycPartner::where('user_id', $userId)->get();
            $minPartners = 1;
            $partnerDocsPerPartner = 2; // aadhaar + pan
            $total += $minPartners * $partnerDocsPerPartner;
            foreach ($partners as $p) {
                if ($p->aadhaar_file_id) $uploaded++;
                if ($p->pan_file_id) $uploaded++;
            }
        }

        $percentage = $total > 0 ? (int) round(($uploaded / $total) * 100) : 0;
        return [
            'uploaded' => $uploaded,
            'total' => $total,
            'percentage' => min(100, $percentage),
        ];
    }

    public function getDocumentConfig(string $entity, string $documentType): ?array
    {
        $config = $this->getChecklistForEntity($entity);
        return $config['documents'][$documentType] ?? null;
    }
}
