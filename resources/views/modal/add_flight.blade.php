<div class="modal fade" id="addFlightModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Add Flight</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('flights.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Airline -->
                    <div class="form-group">
                        <label for="airline">Airline</label>
                        <input type="text" class="form-control" id="airline" name="airline" required>
                    </div>

                    <!-- Flight Number -->
                    <div class="form-group">
                        <label for="flight_number">Flight Number</label>
                        <input type="text" class="form-control" id="flight_number" name="flight_number" required>
                    </div>

                    <!-- Registasi -->
                    <div class="form-group">
                        <label for="registasi">Registasi</label>
                        <input type="text" class="form-control" id="registasi" name="registasi" step="1" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="Widebody">Widebody</option>
                            <option value="Nero">Nero</option>
                        </select>
                    </div>

                    <!-- Registasi -->
                    <div class="form-group">
                        <label for="arrival">Arrival</label>
                        <input type="datetime-local" class="form-control" id="arrival" name="arrival" step="1" required>
                    </div>

                    <!-- Time Count -->
                    <div class="form-group">
                        <label for="time_count">Time Count</label>
                        <input type="datetime-local" class="form-control" id="time_count" name="time_count" step="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
