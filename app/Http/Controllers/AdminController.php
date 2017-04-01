<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Size;
use App\SubCategory;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function manage()
    {
        if(!Auth::check()) {
            return view('sessions.create');
        }

        return view('pages.admin.manage', ['products' => (new ProductController)->get()]);
    }

    public function reset() {

        Product::truncate();
        Category::truncate();
        Size::truncate();

        $products =
        [
            [
                'id' => '1',
                'title' => '3-tė sofa su mechanizmu (Gobelenas)',
                'description' => 'Su miegojimo funkcija (140x195 cm) ir dėže patalynei. Baldą puošia dvi dekoratyvinės pagalvėlės, kurios įeina į baldo kainą. Sėdėjimo komfortą užtikrina zig-zag tipo spyruoklės. Sofai išskirtinumo suteikia medinės kojelės. Galimybė rinktis iš plačios gobeleno bei dirbtinės odos spalvų paletės. Sėdėjimo aukštis- 45 cm, gylis- 55 cm.',
                'image' => '/img/baldai_img/sofa.jpg',
                'category' => 'Sofos',
                'sizes' =>
                    [
                        [
                            'product_id' => '1',
                            'length' => '235',
                            'width' => '95',
                            'height' => '90',
                            'price' => '789'
                        ],
                        [
                            'product_id' => '1',
                            'length' => '340',
                            'width' => '95',
                            'height' => '90',
                            'price' => '919'
                        ]
                    ]
            ],
            [
                'id' => '2',
                'title' => 'Dvigulė minkšta lova (Dirbtinė oda)',
                'description' => 'Su grotelėmis ir dėže patalynei. Be čiužinio. Šiai lovai tinkančio čiužinio dydis 160x200 cm. Su 2-mis reguliuojamos padėties galvos atramomis. Galimybė rinktis iš plačios gobeleno ar dirbtinės odos spalvų paletės.',
                'image' => '/img/baldai_img/lova.jpg',
                'category' => 'Lovos',
                'sizes' =>
                    [
                        [
                            'product_id' => '2',
                            'length' => '241',
                            'width' => '176',
                            'height' => '95',
                            'price' => '849'
                        ]
                    ]
            ],
            [
                'id' => '3',
                'title' => 'Tiesus rašomasis stalas (Faneruotė)',
                'description' => 'Su reguliuojamu aukščiu: 53,5-76,5 cm, bei pasvirimo kampu. Puikus sprendimas augančio vaiko kambaryje.',
                'image' => '/img/baldai_img/stalas.jpg',
                'category' => 'Stalai',
                'sizes' =>
                    [
                        [
                            'product_id' => '3',
                            'length' => '120',
                            'width' => '70',
                            'height' => '53.5',
                            'price' => '399'
                        ]
                    ]
            ],
            [
                'id' => '4',
                'title' => 'Kėdė',
                'description' => 'Gobelenas + Medis',
                'image' => '/img/baldai_img/kede.jpg',
                'category' => 'Kėdės',
                'sizes' =>
                    [
                        [
                            'product_id' => '4',
                            'length' => '42',
                            'width' => '41',
                            'height' => '1',
                            'price' => '79'
                        ]
                    ]
            ],
            [
                'id' => '5',
                'title' => 'Sekcija (Laminatas)',
                'description' => 'Modulinę sistemą sudaro: indauja, TV spintelė, pakabinama spintelė ir spinta. Spintos viduje yra vieta drabužių kabinimui.',
                'image' => '/img/baldai_img/sekcija.jpg',
                'category' => 'Sekcijos',
                'sizes' =>
                    [
                        [
                            'product_id' => '5',
                            'length' => '280',
                            'width' => '58',
                            'height' => '198',
                            'price' => '449'
                        ],
                        [
                            'product_id' => '5',
                            'length' => '325',
                            'width' => '58',
                            'height' => '198',
                            'price' => '529'
                        ],
                        [
                            'product_id' => '5',
                            'length' => '425',
                            'width' => '58',
                            'height' => '198',
                            'price' => '649'
                        ]
                    ]
            ],
            [
                'id' => '6',
                'title' => 'Sėdmaišis',
                'description' => 'Dirbtinė oda.',
                'image' => '/img/baldai_img/sedmaisis.jpg',
                'category' => 'Sėdmaišiai',
                'sizes' =>
                    [
                        [
                            'product_id' => '6',
                            'length' => '74',
                            'width' => '74',
                            'height' => '130',
                            'price' => '69'
                        ],
                        [
                            'product_id' => '6',
                            'length' => '96',
                            'width' => '96',
                            'height' => '130',
                            'price' => '89'
                        ],
                        [
                            'product_id' => '6',
                            'length' => '121',
                            'width' => '121',
                            'height' => '130',
                            'price' => '109'
                        ]
                    ]
            ]
        ];

        foreach($products as $product) {
            Product::create([
                'id' => $product['id'],
                'title' => $product['title'],
                'description' => $product['description'],
                'image' => $product['image'],
                'category' => $product['category']
            ]);

            Category::create([
                'id' => $product['id'],
                'name' => $product['category']
            ]);

            foreach($product['sizes'] as $size) {
                Size::create([
                    'product_id' => $product['id'],
                    'length' => $size['length'],
                    'width' => $size['width'],
                    'height' => $size['height'],
                    'price' => $size['price']
                ]);
            }
        }

        return redirect('/admin');

    }

    public function create()
    {
        return view('pages.admin.create', ['message' => null]);
    }

    public function delete()
    {
        return view('pages.admin.delete');
    }

    public function update()
    {
        return view('pages.admin.update');
    }

    public function success()
    {
        return view('pages.admin.create', ['message' => 'OK']);
    }

    public function index()
    {
        // $names = Category::pluck('name');
        // $ids = Category::pluck('id');
        //
        // for($i = 1; $i <= Category::max('id'); $i++){
        //
        //     $name = Category::find($i)->name;
        //
        //     $categories[] =
        //         [
        //             'name' => $name,
        //             'id' => $i
        //         ];
        // }
        //
        return view('pages.index');
    }

}
