<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'event' => $this->event,
            'user' => new UserResource($this->whenLoaded('user')),
            'product' => $this->auditable,
            'changes' => $this->formatModifiedValues($this->old_values, $this->new_values),
            'createdAt' => $this->created_at->format('M d, h:i A'),
        ];
    }


    // This function need to be simplefide.

    function formatModifiedValues($old_values, $new_values)
    {
        $modified_array = [];

        // Old values
        foreach ($old_values as $key => $value) {
            $field_name = preg_replace('/_id$/', '', $key);
            $field_name = str_replace('_', ' ', $field_name);

            // checking if there is a category that has changed so i can get the name of it
            if ($field_name == 'category') {
                $category = Category::findOrFail($value);
                $value = $category->name;
            }


            $modified_array[ucfirst($field_name)]['oldValue'] = $value;
        }

        // New values
        foreach ($new_values as $key => $value) {

            // remove any id with 'blank' then remove any underscores with whitespace for double words like (cost_price -> cost price)
            $field_name = preg_replace('/_id$/', '', $key);
            $field_name = str_replace('_', ' ', $field_name);


            // checking if there is a category that has changed so i can get the name of it
            if ($field_name == 'category') {
                $category = Category::findOrFail($value);
                $value = $category->name;
            }

            $modified_array[ucfirst($field_name)]['newValue'] = $value;
        }

        return $modified_array;
    }
}