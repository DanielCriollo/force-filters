<?php

namespace App\Livewire\Admin\Products;

use Livewire\Component;
use App\ProductCategory;
use App\ProductType;
use Livewire\WithPagination;

class ProductCategoryComponent extends Component
{
    use WithPagination;

    public $searchName = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 12;

    public $currentProductCategoryId;
    public $productTypeId;
    public $productTypeName;
    public $name;
    public $description;

    protected function rules()
    {
        return [
            'productTypeId' => 'required|exists:product_types,id',
            'name' => ['required', 'string', 'max:255', 'unique:product_categories,name,' . $this->currentProductCategoryId],
            'description' => 'nullable|string|max:255',
        ];
    }

    public function validationAttributes()
    {
        return [
            'productTypeId' => 'tipo de producto',
            'name' => 'nombre',
            'description' => 'descripción',
        ];
    }

    public function render()
    {
        $productCategories = $this->queryProductCategories();
        $productTypes = ProductType::all();

        return view('livewire.admin.products.product-category-component', [
            'productCategories' => $productCategories,
            'paginationText' => $this->getPaginationText($productCategories),
            'productTypes'=>$productTypes
        ]);
    }

    protected function queryProductCategories()
    {
        return ProductCategory::when(
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

    protected function loadProductCategory($id)
    {
        $productCategory = ProductCategory::findOrFail($id);
        $this->currentProductCategoryId = $id;
        $this->productTypeId = $productCategory->product_type_id;
        $this->productTypeName = $productCategory->productType->name;
        $this->fill($productCategory->toArray());
    }

    public function show($id)
    {
        $this->loadProductCategory($id);
    }

    public function store()
    {
        $this->validate();

        ProductCategory::create([
            'product_type_id' => $this->productTypeId,
            'name' => $this->name,
            'description' => $this->description,
        ]);

        $message = $this->currentProductCategoryId ? 'Categoría de producto actualizada correctamente' : 'Categoría de producto creada correctamente';
        $this->dispatch('alert', ['type' => 'success', 'message' => $message]);
        $this->cancel();
    }

    public function edit($id)
    {
        $this->loadProductCategory($id);
    }

    public function update()
    {
        $this->validate();

        $productCategory = ProductCategory::find($this->currentProductCategoryId);
        $productCategory->update([
            'product_type_id' => $this->productTypeId,
            'name' => $this->name,
            'description' => $this->description
        ]);

        $message = 'Categoría de producto actualizada correctamente';
        $this->dispatch('alert', ['type' => 'success', 'message' => $message]);
        $this->cancel();
    }

    public function delete($id)
    {
        $this->currentProductCategoryId = $id;
    }

    public function destroy()
    {
        ProductCategory::find($this->currentProductCategoryId)->delete();
        $this->dispatch('alert', ['type' => 'success', 'message' => 'Categoría de producto eliminada correctamente']);
        $this->cancel();
    }

    protected function getPaginationText($productCategories)
    {
        return sprintf(
            "Mostrando %d-%d de %d registros",
            $productCategories->firstItem(),
            $productCategories->lastItem(),
            $productCategories->total()
        );
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function resetInputFields()
    {
        $this->reset(['productTypeId', 'name', 'description']);
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('close-modal');
        $this->dispatch('clear-select2');
    }
}