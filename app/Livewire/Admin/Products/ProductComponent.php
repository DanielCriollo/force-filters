<?php

namespace App\Livewire\Admin\Products;

use App\Brand;
use App\Product;
use App\ProductType;
use Livewire\Component;
use App\ProductCategory;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\ProductPriceHistory;

class ProductComponent extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $searchName = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 12;

    public $currentProductId;
    public $name;
    public $description;
    public $sku;
    public $costPrice;
    public $salePrice;
    public $stockQuantity;
    public $minStockQuantity;
    public $reorderQuantity;
    public $productType;
    public $productCategory;
    public $brand;
    public $productTypeName;
    public $productCategoryName;
    public $brandName;

    public $productTypes = [];
    public $categories = [];
    public $brands = [];

    public $mainPhoto;
    public $currentImage;

    public $viewMode = 'table';

    public function toggleViewMode()
    {
        $this->viewMode = $this->viewMode === 'table' ? 'cards' : 'table';
    }

    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:products,name,' . $this->currentProductId],
            'description' => 'nullable|string|max:255',
            'sku' => 'nullable|string|max:100|unique:products,sku,' . $this->currentProductId,
            'costPrice' => 'required|numeric',
            'salePrice' => 'required|numeric',
            'stockQuantity' => 'required|integer|min:0',
            'minStockQuantity' => 'nullable|integer|min:0',
            'reorderQuantity' => 'nullable|integer|min:0',
            'productType' => 'required|exists:product_types,id',
            'productCategory' => 'required|exists:product_categories,id',
            'brand' => 'nullable|exists:brands,id',
            'mainPhoto' => 'nullable|image|max:2048',
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'sku' => 'SKU',
            'costPrice' => 'precio de costo',
            'salePrice' => 'precio de venta',
            'stockQuantity' => 'cantidad en stock',
            'minStockQuantity' => 'cantidad mínima en stock',
            'reorderQuantity' => 'cantidad de reorden',
            'productType' => 'tipo de producto',
            'productCategory' => 'categoría',
            'brand' => 'marca',
            'mainPhoto' => 'imagen',
        ];
    }

    public function mount()
    {
        $this->productTypes = ProductType::all();
        $this->brands = Brand::all();
    }

    public function render()
    {
        $products = $this->queryProducts();

        return view('livewire.admin.products.product-component', [
            'products' => $products,
            'paginationText' => $this->getPaginationText($products),
        ]);
    }

    protected function queryProducts()
    {
        return Product::when(
            $this->searchName,
            fn($query) =>
            $query->where('name', 'like', '%' . $this->searchName . '%')
        )
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public function updatedSearchName()
    {
        $this->searchName = strtolower($this->searchName);
        $this->resetPage();
    }

    protected function loadProduct($id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
    
        $this->currentProductId = $id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->sku = $product->sku;
        $this->costPrice = $product->cost_price;
        $this->salePrice = $product->sale_price;
        $this->stockQuantity = $product->stock_quantity;
        $this->minStockQuantity = $product->min_stock_quantity;
        $this->reorderQuantity = $product->reorder_quantity;
        $this->brand = $product->brand_id; 

        $this->productType = $product->category->productType->id;
        $this->updatedProductType();
        $this->productCategory = $product->product_category_id;

        $this->brandName = $product->brand->name; 
        $this->productTypeName = $product->category->productType->name;
        $this->productCategoryName = $product->category->name;
    }
    

    public function updatedProductType()
    {
        if ($this->productType) {
            $this->categories = ProductCategory::where('product_type_id', $this->productType)->get();
        } else {
            $this->categories = [];
        }

        $this->productCategory = '';
    }

    public function show($id)
    {
        $this->loadProduct($id);
    }

    public function store()
    {
        $this->validate();

        $photoPath = $this->mainPhoto ? $this->mainPhoto->store('product_photos', 'public') : null;

        $product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'cost_price' => $this->costPrice,
            'sale_price' => $this->salePrice,
            'stock_quantity' => $this->stockQuantity,
            'min_stock_quantity' => $this->minStockQuantity,
            'reorder_quantity' => $this->reorderQuantity,
            'product_type_id' => $this->productType,
            'product_category_id' => $this->productCategory,
            'brand_id' => $this->brand,
            'main_photo' => $photoPath,
        ]);

        $this->logPriceHistory($product->id, 'cost', $this->costPrice);
        $this->logPriceHistory($product->id, 'sale', $this->salePrice);


        $this->dispatch('toast', message: 'Producto creado correctamente.', notify: 'success');
        $this->cancel();
    }

    public function edit($id)
    {
        $this->loadProduct($id);
    }

    public function update()
    {
        $this->validate();

        $product = Product::find($this->currentProductId);

        $oldCostPrice = $product->cost_price;
        $oldSalePrice = $product->sale_price;

        $photoPath = $this->mainPhoto ? $this->mainPhoto->store('product_photos', 'public') : $product->main_photo;

        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'sku' => $this->sku,
            'cost_price' => $this->costPrice,
            'sale_price' => $this->salePrice,
            'stock_quantity' => $this->stockQuantity,
            'min_stock_quantity' => $this->minStockQuantity,
            'reorder_quantity' => $this->reorderQuantity,
            'product_category_id' => $this->productCategory,
            'brand_id' => $this->brand,
            'main_photo' => $photoPath,
        ]);

        if ($oldCostPrice !== $this->costPrice) {
            $this->logPriceHistory($product->id, 'cost', $this->costPrice);
        }
        if ($oldSalePrice !== $this->salePrice) {
            $this->logPriceHistory($product->id, 'sale', $this->salePrice);
        }
    
        $this->dispatch('toast', message: 'Producto actualizado correctamente.', notify: 'success');
        $this->cancel();
    }

    public function delete($id)
    {
        $this->currentProductId = $id;
    }

    public function destroy()
    {
        $product = Product::find($this->currentProductId);
    
        if ($product->salesOrdersItems()->exists()) {
            $this->dispatch('toast', message: 'No se puede eliminar el producto porque hay una orden de venta asociada.', notify: 'error');
            
            $this->cancel();
            return;
        }

        $product->priceHistories()->delete(); 

        $product->delete();
        $this->dispatch('toast', message: 'Producto eliminado correctamente.', notify: 'success');
        $this->cancel();
    }
    

    protected function getPaginationText($products)
    {
        return sprintf(
            "Mostrando %d-%d de %d registros",
            $products->firstItem(),
            $products->lastItem(),
            $products->total()
        );
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    protected function logPriceHistory($productId, $priceType, $price)
    {
        ProductPriceHistory::create([
            'product_id' => $productId,
            'price_type' => $priceType,
            'price' => $price,
            'effective_date' => now()->toDateString(),
            'created_at' => now(),
        ]);
    }

    public function resetInputFields()
    {
        $this->reset([
            'name',
            'description',
            'sku',
            'costPrice',
            'salePrice',
            'stockQuantity',
            'minStockQuantity',
            'reorderQuantity',
            'productType',
            'productCategory',
            'brand'
        ]);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('close-modal');
    }

    public function clearImage()
    {
        $this->mainPhoto = null;
    }
}
