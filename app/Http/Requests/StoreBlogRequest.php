<?php

namespace App\Http\Requests;

use App\Http\Responses\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // protected $redirectRoute = 'blog.create';
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'body' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }



    // public function failedValidation(Validator $validator)
    // {
    //     $response = new ApiResponse($validator->errors(),'Error in form field validation !!');
    //     $response = $response->errorResponse();
    //     // dd($response->getData()->data->title[0]);
    //     // throw new HttpResponseException($response);
    //     // dd($response->getData());
    //     return redirect('/')->with('response',$response);
    //     // return response()->json($validator->errors());
    // }
}
