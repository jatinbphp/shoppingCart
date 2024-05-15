@php
    $disabled = ($order->status === 'pending' || $order->status === 'shipped') && !$order->user->deleted_at ? '' : 'disabled';

    // Define classes based on status
    $statusClasses = [
        'pending' => 'text-primary', // Yellow color for pending
        'shipped' => 'text-warning', // Blue color for shipped
        'completed' => 'text-success', // Green color for completed
        'cancelled' => 'text-danger', // Red color for cancelled
    ];

    // Get the class based on the status
    $statusClass = isset($statusClasses[$order->status]) ? $statusClasses[$order->status] : '';
@endphp

<select class="form-control select2 orderStatus {{ $statusClass }}" id="status{{ $order->id }}" data-id="{{ $order->id }}" {{ $disabled }}>
    @foreach(\App\Models\Order::$allStatus as $key => $status)
        @php $selected = ($key == $order->status) ? 'selected' : ''; @endphp
        <option value="{{ $key }}" {{ $selected }}>{{ ucfirst($status) }}</option>
    @endforeach
</select>