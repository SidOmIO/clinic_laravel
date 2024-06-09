<x-app-layout>
    <header>
        <h2>
            @if(Auth::user()->type == "patient")
                Your
            @else
                All
            @endif
            Consultations</h2>
    </header>

    <section>
        <div class="container">
            <br>
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        @if(Auth::user()->type != "patient")
                            <th>Patient's Email</th>
                        @endif
                        <th>Title</th>
                        <th>Date</th>
                        <th>Time</th>
                        @if(Auth::user()->type == "patient")
                            <th>Doctor's Remark</th>
                        @endif
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consultations as $consultation)
                        <tr>
                            @if(Auth::user()->type == "patient")
                                <td>{{ $consultation->appointment_id }}</td>
                                <td>{{ $consultation->title }}</td>
                                <td>{{ $consultation->date }}</td>
                                <td>{{ $consultation->time }}</td>
                                <td>{{ $consultation->remark }}</td>
                                <td><a href="{{ route('consultations.details', ['id' => $consultation->cid, 'email' => $consultation->email]) }}" class="btn btn-primary">View Details</a></td>
                            @else
                                <td>{{ $consultation->id }}</td>
                                <td>{{ $consultation->email }}</td>
                                <td>{{ $consultation->title }}</td>
                                <td>{{ $consultation->date }}</td>
                                <td>{{ $consultation->time }}</td>
                                @if(!$consultation->appointment_id && Auth::user()->type == "doctor")
                                    <td><a href="{{ route('consultations.remark', ['id' => $consultation->id, 'email' => $consultation->email]) }}" class="btn btn-warning">Give Remark</a></td>
                                @elseif($consultation->appointment_id)
                                    <td><a href="{{ route('consultations.details', ['id' => $consultation->cid, 'email' => $consultation->email]) }}" class="btn btn-primary">View Details</a></td>
                                @endif
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="7">No data available</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>