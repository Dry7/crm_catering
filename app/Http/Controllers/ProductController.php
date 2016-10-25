<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests\ProductImportRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Client;
use App\Models\Product;
use App\Repository\CategoryRepository;
use App\Repository\KitchenRepository;
use App\Repository\ProductRepository;
use App\Repository\TypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    private $products;
    private $categories;
    private $kitchens;
    private $types;

    /**
     * Create a new controller instance.
     *
     * @param ProductRepository $products
     * @param CategoryRepository $categories
     * @param KitchenRepository $kitchens
     * @param TypeRepository $types
     */
    public function __construct(ProductRepository $products, CategoryRepository $categories, KitchenRepository $kitchens, TypeRepository $types)
    {
        $this->middleware('auth');
        $this->middleware('admin');

        $this->products = $products;
        $this->categories = $categories;
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
            ->with('kitchens', $this->kitchens->lists('name', 'id'))
            ->with('types', $this->types->lists('name', 'id'));
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
            ->with('kitchens', $this->kitchens->lists('name', 'id'))
            ->with('types', $this->types->lists('name', 'id'));
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

    public function import(ProductImportRequest $request)
    {
        $message = false;

        if ($request->file('file')) {
            $products = $this->products->lists('id', 'name')->toArray();
            $categories = $this->categories->lists('name', 'code')->toArray();

            Excel::selectSheetsByIndex(1)->load($request->file('file')->getPathname(), function ($reader) use ($products, $categories) {
                foreach ($reader->all() as $i => $item) {
                    /** Categories */
                    if (((string)trim($item->gruppa) !== '') and ((string)trim($item->nazvanie_gruppy) !== '')) {
                        $data = [
                            'code' => $item->gruppa,
                            'name' => strlen(trim($item->nazvanie_gruppy)) > 255 ? substr(trim($item->nazvanie_gruppy), 0, 255) : trim($item->nazvanie_gruppy),
                            'section1' => $this->products->getModel()->getSection($item->gruppa, 1),
                            'section2' => $this->products->getModel()->getSection($item->gruppa, 2),
                            'section3' => $this->products->getModel()->getSection($item->gruppa, 3),
                            'section4' => $this->products->getModel()->getSection($item->gruppa, 4)
                        ];
                        $this->categories->updateOrCreate(['code' => $item->gruppa], $data);
                    } elseif ((string)trim($item->nazvanie_tovara) !== '') {
                        /** Products */
                        if ((string)$item->gruppa == '') {
                            $item->gruppa = @$reader->all()[$i-1]->gruppa;
                        }
                        $data = [
                            'source' => 'file',
                            'section1' => $this->products->getModel()->getSection($item->gruppa, 1),
                            'section2' => $this->products->getModel()->getSection($item->gruppa, 2),
                            'section3' => $this->products->getModel()->getSection($item->gruppa, 3),
                            'section4' => $this->products->getModel()->getSection($item->gruppa, 4),
                            'name' => strlen(trim($item->nazvanie_tovara)) > 255 ? substr(trim($item->nazvanie_tovara), 0, 255) : trim($item->nazvanie_tovara),
                            'weight' => (int)$item->nominalnyy_ves_portsii_g,
                            'cost' => $item->sebestoimost_za_edinitsu_izmereniya_rub,
                            'markup' => $item->natsenka,
                            'price' => $item->tsena_prodazhi > 0 ? $item->tsena_prodazhi : $item->sebestoimost_za_edinitsu_izmereniya_rub * ($item->natsenka/100),
                            'type_id' => $this->products->getModel()->getType($item->gruppa)
                        ];
                        $this->products->updateOrCreate(['name' => @$data['name']], $data);
                    }
                }
            });
            $message = true;
        }

        return view('products.import')->with('message', $message);
    }
}