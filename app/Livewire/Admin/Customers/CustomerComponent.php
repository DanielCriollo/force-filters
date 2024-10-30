<?php

namespace App\Livewire\Admin\Customers;

use App\Customer;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerComponent extends Component
{
    use WithPagination;

    public $searchName = '';
    public $sortField = 'id';
    public $sortDirection = 'asc';
    public $perPage = 12;

    public $currentCustomerId;
    public $name;
    public $identification;
    public $address;
    public $phone;
    public $email;

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:customers,name,' . $this->currentCustomerId],
            'identification' => ['nullable', 'string', 'max:255', 'unique:customers,identification,' . $this->currentCustomerId],
            'address' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => ['nullable', 'email', 'max:255', 'unique:customers,email,' . $this->currentCustomerId],
        ];
    }

    public function validationAttributes()
    {
        return [
            'name' => 'nombre',
            'identification' => 'identificación',
            'address' => 'dirección',
            'phone' => 'teléfono',
            'email' => 'correo electrónico',
        ];
    }

    public function render()
    {
        $customers = $this->queryCustomers();

        return view('livewire.admin.customers.customer-component', [
            'customers' => $customers,
            'paginationText' => $this->getPaginationText($customers),
        ]);
    }

    protected function queryCustomers()
    {
        return Customer::when(
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

    public function show($id)
    {
        $customer = Customer::find($id);
        $this->name = $customer->name;
        $this->identification = $customer->identification;
        $this->address = $customer->address;
        $this->phone = $customer->phone;
        $this->email = $customer->email;
    }

    public function store()
    {
        $this->validate();

        Customer::create([
            'name' => $this->name,
            'identification' => $this->identification,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->dispatch('toast', message: 'Cliente creado correctamente.', notify: 'success');
        $this->cancel();
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $this->currentCustomerId = $id;
        $this->name = $customer->name;
        $this->identification = $customer->identification;
        $this->address = $customer->address;
        $this->phone = $customer->phone;
        $this->email = $customer->email;
    }

    public function update()
    {
        $this->validate();

        $customer = Customer::find($this->currentCustomerId);
        $customer->update([
            'name' => $this->name,
            'identification' => $this->identification,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->dispatch('toast', message: 'Cliente actualizado correctamente.', notify: 'success');
        $this->cancel();
    }

    public function delete($id)
    {
        $this->currentCustomerId = $id;
    }

    public function destroy()
    {
        $customer = Customer::find($this->currentCustomerId);
    
        if ($customer->sales()->exists()) {

            $this->dispatch('toast', message: 'No se puede eliminar el cliente porque tiene ventas asociadas.', notify: 'error');
        } else {

            $customer->delete();
            $this->dispatch('toast', message: 'Cliente eliminado correctamente.', notify: 'success');
        }
    
        $this->cancel();
    }
    

    protected function getPaginationText($customers)
    {
        return sprintf(
            "Mostrando %d - %d de %d registros",
            $customers->firstItem(),
            $customers->lastItem(),
            $customers->total()
        );
    }

    public function sortBy($field)
    {
        $this->sortDirection = ($this->sortField === $field && $this->sortDirection === 'asc') ? 'desc' : 'asc';
        $this->sortField = $field;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->identification = '';
        $this->address = '';
        $this->phone = '';
        $this->email = '';
    }

    public function cancel()
    {
        $this->resetInputFields();
        $this->resetErrorBag();
        $this->resetValidation();
        $this->dispatch('close-modal');
    }
}
