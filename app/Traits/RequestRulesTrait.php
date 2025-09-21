<?php

namespace App\Traits;

use App\Models\Event;
use App\Models\Product;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorResponse;

trait RequestRulesTrait
{

    /**
     * apiValidationHandel
     *
     * @param  mixed $request
     * @param  mixed $rules
     * @return ValidatorResponse|null
     */
    public function apiValidationHandel(Request $request, array $rules): ValidatorResponse|null
    {
        // make validation
        $validator = Validator::make($request->all(), $rules);

        // return validated the data
        return $validator->fails() ? $validator : null;
    }


    /**
     * loginRules
     *
     * @return array
     */
    public function loginRules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required',  Rules\Password::defaults()],
        ];
    }

    /**
     * registerRules
     *
     * @return array
     */
    public function registerRules(): array
    {
        return [
            'full_name' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ];
    }

    /**
     * verifyEmailRules
     *
     * @return array
     */
    public function verifyEmailRules(): array
    {
        return [
            'code' => ['required',  'exists:email_verifications']
        ];
    }

    /**
     * sendPasswordResetCodeRules
     *
     * @return array
     */
    public function sendPasswordResetCodeRules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    /**
     * passwordResetRules
     *
     * @return array
     */
    public function passwordResetRules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:4'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ];
    }

    /**
     * createUserRules
     *
     * @return array
     */
    public function createUserRules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', Rules\Password::defaults()],
            'phone' => ['nullable', 'max:40'],
            'address' => ['nullable', 'max:100'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email_verified_at' => ['nullable']
        ];
    }


     /**
     * updateUserRules
     *
     * @return array
     */
    public function updateUserRules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)],
            'phone' => ['nullable', 'max:40'],
            'address' => ['nullable', 'max:100'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email_verified_at' => ['nullable']
        ];
    }

    /**
     * createProductRules
     *
     * @return array
     */
    public function createProductRules(): array
    {
        return [
            // Product Names (required, unique in JSON format)
            'name.*' => ['required', 'string', 'min:2', 'max:100', 'unique_translation:products'],

            // Product Identifiers
            'sku' => ['required', 'string', 'min:2', 'max:50', Rule::unique('products')],
            'barcode' => ['nullable', 'string', 'max:50', Rule::unique('products')],

            // Pricing and Stock
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99', 'lt:sale_price'],
            'sale_price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'stock' => ['required', 'integer', 'min:0'],

            // Units (optional)
            'unit.en' => ['nullable', 'string', 'max:50'],
            'unit.ar' => ['nullable', 'string', 'max:50'],

            // Descriptions (optional)
            'description.en' => ['nullable', 'string', 'max:1000'],
            'description.ar' => ['nullable', 'string', 'max:1000'],

            // Nutrition Information (optional)
            'nutrition.en' => ['nullable', 'string', 'max:2000'],
            'nutrition.ar' => ['nullable', 'string', 'max:2000'],

            // Rating
            'rate' => ['required', 'integer', 'min:1', 'max:5'],

            // Product Image
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'], // 5MB max

            // Status
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * updateProductRules
     *
     * @param int|string|null $productId The ID of the product being updated
     * @return array
     */
    public function updateProductRules($productId = null): array
    {
        // Get the product ID from route parameter if not provided
        if (!$productId)
            $productId = request()->route('product') ? request()->route('product')->id ?? request()->route('product') : null;

        return [
            // Product Names (required, unique in JSON format, ignore current record)
            'name.*' => [
                'required',
                'string',
                'min:2',
                'max:100',
                'unique_translation:products,name,' . $productId
            ],

            // Product Identifiers (ignore current record)
            'sku' => [
                'required',
                'string',
                'min:2',
                'max:50',
                Rule::unique('products')->ignore($productId)
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('products')->ignore($productId)
            ],

            // Pricing and Stock
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'max:999999.99', 'gte:price'],
            'stock' => ['required', 'integer', 'min:0'],

            // Units (optional)
            'unit.en' => ['nullable', 'string', 'max:50'],
            'unit.ar' => ['nullable', 'string', 'max:50'],

            // Descriptions (optional)
            'description.en' => ['nullable', 'string', 'max:1000'],
            'description.ar' => ['nullable', 'string', 'max:1000'],

            // Nutrition Information (optional)
            'nutrition.en' => ['nullable', 'string', 'max:2000'],
            'nutrition.ar' => ['nullable', 'string', 'max:2000'],

            // Rating
            'rate' => ['required', 'integer', 'min:1', 'max:5'],

            // Product Image (optional for updates)
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,gif', 'max:5120'], // 5MB max

            // Status
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * updateProfileRules
     *
     * @return array
     */
    public function updateProfileRules() : array
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:100'],
            'about_me'  => ['required', 'string', 'min:2','max:500'],
            'image'     => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
        ];
    }

    // /**
    //  * updateFavoriteRules
    //  *
    //  * @return array
    //  */
    // public function updateFavoriteRules() : array
    // {
    //     // check if there is favoritable_type
    //     $type = (string) request()->input('favoritable_type', ''); // App/Models/Event or App/Models/Hotel

    //     if(!$type)
    //         return ['favoritable_type' => ['required']];

    //     // Map input to actual tables
    //     $table = in_array($type, [Event::class, 'event', 'events']) ? 'event' : 'hotel';

    //     if(!$table)
    //         return ['favoritable_type' => Rule::in(['App\Models\Event', 'App\Models\Hotel'])];

    //     return [
    //         'favoritable_type' => ['required', 'string', Rule::in(['App\Models\Event', 'App\Models\Hotel'])],
    //         'favoritable_id' => ['required', 'integer', 'exists:'.$table.'s,id'],
    //     ];
    // }

    //  /**
    //   * storeOrderRules
    //   *
    //   * @return array
    //   */
    //  public function storeOrderRules() : array
    // {
    //     // check if there is orderable_type
    //     $type = (string) request()->input('orderable_type', ''); // App/Models/Event or App/Models/Hotel

    //     if(!$type)
    //         return ['orderable_type' => ['required']];

    //     // Map input to actual tables
    //     $table = in_array($type, [Event::class, 'event', 'events']) ? 'event' : 'hotel';

    //     if(!$table)
    //         return ['orderable_type' => Rule::in(['App\Models\Event', 'App\Models\Hotel'])];

    //     return [
    //         'orderable_type' => ['required', 'string', Rule::in(['App\Models\Event', 'App\Models\Hotel'])],
    //         'orderable_id' => ['required', 'integer', 'exists:'.$table.'s,id'],
    //         'total_price' => ['required', 'numeric', 'min:0'],
    //     ];
    // }


}
