<x-app-layout>
    <header>
        <h2>Book an Appointment</h2>
    </header>
    <br>

    <section>
        <div class="container">
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" class="form-control" id="date" name="date" min="{{ date('Y-m-d') }}" required>
                </div>
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" class="form-control" id="time" name="time" required>
                </div>
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <textarea class="form-control" id="remark" name="remark" required></textarea>
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