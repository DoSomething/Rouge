<?php

namespace Rogue\Http\Requests;

class ReactionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reportback_item_id' => 'required|int',
            'northstar_id' => 'required|int',
        ];
    }
}
