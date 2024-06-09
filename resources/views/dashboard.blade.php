<x-app-layout>
    @if($type == 'doctor')
        <div class="remark warn">
            You have {{ $appointments->count() }} appointments that require your remarks.
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
    @if($type == 'patient')
        @if(isset($date) && isset($time))
            <div class="remark info">
                Your next appointment is on {{ $date }} at {{ $time }}.
            </div>
        @else
            <div class="remark info">
                You have no upcoming appointment.
            </div>
        @endif

        @if (!empty($payment_pending))
            <div class="remark warn">
                You have {{ count($payment_pending) }} pending payment.
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
                    @foreach($payment_pending as $pending)
                        <tr>
                            <td>{{ $pending['id'] }}</td>
                            <td>{{ $pending['title'] }}</td>
                            <td>{{ $pending['total_price'] }}</td>
                            <td>
                                <a href="{{ route('consultations.details', ['id' => $pending['id'], 'email' => $_SESSION['login']]) }}" class="btn btn-primary">View Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</x-app-layout>
