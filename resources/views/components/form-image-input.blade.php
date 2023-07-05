<div>
    <label for="exampleInputFile">{{ $label }}</label>
    @if(!empty($defaultImages))
        <div class="image-uploader-preview d-flex">
            @foreach($defaultImages as $image)
                <img src="{{ $image }}" alt=""
                     class="image-uploader-preview-img mr-2">
            @endforeach
        </div>
    @endif
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="exampleInputFile" name="{{ $name }}"
                {{ $multiple? 'multiple':'' }}>
            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
        </div>
    </div>
</div>
