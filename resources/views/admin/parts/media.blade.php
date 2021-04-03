<div style="display: none;" id="media" class="popup media-popup">
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link  active" id="nav-media-tab" data-toggle="tab" href="#nav-media" role="tab" aria-controls="nav-media" aria-selected="true">Media</a>
            <a class="nav-item nav-link " id="nav-upload-tab" data-toggle="tab" href="#nav-upload" role="tab" aria-controls="nav-upload" aria-selected="false">Upload</a>
        </div>
    </nav>

    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade active show" id="nav-media" role="tabpanel" aria-labelledby="nav-media-tab">
            <h2>Media:</h2>  
            <div class="media-wrapper">
            
                <div class="media-fixed-tools">
                    <button class="btn btn-danger cancel-media">Cancel</button>
                    <button class="btn btn-primary accept-media" data-url="{{ route('loadGallery') }}">Accept</button>
                    <button class="btn btn-danger delete-media" data-url="{{ route('deleteImages') }}">Delete selected</button>
                </div>
                <div class="media-blocks">
                    @foreach ($images as $img)
                        @include('admin.parts.media-image')
                    @endforeach

                    <div class="load-more"></div>
                </div>

            </div>
        </div>

        <div class="tab-pane fade" id="nav-upload" role="tabpanel" aria-labelledby="nav-upload-tab">
            
            <form action="{{ route('upload-image') }}" method="POST" id="upload-file">
                @csrf
                <div class="form-group">
                    <label for="new-image">Load file</label>
                    <input type="file" name="image[]" multiple id="new-image" class="form-control" required>
                
                </div>
                            

                @include('admin.parts.form.button')
            </form>
        </div>
    </div>



</div>