@extends('clients.layouts.app')
@section('content')
    <div class="cart-box-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-main table-responsive">
                        @if (session('message'))
                        <h1 class="text-primary">{{ session('message') }}</h1>
                        @endif
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>status</th>
                                    <th>total</th>
                                    <th>ship</th>
                                    <th>customer name</th>
                                    <th>Customer Email</th>
                                    <th>Customer Address</th>
                                    <th>Note</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr id="row-">
                                    <td >
                                        {{ $order->id}}
                                    </td>
                                    <td >
                                        {{ $order->status}}
                                    </td>
                                    <td>
                                        $ {{ number_format($order->total, 0, '', ',') }}
                                    </td>
                                    <td>
                                        {{ $order->ship }}
                                    </td>
                                    <td >
                                        {{ $order->customer_name}}
                                    </td>
                                    <td >
                                        {{ $order->customer_email}}
                                    </td>
                                    <td >
                                        {{ $order->customer_address}}
                                    </td>
                                    <td >
                                        {{ $order->note}}
                                    </td>
                                    <td >
                                        {{ $order->payment}}
                                    </td>
                                    <td >
                                        @if ($order->status == 'pending')
                                        <form id="form-cancel-{{$order->id}}" action="{{ route('order.cancel', $order->id)}}">
                                            <button type="submit" data-id="{{$order->id}}" class="btn btn-danger btn-cancel">Cancel</button>
                                        </form>
                                            
                                        @endif
                                    </td>
                                </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).on('click', '.btn-cancel', function(e) {
        console.log("e:", e)
        e.preventDefault();
        let id = $(this).data('id');
        console.log("id:", id)
        
        confirmDelete()
            .then(function() {
                $(`#form-cancel-${id}`).submit();
            })
            .catch();
    })
</script>
@endsection