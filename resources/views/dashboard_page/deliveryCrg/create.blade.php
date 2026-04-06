<x-dashboard>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create DeliveryCrg</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('deliveryCrg.store') }}" enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Location Name</label>
                                <input name="location" type="text" class="form-control" id="basicInput"
                                    placeholder="Ente Location Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Amount</label>
                                <input name="delivery_charge" type="number" class="form-control" id="basicInput"
                                    placeholder="Ente Amount">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create New DeliveryCrg</button>
                </form>
            </div>
        </div>
    </section>
</x-dashboard>
