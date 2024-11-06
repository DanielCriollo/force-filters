<?php

namespace App\Livewire\Admin\Sales;

use App\Brand;
use App\Product;
use App\Customer;
use App\SalesOrder;
use App\ProductType;
use App\SalesOrderItem;
use Livewire\Component;

class SalesProductsComponent extends Component
{
    public $searchCustomer = '';
    public $matchingCustomers = [];
    public $noResults = false;
    public $customerId;

    public $searchProduct = '';
    public $matchingProducts = [];
    public $noResultsProducts = false;
    public $productId;

    public $identification,
        $name,
        $address,
        $email,
        $phone;

    public $nameProduct,
        $descriptionProduct,
        $sku,
        $type,
        $category,
        $brand,
        $costPrice,
        $salePrice,
        $stock,
        $mainPhoto,
        $photos,
        $quantity;

    public $productsCart = [];

    public $productTypes = [];
    public $categories = [];
    public $brands = [];

    public $saleOrderId;

    public $showModals = false;

    public function mount($id = null){

        $this->showModals = false;

        $this->productTypes = ProductType::all();
        $this->brands = Brand::all();

        if($id){
            $this->saleOrderId = $id;
            $saleOrder = SalesOrder::find($id);
            $this->selectCustomer($saleOrder->customer_id);
        }

        $products = SalesOrderItem::where('sales_order_id', '=', $this->saleOrderId)->get();
        foreach($products as $product){
            $this->selectProduct($product->product_id);

            $this->productsCart[] = [
                'id' => $this->productId,
                'name' => $this->nameProduct,
                'quantity' => $product->quantity,
                'unitPrice' => $this->salePrice,
                'subtotal' => $product->quantity * $this->salePrice
            ];
    
            $this->cancel();
        }

        $this->showModals = true;
    }

    public function searchName()
    {
        if (empty($this->searchCustomer)) {
            $this->matchingCustomers = [];
            $this->noResults = false;
            return;
        }

        $this->matchingCustomers = Customer::where('name', 'like', '%' . $this->searchCustomer . '%')
            ->take(5)
            ->get();

        $this->noResults = count($this->matchingCustomers) === 0;

        if($this->noResults){
            $this->resetInputsFieldsCustomers();
            $this->customerId = '';
        }
    }

    public function searchProductName()
    {
        if (empty($this->searchProduct)) {
            $this->matchingProducts = [];
            $this->noResults = false;
            return;
        }

        $this->matchingProducts = Product::where('name', 'like', '%' . $this->searchProduct . '%')
            ->take(5)
            ->get();

        $this->noResultsProducts = count($this->matchingProducts) === 0;
    }

    public function selectProduct($productId)
    {
        $product = Product::find($productId);
        $this->searchProduct = $product->name;
        $this->matchingProducts = [];
        $this->noResultsProducts = false;

        $this->productId = $product->id;
        $this->nameProduct = $product->name;
        $this->descriptionProduct = $product->description;
        $this->sku = $product->sku;
        $this->type = $product->category->productType->name;
        $this->category = $product->category->name;
        $this->brand = $product->brand->name;
        $this->costPrice = $product->cost_price;
        $this->salePrice = $product->sale_price;
        $this->stock = $product->stock_quantity;
        $this->mainPhoto = $product->main_photo;
        $this->photos = $product->photos;

        if($this->showModals){
            $this->dispatch('toast', message: 'Producto seleccionado correctamente.', notify: 'success');
        }
    }


    public function selectCustomer($customerId)
    {
        $customer = Customer::find($customerId);
        $this->searchCustomer = $customer->name;
        $this->matchingCustomers = [];
        $this->noResults = false;

        $this->customerId = $customer->id;
        $this->identification = $customer->identification;
        $this->name = $customer->name;
        $this->address = $customer->address;
        $this->email = $customer->email;
        $this->phone = $customer->phone;

        if($this->showModals){
            $this->dispatch('toast', message: 'Cliente seleccionado exitosamente.', notify: 'success');
        }
    }

    public function render()
    {
        return view('livewire.admin.sales.sales-products-component');
    }

    public function cancel()
    {

        $this->productId = '';
        $this->nameProduct = '';
        $this->descriptionProduct = '';
        $this->sku = '';
        $this->type = '';
        $this->category = '';
        $this->brand = '';
        $this->costPrice = '';
        $this->salePrice = '';
        $this->stock = '';
        $this->mainPhoto = '';
        $this->photos = '';

        $this->noResultsProducts = false;
        $this->quantity = '';
        $this->searchProduct = '';

        $this->dispatch('close-modal');
    }


    public function addProduct()
    {

        $this->validate([
            'quantity' => 'required|numeric|min:1'
        ], [], [
            'quantity' => 'cantidad'
        ]);

        $this->productsCart[] = [
            'id' => $this->productId,
            'name' => $this->nameProduct,
            'quantity' => $this->quantity,
            'unitPrice' => $this->salePrice,
            'subtotal' => $this->quantity * $this->salePrice
        ];

        $this->cancel();

        $this->dispatch('toast', message: 'Producto agregado exitosamente.', notify: 'success');
    }

    public function store()
    {
        $this->validate([
            'productsCart' => 'required|array|min:1',
        ], [
            'productsCart.required' => 'Debe agregar al menos un producto.',
            'productsCart.min' => 'Debe agregar al menos un producto.',
        ]);
    
        $totalAmount = collect($this->productsCart)->sum('subtotal');
    
        $sale = $this->saleOrderId ? SalesOrder::find($this->saleOrderId) : new SalesOrder();
        $sale->customer_id = $this->customerId;
        $sale->order_date = now();
        $sale->total_amount = $totalAmount;
        $sale->status = 'completed';
        $sale->shipped_date = now();
        
        if ($this->saleOrderId) {

            $sale->items()->delete();
            $sale->update();
        } else {
            $sale->save();
        }
    
        foreach ($this->productsCart as $item) {
            $sale->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unitPrice'],
                'total_price' => $item['subtotal'],
            ]);
        }
    
        $message = $this->saleOrderId ? 'Venta actualizada con éxito.' : 'Venta creada con éxito.';
        $this->dispatch('toast', message: $message, notify: 'success');
    
        if (!$this->saleOrderId) {
            $this->saleOrderId = $sale->id;
        }
    }
    

    public function createCustomer()
    {
        $this->validate([
            'identification' => 'required|unique:customers,identification',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ], [], [
            'identification' => 'identificación',
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'phone' => 'teléfono',
            'address' => 'dirección',
        ]);

        $customer = new Customer();
        $customer->identification = $this->identification;
        $customer->name = $this->name;
        $customer->email = $this->email;
        $customer->phone = $this->phone;
        $customer->address = $this->address;
        $customer->save();

        $this->customerId = $customer->id;

        $this->searchCustomer = $customer->name;
        $this->matchingCustomers = [];
        $this->noResults = false;

        $this->dispatch('toast', message: 'Cliente creado y seleccionado exitosamente.', notify: 'success');
    }

    public function resetInputsFieldsCustomers()
    {
        $this->identification = '';
        $this->name = '';
        $this->address = '';
        $this->email = '';
        $this->phone = '';
    }
}
