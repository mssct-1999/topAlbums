<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoteRequest extends FormRequest
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
            'note' => 'required|between:1,10'
        ];
    }

    /**
     * @param action Action de l'utilisateur
     * Fonction de validation des données
     */
    public function validate($action = 'create') {
        if ($this->note > 10 || $this->note < 0) {
            return ['success' => false, 'message' => "Ajout / modification impossible - La note de votre vote doit être comprise entre 0 et 10."];
        }
        return ['success' => true]; 
    }
}