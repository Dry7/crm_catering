<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Client;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    private $products;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->products = $products;
    }

    /**
     * Show all products
     *
     * @return string
     */
    public function index()
    {
        $products = $this->products->all();

        return view('products.index')->with('products', $products);
    }

    /**
     * Create new product
     *
     * @return string
     */
    public function create()
    {
        $product = new Client();

        return view('products.create')->with('product', $product);
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
        $this->products->create($request->except(['_token']));

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

        return view('products.update')->with('product', $product);
    }

    /**
     * Save user
     *
     * @param ProductRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, $id)
    {
        $this->products->update($request->except(['_token']), $id);

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