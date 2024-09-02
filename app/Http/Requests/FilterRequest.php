<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'exclude' =>  'nullable',
        ];
    }

    /**
     * Обрабатываем каждый входной параметр перед
     * его проверкой в rules.
     * Превращаем строку типа (n,n1,n2) в корректный массив
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        foreach ($this->all() as $key => $value) {
            $this[$key] = $this->valueToFormat($value);
        }
    }


    /**
     * Убираем из строки символы массива.
     * Преваращем JS массив, и массив типа (n1,n2,n3) в классический массив
     * @param $value
     * @return array|int|mixed|string|string[]
     */
    protected function valueToFormat($value): mixed
    {
        if (is_array($value) || is_int($value)) {
            return $value;
        }

        if (is_string($value)) {
            # Убираем доп символы
            $value = str_replace(["[", "]"], '', $value);
            if (mb_strpos($value, ',', 0, 'UTF-8')) {
                return explode(',', $value);
            }
        }

        return $value;
    }
}
