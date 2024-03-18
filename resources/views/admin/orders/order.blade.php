@extends('admin.layouts.app')
@section('title', 'Orders')
@section('content')
    <div class="card">

        @if (session('message'))
            <h1 class="text-primary">{{ session('message') }}</h1>
        @endif


        <h1>
            Products list
        </h1>
        <div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">Create</a>

        </div>
        <div>
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
                            <select class="form-control" id="select-box" data-id="{{$order->id}}" name="status" data-action="{{route('admin.orders.update', $order->id)}}" 
                            style="border: 1px solid #e91e63; padding-left: 7px;">
                                @foreach (config('orders.status') as $status)
                                <option value="{{$status}}" {{$status == $order->status ? 'selected' : ''}}>{{$status}}</option>
                                @endforeach
                            </select>
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
                            {{-- @if ($order->status == 'pending')
                            <form id="form-cancel-{{$order->id}}" action="{{ route('order.cancel', $order->id)}}">
                                <button type="submit" data-id="{{$order->id}}" class="btn btn-danger btn-cancel">Cancel</button>
                            </form>
                                
                            @endif --}}
                        </td>
                    </tr>
                        
                    @endforeach
                </tbody>
            </table>
        {{ $orders->links() }}
    </div>

</div>

@endsection

@section('script')
<script>
$(document).on('change', '#select-box', function(e) {
    let url = $(this).data('action');
    console.log("url:", url)
    let data = {
        _token: "{{ @csrf_token() }}",
        status: $(this).val()
    }
    $.post(url, data, function(res) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "success",
            showConfirmButton: false,
            timer: 1500,
        });
    })
})
</script>

@endsection
