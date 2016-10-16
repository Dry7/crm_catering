<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Client;
use App\Repository\KitchenRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    private $products;
    private $kitchens;
    private $types;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     * @param KitchenRepository $kitchens
     * @param TypeRepository $types
     */
    public function __construct(ProductRepository $products, KitchenRepository $kitchens, TypeRepository $types)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->products = $products;
        $this->kitchens = $kitchens;
        $this->types    = $types;
    }

    /**
     * Show all products
     *
     * @return string
     */
    public function index()
    {
        $products = $this->products->with('kitchen')->with('type')->all();

        return view('products.index')
            ->with('products', $products)
            ->with('kitchens', $this->kitchens->all())
            ->with('types', $this->types->all());
    }

    /**
     * Create new product
     *
     * @return string
     */
    public function create()
    {
        $product = new Client();

        return view('products.create')
            ->with('product', $product)
            ->with('kitchens', $this->kitchens->lists('name'))
            ->with('types', $this->types->lists('name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProductRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        if ($request->file('photography')) {
            $request['photo'] = $request->file('photography')->store('public/products');
        }

        $this->products->create(
            array_where($request->except(['_token', 'photography']), function ($value) {
                return (string)$value !== '';
            })
        );

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update product
     *
     * @param $id
     * @return string
     */
    public function edit($id)
    {
        $product = $this->products->find($id);

        return view('products.update')
            ->with('product', $product)
            ->with('kitchens', $this->kitchens->lists('name'))
            ->with('types', $this->types->lists('name'));
    }

    /**
     * Save user
     *
     * @param ProductRequest $request
     * @param integer $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, $id)
    {
        if ($request->file('photography')) {
            $this->products->find($id)->photoDelete();
            $request['photo'] = $request->file('photography')->store('public/products');
        }

        $this->products->update(
            array_where($request->except(['_token', 'photography']), function ($value) {
                return (string)$value !== '';
            }),
            $id
        );

        return redirect()->route('products.index');
    }

    /**
     * Remove product
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->products->delete($id);

        return redirect()->route('products.index');
    }
}