<x-app-layout>
    <header>
        <h2>Consultation Details</h2> 
    </header>
    <br>

    @if(session('success'))
        <div class="remark info">{{ session('success') }}</div>
    @endif

    <h2>Doctor's Remark</h2>
    <div class="remark info">
        {{ $consultation->remark }}
    </div>

    <h2>Prescription</h2>
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Medication</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescriptions as $prescription)
                <tr>
                    <td>{{ $prescription->name }}</td>
                    <td>{{ $prescription->quantity }}</td>
                    <td>RM{{ number_format($prescription->price, 2) }}</td>
                    <td>RM{{ number_format($prescription->price * $prescription->quantity, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-price">
        <strong>Total Price: RM{{ number_format($consultation->total_price, 2) }}</strong>
    </div>

    <div class="total-price">
        <strong>Payment Status: {{ $consultation->payment_id ? 'Paid' : 'Not Paid' }}</strong>
    </div>

    @if(auth()->user()->type == 'patient')
        @if(!$consultation->payment_id)
            <form action="{{ route('consultations.checkout') }}" method="post" id="checkoutForm">
                @csrf
                <input type="hidden" name="id" value="{{ $consultation->id }}">
                @foreach($prescriptions as $index => $prescription)
                    <input type="hidden" name="items[{{ $index }}][name]" value="{{ $prescription->name }}">
                    <input type="hidden" name="items[{{ $index }}][price]" value="{{ $prescription->price }}">
                    <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $prescription->quantity }}">
                @endforeach
                <button type="submit" class="btn btn-primary">Pay Now</button>
            </form>
        @else
            <form action="{{ route('invoice') }}" method="post" id="invoiceForm">
                @csrf
                <input type="hidden" name="invNo" value="{{ $consultation->payment_id }}">
                <input type="hidden" name="date" value="{{ $consultation->date }}">
                <input type="hidden" name="email" value="{{ $consultation->email }}">
                <input type="hidden" name="name" value="{{ $consultation->name }}">
                @foreach($prescriptions as $index => $prescription)
                    <input type="hidden" name="items[{{ $index }}][name]" value="{{ $prescription->medication }}">
                    <input type="hidden" name="items[{{ $index }}][price]" value="{{ $prescription->price }}">
                    <input type="hidden" name="items[{{ $index }}][quantity]" value="{{ $prescription->quantity }}">
                @endforeach
                <button type="submit" class="btn btn-primary">Download Invoice</button>
            </form>
        @endif
    @endif
</x-app-layout>
