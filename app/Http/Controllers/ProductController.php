<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Size;
use App\Product;
use App\Category;

class ProductController extends Controller
{

    public function search() {

        $results = Product::with('sizes')
                    ->where('title', 'LIKE', '%'.request('query').'%')->get();

        $products = $this->sortProducts($results);

        return $products;

    }


    /* Sort Products before returning a response */
    public function sortProducts($products) {

        $priceArray = [];
        $sortedProducts = [];

        // Sort individual product SIZES by price
        foreach($products as $product) {

            $sizes = $product['relations']['sizes'];

            for($i = 0; $i < count($sizes); $i++) {
                if(isset($sizes[$i + 1])) {
                    if($sizes[$i]['price'] > $sizes[$i + 1]['price']) {
                        $lowest = $sizes[$i + 1];
                        $sizes[$i + 1] = $sizes[$i];
                        $sizes[$i] = $lowest;
                    }
                }
            }

            $priceArray[$product['attributes']['id']] = $sizes[0]['price'];
        }

        // Sort PRODUCTS by price

        asort($priceArray);

        foreach($priceArray as $key => $product) {
            foreach($products as $product) {
                if($product['attributes']['id'] == $key){
                    $sortedProducts[] = $product;
                }
            }
        }

        return $sortedProducts;
    }

    public function create()
    {
        Product::create([
            'title' => request('title'),
            'description' => request('description'),
            'image' => request('image'),
            'category' => request('category'),
        ]);

        foreach(request('sizes') as $size) {
            Size::create([
                'product_id' => Product::orderBy('created_at', 'desc')->first()->id,
                'length' => $size['length'],
                'width' => $size['width'],
                'height' => $size['height'],
                'price' => $size['price']
            ]);
        }

        return 'OK';

    }

    public function update() {

        Product::find(request('id'))->sizes()->delete();
        Product::find(request('id'))->delete();

        Product::create([
            'title' => request('title'),
            'description' => request('description'),
            'image' => request('image'),
            'category' => request('category'),
        ]);

        foreach(request('sizes') as $size) {
            Size::create([
                'product_id' => Product::orderBy('created_at', 'desc')->first()->id,
                'length' => $size['length'],
                'width' => $size['width'],
                'height' => $size['height'],
                'price' => $size['price']
            ]);
        }

        return 'OK';
    }

    public function delete() {
        Product::find(request('id'))->sizes()->delete();
        Product::find(request('id'))->delete();


        foreach(Category::pluck('name')->toArray() as $category) {
            if(!in_array($category, Product::pluck('category')->toArray())) {
                Category::where('name', $category)->delete();
            }
        }


        return 'OK';

    }

    public function getByCategory() {
        $products = Product::with('sizes')->get()->where('category', request('category'));

        return $this->sortProducts($products);
    }

    public function getById() {
        $product = Product::with('sizes')->get()->where('id', request('id'));

        return $this->sortProducts($product);
    }

    public function get() {

        $products = Product::with('sizes')->get();

        // Sort sizes in ascending order by PRICE

        return $this->sortProducts($products);

    }


}
