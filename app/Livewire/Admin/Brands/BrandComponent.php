<?php

namespace App\Livewire\Admin\Brands;

use App\Brand;
use App\Product;
use Livewire\Component;
use Livewire\WithPagination;

class BrandComponent extends Component
{
    use WithPagination;

    public $searchName = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 12;

    public $currentBrandId;
    public $name;
    
    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:brands,name,' . $this->currentBrandId],
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'nombre',
        ];
    }


    public function render()
    {
        $brands = $this->queryBrands();

        return view('livewire.admin.brands.brand-component',[
            'brands' => $brands,
            'paginationText' => $this->getPaginationText($brands),
        ]);
    }

    protected function queryBrands()
    {
        return Brand::when(
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

    protected function loadBrand($id)
    {
        $brand = Brand::findOrFail($id);
        $this->currentBrandId = $id;
        $this->name = $brand->name;
        $this->fill($brand->toArray());
    }

    public function show($id)
    {
        $this->loadBrand($id);
    }

    public function store()
    {
        $this->validate();

        Brand::create([
            'name' => $this->name,
        ]);

        $this->dispatch('toast', message: 'Marca creada correctamente.', notify: 'success');
        $this->cancel();
    }

    public function edit($id)
    {
        $this->loadBrand($id);
    }

    public function update()
    {
        $this->validate();

        $brand = Brand::find($this->currentBrandId);
        $brand->update([
            'name' => $this->name,
        ]);

        $this->dispatch('toast', message: 'Marca actualizada correctamente.', notify: 'success');
        $this->cancel();
    }

    public function delete($id)
    {
        $this->currentBrandId = $id;
    }

    public function destroy()
    {
        if (Product::where('brand_id', $this->currentBrandId)->exists()) {
            $this->dispatch('toast', message: 'No se puede eliminar la marca, ya que tiene productos asociados.', notify: 'error');
            $this->cancel();
            return;
        }
    
        Brand::destroy($this->currentBrandId);
    
        $this->dispatch('toast', message: 'Marca eliminada correctamente.', notify: 'success');
        $this->cancel();
    }
    

    protected function getPaginationText($brands)
    {
        return sprintf(
            "Mostrando %d-%d de %d registros",
            $brands->firstItem(),
            $brands->lastItem(),
            $brands->total()
        );
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function resetInputFields()
    {
        $this->reset(['name']);
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
