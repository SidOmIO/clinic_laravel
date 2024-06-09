<x-app-layout>
    <header>
        <h2>{{ Auth::user()->type == "patient" ? 'Your' : 'All' }} Appointments
                @if(Auth::user()->type == 'patient')
                <a href="{{ route('appointments.add') }}" class="btn btn-primary btn-big">Book an Appointment</a>
                @endif
            </h2>
    </header>
    <br>

    <section>
        <div class="container">
            @include('partials.flash')
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        @if(Auth::user()->type == "admin") <th>Email</th> @endif
                        <th>Date</th>
                        <th>Time</th>
                        <th>Remark</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->id }}</td>
                        <td>{{ $appointment->title }}</td>
                        @if(Auth::user()->type == "admin") <td>{{ $appointment->email }}</td> @endif
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>{{ $appointment->remark }}</td>
                        <td>
                            @if(!$appointment->consultation_id)
                            <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-primary">Update</a>
                            <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            @else
                            <a href="{{ route('consultations.show', $appointment->consultation_id) }}" class="btn btn-primary">Consultation Page</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>