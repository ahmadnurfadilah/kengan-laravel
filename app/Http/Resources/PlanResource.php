<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $features = $this->features->map(function ($feature) {
            if ($feature->name === 'campaign') {
                $description = number_format($feature->pivot->charges) . ' Campaign' . ($feature->pivot->charges > 1 ? 's' : '');
            } elseif ($feature->name === 'campaign-participants') {
                $description = number_format($feature->pivot->charges) . ' Campaign Participants';
            } elseif ($feature->name === 'campaign-mentions') {
                $description = number_format($feature->pivot->charges) . ' Campaign Mention' . ($feature->pivot->charges > 1 ? 's' : '');
            } elseif ($feature->name === 'campaign-keywords') {
                $description = number_format($feature->pivot->charges) . ' Campaign Keyword' . ($feature->pivot->charges > 1 ? 's' : '');
            } else {
                $description = ucfirst(str_replace('-', ' ', $feature->name)) . ': ' . $feature->pivot->charges;
            }

            return [
                'id' => $feature->id,
                'name' => $feature->name,
                'description' => $description,
            ];
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => (double)$this->price,
            'periodicity' => $this->periodicity,
            'periodicity_type' => $this->periodicity_type,
            'features' => $features,
        ];
    }
}
