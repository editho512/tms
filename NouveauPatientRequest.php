<?php

namespace App\Http\Requests\Patient;

use App\Rules\Nom;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NouveauPatientRequest extends FormRequest
{
    /**
    * Determiner si l'utilisateur est autorisé a faire la réquete
    *
    * @return bool
    */
    public function authorize()
    {
        if (auth()->user())
        {
            return true;
        }
        return false;
    }


    /**
     * Si on veur du JSON
     *
     * @return void
     */
    public function wantsJson()
    {
        if ($this->ajax())
        {
            return true;
        }
        return false;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        if ((bool) $this->find === false)
        {
            return [
                "nom" => ["required", "min:2", "max:255", new Nom],
                "prenom" => ["nullable", "min:2", "max:255", new Nom],
                "date_naissance" => [
                    "required", "date", "date_format:Y-m-d",
                    "before:" . Carbon::now()->toDateString(),
                    "after_or_equal:" . Carbon::now()->firstOfQuarter()->modify('-150 year')->format('Y-m-d'),
                ],
                "genre" => ["required", "in:Masculin,Féminin, masculin, féminin"],
                "situation_matrimoniale" => ["required", "sometimes"],
                "adresse" => ["required", "sometimes"],
                "email" => ["nullable", "email", "unique:patient,email"],
                "cin" => ["nullable", "numeric", "unique:patient,cin", "regex:/^([1-9]{1}[0-9]{11})?$/"],
                "nationalite" => ["required"],
                "fonction" => ["nullable", "string"],
                'format' => ['required', 'regex:/(^\+[1-9]{3}?$)/u'],
                "contact" => ["nullable", "numeric", "regex:/^([3]{1}[1-9]{1}[0-9]{7})?$/"],
                "description" => ["nullable", "sometimes"],
                "liste_antecedent" => ["nullable", "required_with:antecedent_check,on"],
                "photo" =>["nullable", "file", "image"],
                "description" => ["nullable", "sometimes"],

                "assurance" => ["sometimes"],
                "entreprise" => ["nullable", "required_with:assurance,on", "sometimes"],
                "numero_carte" => ["nullable", "required_with:assurance, on", "sometimes", "unique:patient,numero_carte"],
                "pourcentage" => ["nullable", "required_with:assurance, on", "numeric"],
                "type_assurance" => ["nullable", "required_with:assurance, on", "sometimes", "max:255", "min:2"]
            ];
        }

        // Si l'appli fait une recherche d'antécedent
        return [];
    }



    /**
     * Preparation avant la validation
     * Pratique pour faire quelques changements au niveau des champs
     * Ici CIN et Contact
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->has('contact'))
        {
            $tmp = str_replace(' ', '', $this->contact);

            if ($tmp !== '')
            {
                $this->merge(['contact'=> intval($tmp)]);
            }
        }

        if ($this->has('cin'))
        {
            $tmp = str_replace(' ', '', $this->cin);

            if ($tmp !== '')
            {
                $this->merge(['cin'=> intval($tmp)]);
            }
        }
    }


    /**
    * Message personalisé
    *
    * @return array
    */
    public function messages() : array
    {
        return [
            'nom.required' => 'Vous devez remplir le nom',
            'nom.min' => 'Le nom doit être au moins :min caractère',
            'nom.max' => 'Le prénom ne doit pas depasser :max caractères',

            'prenom.min' => 'Le prenom doit être au moins :min caractère',
            'prenom.max' => 'Le prénom ne doit pas depasser :max caractères',

            'date_naissance.required' => 'La date de naissance est réquis',
            'date_naissance.date' => 'La date de naissance doit etre une format de date',
            'date_naissance.date_format' => 'Le format de la date de naissance doit etre :date_format',
            'date_naissance.before' => 'La date de naissance ne doit pas depasser la date :date',
            'date_naissance.after_or_equal' => 'La date de naissance ne doit pas être inférieur la date :date',

            'contact.regex' => 'Le format du telephone est invalide (32 XX XXX XX) ou (34 XX XXX XX)',

            'genre.required' => 'Le genre est réquis',
            'genre.in' => 'Le genre doit etre parmi la liste',

            'situation_matrimoniale.required' => 'La sitation matrimoniale est réquis',

            'adresse.required' => 'L\'adresse du patient est requis',

            'numero_carte.required_with' => "Le numero de carte est obligatoire si vous cochez l'assurance",
            'pourcentage.required_with' => "La pourcentage est obligatoire si vous cochez l'assurance",
            'type_assurance.required_with' => "Le type d'assurance est obligatoire si vous cochez l'assurance",
            'entreprise.required_with' => "Le nom du societe est obligatoire si vous cochez l'assurance"
        ];
    }


    /**
    * Si la validation échoue
    *
    * @param Validator $validator
    * @return void
    */
    protected function failedValidation(Validator $validator)
    {
        $message = "Les champs ne sont pas bien remplis";
        if (request()->ajax())
        {
            throw new HttpResponseException(response()->json([
                "errors" => $validator->errors(),
                "message" => $message
            ], 422));
        }
        return back()->withErrors($validator)->withInput();
    }
}
