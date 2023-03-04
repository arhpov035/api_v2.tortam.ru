<form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <label for="files">Upload Files:</label>
        <input type="file" class="form-control" id="files" name="files[]" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Upload</button>
</form>
