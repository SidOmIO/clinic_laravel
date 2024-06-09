<x-app-layout>
    <header>
        <h1>Book an Appointment</h1>
    </header>

    <section>
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <br>
            <form action="{{ route('consultations.storeRemark') }}" method="POST">
                @csrf
                <input type="hidden" id="patient_email" name="patient_email" value="{{ $patient_email }}">
                <div class="form-group">
                    <label for="title">Appointment ID</label>
                    <input type="text" class="form-control" id="appointment_id" name="appointment_id" value="{{ $appointment_id }}" readonly>
                </div>
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <textarea class="form-control" id="remark" name="remark" required></textarea>
                </div>
                <div id="dropdownContainer">
                    <div class="dropdown">
                        <label for="medication">Select Medication:</label>
                        <select name="medication[]" class="medication-select">
                            <option disabled selected>Select your medicine:-</option>
                            @foreach ($medications as $medication)
                                <option value="{{ $medication['value'] }}">{{ $medication['text'] }}</option>
                            @endforeach
                        </select>
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity[]" min="1" value="1">
                        <button type="button" class='btn btn-danger' onclick="removeDropdown(this)">Remove</button>
                    </div>
                </div>
                <button type="button" class='btn btn-secondary' onclick="addDropdown()">Add Medication</button>
                <br><br>
                <button type="submit" class='btn btn-primary btn-big'>Submit</button>
            </form>
        </div>
    </section>
    <script>
        const initialOptions = @json($medications);
        function getSelectedValues() {
            const selectedValues = [];
            const selects = document.querySelectorAll('.medication-select');
            selects.forEach(select => {
                if (select.value) {
                    selectedValues.push(select.value);
                }
            });
            return selectedValues;
        }

        function generateOptions() {
            const options = [];
            initialOptions.forEach(option => {
                options.push(`<option value="${option.value}|${option.price}">${option.text}</option>`);
            });
            return options.join('');
        }


        function addDropdown() {
            const selectedValues = getSelectedValues();
            const dropdown = document.createElement("div");
            dropdown.classList.add("dropdown");
            dropdown.innerHTML = `
                <label for="medication">Select Medication:</label>
                <select name="medication[]" class="medication-select">
                    <option disabled selected>Select your medicine:-</option>
                    ${generateOptions(selectedValues)}
                </select>
                <label for="quantity">Quantity:</label>
                <input type="number" name="quantity[]" min="1" value="1">
                <button type="button" class='btn btn-danger' onclick="removeDropdown(this)">Remove</button>
            `;
            
            document.getElementById("dropdownContainer").appendChild(dropdown);
        }

        function removeDropdown(button) {
            const dropdownContainer = document.getElementById("dropdownContainer");
            dropdownContainer.removeChild(button.parentNode);
        }
    </script>
</x-app-layout>