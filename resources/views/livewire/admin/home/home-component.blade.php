<div>
    @section('title', 'Escritorio')
    @section('name')

    @endsection

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="d-flex align-items-end row">
                    <div class="col-lg-3 col-md-12 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/chart-success.png') }}"
                                            alt="chart success" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Ventas</span>
                                <h3 class="card-title mb-2">{{ count(App\SalesOrder::all()) }}</h3>
                                <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> Total de
                                    ventas</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-12 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/cc-warning.png') }}"
                                            alt="chart warning" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Productos</span>
                                <h3 class="card-title mb-2">{{ count(App\Product::all()) }}</h3>
                                <small class="text-warning fw-semibold"><i class="bx bx-up-arrow-alt"></i> Total de
                                    productos</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-12 col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title d-flex align-items-start justify-content-between">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('assets/img/icons/unicons/wallet.png') }}"
                                            alt="chart primary" class="rounded" />
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block mb-1">Clientes</span>
                                <h3 class="card-title mb-2">{{ count(App\Customer::all()) }}</h3>
                                <small class="text-primary fw-semibold"><i class="bx bx-up-arrow-alt"></i> Total de
                                    clientes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
