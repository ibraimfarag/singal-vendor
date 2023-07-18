<?php

namespace App\Http\Controllers\Front;

use Illuminate\{
    Http\Request,
};

use App\{
    Models\Item,
    Models\Category,
    Http\Controllers\Controller,
};
use App\Helpers\PriceHelper;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Brand;
use App\Models\ChieldCategory;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Session;
use PhpOption\Option;

class CatalogController extends Controller
{
	public function index(Request $request)
	{

        // attribute search
        $attr_item_ids = [];
        if($request->attribute){
            $attrubutes_get = Attribute::where('name',$request->attribute)->get();
            foreach($attrubutes_get as $attr_item_id){
                $attr_item_ids[] = $attr_item_id->item_id;
            }
        }

        $option_attr_ids = [];
       
        if($request->option){
            $option_get = AttributeOption::whereIn('name',explode(',',$request->option))->get();
            foreach($option_get as $option_attr_id){
                $option_attr_ids[] = $option_attr_id->attribute_id;
            }
        }


        $option_wise_item_ids = [];
        foreach(Attribute::whereIn('id',$option_attr_ids)->get() as $attr_item_id){
            $option_wise_item_ids[] = $attr_item_id->item_id;
        }


        $sorting = $request->has('sorting') ?  ( !empty($request->sorting) ? $request->sorting : null ) : null;
        $new = $request->has('new') ?  ( !empty($request->new) ? 1 : null ) : null;
        $feature = $request->has('quick_filter') ?  ( !empty($request->quick_filter == 'feature') ? 1 : null ) : null;
        $top = $request->has('quick_filter') ?  ( !empty($request->quick_filter == 'top') ? 1 : null ) : null;
        $best = $request->has('quick_filter') ?  ( !empty($request->quick_filter == 'best') ? 1 : null ) : null;
        $brand = $request->has('brand') ?  ( !empty($request->brand) ? Brand::whereSlug($request->brand)->firstOrFail() : null ) : null;
        $search = $request->has('search') ?  ( !empty($request->search) ? $request->search : null ) : null;

        $category = $request->has('category') ? ( !empty($request->category) ? Category::whereSlug($request->category)->firstOrFail() : null ) : null;
        $subcategory = $request->has('subcategory') ? ( !empty($request->subcategory) ? Subcategory::whereSlug($request->subcategory)->firstOrFail() : null ) : null;
        $childcategory = $request->has('childcategory') ? ( !empty($request->childcategory) ? ChieldCategory::where('slug',$request->childcategory)->first() : null ) : null;
        $minPrice = $request->has('minPrice') ?  ( !empty($request->minPrice) ? PriceHelper::convertPrice($request->minPrice) : null ) : null;
        $maxPrice = $request->has('maxPrice') ?  ( !empty($request->maxPrice) ? PriceHelper::convertPrice($request->maxPrice) : null ) : null;

        $items = Item::with('category')
        ->when($category, function ($query, $category) {
            return $query->where('category_id', $category->id);
        })
        ->when($subcategory, function ($query, $subcategory) {
            return $query->where('subcategory_id', $subcategory->id);
        })
        ->when($childcategory, function ($query, $childcategory) {
            return $query->where('childcategory_id', $childcategory->id);
        })

        ->when($feature, function ($query) {
            return $query->whereIsType('feature');
        })

        ->when($new, function ($query) {
            return $query->orderby('id','desc');
        })
        ->when($top, function ($query) {
            return $query->whereIsType('top');
        })
        ->when($best, function ($query) {
            return $query->whereIsType('best');
        })

        ->when($brand, function ($query, $brand) {
            return $query->where('brand_id', $brand->id);
        })
        ->when($search, function ($query, $search) {
            return $query->whereStatus(1)->where('name', 'like', '%' . $search . '%')->orwhere('name', 'like', '%' . $search . '%');
        })
        ->when($minPrice, function($query, $minPrice) {
          return $query->where('discount_price', '>=', $minPrice);
        })

        ->when($maxPrice, function($query, $maxPrice) {
          return $query->where('discount_price', '<=', $maxPrice);
        })

        ->when($sorting, function($query, $sorting) {
            if($sorting == 'low_to_high'){
                return $query->orderby('discount_price','asc');
            }else{
                return $query->orderby('discount_price','desc');
            }

        })

        ->when($attr_item_ids, function($query, $attr_item_ids) {
          return $query->whereIn('id',$attr_item_ids);
        })
        ->when($option_wise_item_ids, function($query, $option_wise_item_ids) {
          return $query->whereIn('id',$option_wise_item_ids);
        })

        ->where('status',1)
        ->orderby('id','desc')->paginate(16);

        // attribute check
        $checkItem = Item::whereStatus(1)->get();

        $attr_array = [];
        $attr_name = [];
        foreach($checkItem as $product){
            foreach($product->attributes as $attr){
                if(!in_array($attr->name,$attr_name)){
                    $attr_array[] = $attr->id;
                    $attr_name[] = $attr->name;
                }
            }
        }

        $attrubutes =[];
        foreach($attr_array as $id){
            $attrubutes[] = Attribute::with('options')->findOrFail($id);
        }

        $blade = 'front.catalog.index';

        if($request->view_check){
            Session::put('view_catalog',$request->view_check);

        }

        if(Session::has('view_catalog')){
            $checkType = Session::get('view_catalog');
            $name_string_count = 55;
        }else{
            Session::put('view_catalog','grid');
            $checkType = Session::get('view_catalog');
            $name_string_count = 38;
        }


        if($request->ajax()) $blade = 'front.catalog.catalog';

        return view($blade,[
            'all_products' => Item::whereStatus(1)->count(),
            'feature_products' => Item::whereIsType('feature')->whereStatus(1)->count(),
            'top_products' => Item::whereIsType('top')->whereStatus(1)->count(),
            'best_products' => Item::whereIsType('best')->whereStatus(1)->count(),
            'attrubutes' => $attrubutes,
            'brand' => $brand,
            'brand' => $brand,
            'brand' => $brand,
            'items' => $items,
            'name_string_count' => $name_string_count,
            'category' => $category,
            'subcategory' => $subcategory,
            'checkType'  => $checkType,
            'brands' => Brand::withCount('items')->whereStatus(1)->get(),
            'categories' => Category::whereStatus(1)->orderby('serial','asc')->withCount(['items' => function($query) {
                $query->where('status',1);
            }])->get(),
        ]);
	}


    public function viewType($type)
    {
        Session::put('view_catalog',$type);
        return response()->json($type);
    }

}
