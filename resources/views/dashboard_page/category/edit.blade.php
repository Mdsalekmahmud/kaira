<x-dashboard>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Products</h4>
            </div>

            <div class="card-body">
                <form method="POST" action="{{route('category.update',$category->id)}}" enctype="multipart/form-data">
                <div class="row">
                        @csrf
                        @method('PUT')
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="basicInput">category Name</label>
                            <input name="name" type="text" class="form-control" id="basicInput"
                               value="{{$category->name}}" placeholder="Ente Category Name">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create New category</button>
            </form>
            </div>
        </div>
    </section>
</x-dashboard>
