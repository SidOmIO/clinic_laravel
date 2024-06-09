<x-app-layout>
    <header>
        <h2>Welcome {{ Auth::user()->name }}</h2>
    </header>
    <br>

    <section>
        <div class="container">
            @include('partials.flash')
            @if($type == 'patient')
                @if($nextAppointment)
                    <div class="remark info">
                        Your next appointment is on {{ $nextAppointment->date }} at {{ $nextAppointment->time }}.
                    </div>
                @else
                    <div class="remark info">
                        You have no upcoming appointment.
                    </div>
                @endif

                @if($paymentPending && count($paymentPending) > 0)
                    <div class="remark warn">
                        You have {{ count($paymentPending) }} pending payment{{ count($paymentPending) > 1 ? 's' : '' }}.
                    </div>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Consultation ID</th>
                                <th>Title</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentPending as $pending)
                                <tr>
                                    <td>{{ $pending->id }}</td>
                                    <td>{{ $pending->title }}</td>
                                    <td>{{ $pending->total_price }}</td>
                                    <td>
                                        <a href="{{ route('consultations.details', ['id' => $pending->id, 'email' => Auth::user()->email]) }}" class="btn btn-primary">View Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @elseif($type == 'doctor')
                <div class="remark warn">
                    You have {{ count($appointments) }} appointments that require your remarks.
                </div>
                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th>Appointment ID</th>
                            <th>Patient's Email</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->email }}</td>
                                <td>{{ $appointment->title }}</td>
                                <td>{{ $appointment->date }}</td>
                                <td>{{ $appointment->time }}</td>
                                <td>
                                    <a href="{{ route('consultations.remark', ['id' => $appointment->id, 'email' => $appointment->email]) }}" class="btn btn-warning">Give Remark</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </section>
</x-app-layout>
