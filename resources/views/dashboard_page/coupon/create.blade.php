<x-dashboard>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create DeliveryCrg</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('coupon.store') }}" enctype="multipart/form-data">
                    <div class="row">
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Code</label>
                                <input name="code" type="text" class="form-control" id="basicInput"
                                    placeholder="Ente Code">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Type</label>
                                <select name="type" class="form-select" name="category_id" required
                                    aria-label="Default select example">
                                    <option value="">Select Type</option>
                                    <option value="fixed">fixed</option>
                                    <option value="percent">percent</option>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Value</label>
                                <input name="value" type="number" class="form-control" id="basicInput"
                                    placeholder="Ente value">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Min Amount</label>
                                <input name="min_amount" type="number" class="form-control" id="basicInput"
                                    placeholder="Ente min_amount">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="basicInput">expired at </label>
                                <input name="expired_at" type="date" class="form-control" id="basicInput"
                                    placeholder="Ente expired_at">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Create New DeliveryCrg</button>
                </form>
            </div>
        </div>
    </section>
</x-dashboard>
