<?php

namespace App\Livewire\Admin\Products;

use App\Product;
use App\ProductType;
use Livewire\Component;
use App\ProductCategory;
use Livewire\WithPagination;

class ProductTypeComponent extends Component
{
    use WithPagination;

    public $searchName = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 12;

    public $currentProductTypeId;
    public $name;
    public $description;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:product_types,name,' . $this->currentProductTypeId],
            'description' => 'nullable|string|max:255',
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
        ];
    }

    public function render()
    {
        $productTypes = $this->queryProductTypes();

        return view('livewire.admin.products.product-type-component', [
            'productTypes' => $productTypes,
            'paginationText' => $this->getPaginationText($productTypes),
        ]);
    }

    protected function queryProductTypes()
    {
        return ProductType::when(
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

    protected function loadProductType($id)
    {
        $productType = ProductType::findOrFail($id);
        $this->currentProductTypeId = $id;
        $this->fill($productType->toArray());
    }

    public function show($id)
    {
        $this->loadProductType($id);
    }

    public function store()
    {
        $this->validate();

        ProductType::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $this->dispatch('toast', message: 'Tipo de producto creado correctamente.', notify: 'success');
        $this->cancel();
    }

    public function edit($id)
    {
        $this->loadProductType($id);
    }

    public function update()
    {
        $this->validate();

        $productType = ProductType::find($this->currentProductTypeId);
        $productType->update([
            'name' => $this->name,
            'description' => $this->description
        ]);

        $this->dispatch('toast', message: 'Tipo de producto actualizado correctamente.', notify: 'success');
        $this->cancel();
    }

    public function delete($id)
    {
        $this->currentProductTypeId = $id;
    }

    public function destroy()
    {
        if (ProductCategory::where('product_type_id', $this->currentProductTypeId)->exists()) {
            $this->cancel();
            return $this->dispatch('toast', message: 'No se puede eliminar el tipo de producto, ya que está asociado a categorías de producto.', notify: 'error');
        }

        if (Product::where('product_type_id', $this->currentProductTypeId)->exists()) {
            $this->cancel();
            return $this->dispatch('toast', message: 'No se puede eliminar el tipo de producto, ya que está asociado a productos.', notify: 'error');
        }

        ProductType::destroy($this->currentProductTypeId);
    
        $this->cancel();
        return $this->dispatch('toast', message: 'Tipo de producto eliminado correctamente.', notify: 'success');
    }  

    protected function getPaginationText($productTypes)
    {
        return sprintf(
            "Mostrando %d - %d de %d registros",
            $productTypes->firstItem(),
            $productTypes->lastItem(),
            $productTypes->total()
        );
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function resetInputFields()
    {
        $this->reset(['name', 'description']);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('close-modal');
    }
}
