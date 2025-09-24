<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\Product;

use Validator;

class ProductController extends BaseController
{
    public function index(): JsonResponse
    {
        $products = Product::all();
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $product = Product::create($input);
        return $this->sendResponse($product, 'Product created successfully.', 201);
    }
    
    public function show($id): JsonResponse
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.', [], 404);
        }
        return $this->sendResponse($product, 'Product retrieved successfully.');
    }

    public function update(Request $request, $id): JsonResponse
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 422);
        }

        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->save();

        return $this->sendResponse($product, 'Product updated successfully.');
    }


    public function destroy(Product $product): JsonResponse
    {
        $product->delete();
        return $this->sendResponse([], 'Product deleted successfully.');
    }
}

/*
⠀⠀⠀⠀⠀⣀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⢀⣷⣀⢉⠒⢄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢄⡀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⣮⠃⠀⠉⢧⠈⠓⢄⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⠜⠊⡇⢸⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⡇⠀⠀⠀⠈⠁⢠⠀⢙⣤⣶⣷⣷⣦⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⠞⠀⠔⠁⠀⠈⡆⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢠⢨⠀⠀⠀⠀⠀⣠⣾⣿⡻⠿⣥⡍⠙⣿⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⠔⠁⠒⠁⠀⠀⠀⢸⡇⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢸⡐⠀⠀⠀⢠⣾⡟⠛⠃⠀⠀⠀⠈⠀⠹⣿⡄⢀⠂⠓⠒⠐⠀⠂⠂⠠⢄⡔⢁⣀⡀⠄⠀⠀⠀⡔⠰⠁⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢸⠂⠀⠀⣰⣿⠛⠀⠀⠀⡐⣀⠀⠀⠈⠀⢿⣷⡈⡄⠀⠀⠀⠀⠀⠀⠀⠀⠉⠀⠀⠈⢤⠀⠀⢠⠹⠀⡇⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢸⠀⠀⠐⠻⠃⠀⠀⠄⠀⠈⠒⠭⣒⢄⡀⠘⣿⣦⢡⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⡇⣃⢔⣗⠂⠀⠀⠀⠀⠀⠀
⠀⠀⠀⢸⠂⠀⠀⠀⠀⠐⠂⠀⠀⠀⠀⠀⠈⠑⠜⠀⢹⣿⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠠⠡⣱⠛⢍⡀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⣆⠀⠀⠀⠀⠀⠀⠀⠆⠀⠀⠀⠀⠀⠼⠀⠀⠘⢿⣧⠀⢀⣀⠀⠀⠀⠀⠀⠀⠀⠀⢀⠀⢀⠀⠀⠀⠀⣀⣨⣷⣿⠗⠀⠀⠀
⠀⠀⠀⡏⠀⠀⠀⠀⠐⠀⠀⠀⢀⠤⣒⣥⡤⡤⠤⣄⡄⠈⢿⣷⣿⡿⠁⠀⠀⠀⠀⠀⠈⠄⣾⣷⣄⣤⣴⣾⣿⢿⠛⠛⠁⠀⠀⠀⠀
⠀⠀⢸⣆⠀⢀⡔⠁⢈⠎⠀⠀⣠⣾⡿⢹⣹⠉⠻⢷⣟⣇⠈⠿⣿⠃⠀⠀⠀⠀⠀⠀⠀⠀⠈⠛⠿⠟⠋⣷⣻⣿⣓⡦⡠⠱⢢⠀⠀
⠀⠀⠸⠺⠔⠋⢀⢠⠋⠀⡀⣰⢿⢉⣿⣿⣿⣧⣦⠈⠙⢎⣷⡀⠀⠀⠀⠀⠀⠀⠀⠀⢆⠀⠀⠀⠀⠀⢸⣽⣿⣏⡟⢷⢳⠀⠃⡇⠀
⠀⠀⠀⡇⠀⠀⢠⠃⠀⠸⠐⡏⡇⢾⣿⣿⣿⡿⣬⡇⠀⠘⢼⣇⠀⠈⠀⡀⠀⠀⠀⠀⠀⠂⠀⠀⠀⠀⣏⣿⣿⣯⣿⠀⢸⠀⠀⢸⠀
⠀⠀⠀⢥⠀⠀⠘⠀⠀⠀⠐⢿⡟⣼⣿⣿⣿⣷⣿⠇⠀⢠⢸⡿⠀⠀⠀⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠸⣿⣿⣿⠏⡡⡼⠅⠀⠸⡄
⠀⠀⠀⡇⠀⠀⠁⠀⠀⠀⠀⠈⢿⢿⣧⡙⠛⠛⠁⠀⠀⣠⣿⠃⠀⠀⠀⠇⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠛⠲⠾⡝⠁⠀⡀⠀⢇
⠀⠀⠀⡃⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠐⠽⠤⢄⠤⠤⠞⠋⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡀⠀⠀⠀⠀⠀⠀⠀⡸
⠀⠀⠀⠵⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢡⠀⠀⠀⠀⠀⠀⠀⢀⠆
⠀⠀⠀⢀⠄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠠⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡀⠀⠀⠀⠀⠀⠀⠀⠈⠂⠀⠀⠀⠀⠀⢄⠞⠀
⠀⠀⠀⠐⠀⠀⠄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠀⠀⠀⠀⠀⠀⠀⠀⠠⠀⠀⠀⠀⢸⠁⠀⠀
⠀⠀⠠⡎⠀⠠⠀⠀⠀⢀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠠⠂⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⣠⠤⠒⠤⠤⢔⠂⡤⠀⠀⠀⢸⠀⠀⠀
⠀⠀⢐⡇⠀⠀⠀⠀⠀⠘⢷⢄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢶⣆⠀⠀⠁⠀⡴⠑⠁⠀⠀⠀⣆⠀⠀
⠀⢀⠎⠀⠀⠀⠀⠀⠀⠀⠈⢻⣷⣤⡀⠀⠀⢀⡀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠿⢠⣂⠜⠁⠀⠀⠀⢀⠞⠀⠀⠀
⠀⡌⠅⠀⠀⠀⠀⠀⠀⠀⠀⠀⠻⣿⣟⣦⡈⠒⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣸⠁⠀⠀⠀⠀⠀⡆⠀⠀⠀⠀
⠸⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠛⢿⣿⣶⣥⣈⠐⠀⠀⠀⠀⠀⠀⠠⠀⠀⠀⠀⠀⠀⠀⠀⣠⠣⣄⣀⡾⠐⠀⠀⠀⠀⠀⠀⠀
⣇⠄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠘⠻⣿⣿⣽⣶⡤⣢⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀⡰⠋⠀⡤⡢⠟⠃⠀⠀⠀⠀⠀⠀⠀⠀
⠉⠄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠙⠛⠿⢿⣿⣿⣿⣢⢄⣀⡀⡀⠀⠠⡤⡠⠔⠈⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⢀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⢿⣿⣯⣽⣿⣛⣍⢱⣱⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠈⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠹⣿⣙⣿⠻⡤⢿⣦⡾⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⣓⣯⣸⠿⡿⢟⠆⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠊⠉⠀⠀⢠⡸⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⣴⡳⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢀⡔⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⣄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⣠⠖⠋⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠰⣆⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠐⠁⠪⠺⡅⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⡿⣦⠀⠀⠀⠀⠂⠀⡄⠞⠱⡇⠀⠀⠀⠘⢿⡄⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⢸⡀⠀⠀⠀⠀⠀⢣⡀⠈⠹⡄⠀⠀⠀⢠⠁⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠹⣦⠀⠀⠀⠀⣏⣆⠀⠀⠘⠴⠠⠴⠗⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠈⠇⠀⢀⠀⢉⠊⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠁⠈⠈⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀⠀
*/