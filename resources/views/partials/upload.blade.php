<form action="/items" method="POST" enctype="multipart/form-data" class="form">
    {{ csrf_field() }}

    <label>Name:</label>
    <input type="text" name="name" class="form-control">

    <label>Select an image:</label>
    <input type="file" name="image" class="form-control"><br>

    <select name="category" class="form-control">
        <option value="1">Kitchen</option>
        <option value="2">Clothes</option>
    </select>
    <br><br>

    <button type="submit" class="btn btn-primary">Create</button>
</form>