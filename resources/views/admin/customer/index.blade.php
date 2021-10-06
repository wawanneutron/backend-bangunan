@extends('layouts.app-dashboard', [
'title' => 'Data Customers'
])

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-uppercase"><i class="fas fa-users mr-3"></i>Data Customers</h6>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('admin.cetak.data.customers') }}" class=" btn btn-primary mb-4"><i
                                class="fas fa-file-pdf mr-2"></i>Cetak pdf</a>
                        {{-- <form action="{{ route('admin.customer.index') }}" method="get">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" name="q" class=" form-control" placeholder="Cari nama customer">
                                    <div class=" input-group-append">
                                        <button type="submit" class=" btn btn-primary text-uppercase" ><i class="fas fa-search mr-2"></i>cari</button>
                                    </div>
                                </div>
                            </div>
                        </form> --}}
                        <div class=" table-responsive  justify-content-center">
                            <table class=" table table-bordered" id="crudTable">
                                <thead>
                                    <tr class=" text-center">
                                        <th>Nama Customer</th>
                                        <th>Email Customer</th>
                                        <th>Tanggal Bergabung</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @forelse ($customers as $no => $customer)
                                        <tr>
                                            <td>{{ ++$no + ($customers->currentPage()-1) * $customers->perPage() }}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ dateID($customer->created_at) }}</td>
                                        </tr>
                                    @empty
                                        <div class="alert alert-danger">
                                            <p>Data Tidak Ada !</p>
                                        </div>
                                    @endforelse --}}
                                </tbody>
                            </table>
                            <div class=" text-center">
                                {{-- {{ $customers->links('vendor.pagination.bootstrap-4') }} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script>
        //  DataTables
        $(document).ready(function() {

            $('#crudTable').DataTable({
                processing: true,
                serverSide: true,
                ordering: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [{
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'at',
                        name: 'created_at',
                    },

                ],

                // dom: 'lBfrtip',
                // buttons: [
                //     'excel', 'pdf', 'copy', 'print'
                // ],
                // "lengthMenu": [
                //     [10, 25, 50, -1],
                //     [10, 25, 50, "All"]
                // ]

            });
        });
    </script>
@endpush
