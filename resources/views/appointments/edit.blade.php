<x-app-layout>
<header>
            <h1>Edit Appointment</h1>
        </header>
        
        <section>
            <div class="container">
                <br>
                <form action="{{ route('appointments.update') }}" method="POST">
                    @csrf
                    <input type="hidden" id="id" name="id" value="{{ $appointment->id }}">
                    <input type="hidden" id="email" name="email" value="{{ $appointment->email }}">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $appointment->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="{{ $appointment->date }}" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" class="form-control" id="time" name="time" value="{{ $appointment->time }}" required>
                    </div>
                    <div class="form-group">
                        <label for="remark">Remark</label>
                        <textarea class="form-control" id="remark" name="remark" required>{{ $appointment->remark }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </section>

    @section('scripts')
    <script>
        // Ensure the date input cannot select a past date
        var currentDate = new Date().toISOString().split('T')[0];
        document.getElementById("date").setAttribute("min", currentDate);
    </script>
    @endsection

</x-app-layout>