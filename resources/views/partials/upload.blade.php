<form action="/items" method="POST" enctype="multipart/form-data" class="form">
    {{ csrf_field() }}

    <label>Name:</label>
    <input type="text" name="name" class="form-control">

    <label>Select an image:</label>
    <input type="file" name="image" class="form-control">

    <button type="submit" class="btn btn-primary">Create</button>
</form>