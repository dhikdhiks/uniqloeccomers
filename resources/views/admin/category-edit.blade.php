@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>category infomation</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index')}}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.category.add')}}">
                        <div class="text-tiny">categories</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit category</div>
                </li>
            </ul>
        </div>
        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.category.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{$category->id}}">
                <fieldset class="name">
                    <div class="body-title">category Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="category name" name="name" tabindex="0" value="{{ $category->name}}" aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                <fieldset class="name">
                    <div class="body-title">category Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="category Slug" name="slug" tabindex="0" value="{{$category->slug}}" aria-required="true" required="">
                </fieldset>
                @error('slug') <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                <fieldset>
                    <div class="body-title">Upload images <span class="tf-color-1">*</span>
                    </div>
                    <div class="upload-image flex-grow">
                        @if ($category->image)
                        <div class="item" id="imgpreview">
                            <img src="{{ asset('uploads/categories/'.$category->image) }}" class="effect8" alt="">
                        </div>
                        @endif
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select <span
                                        class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit" onclick="confirmSave(event)">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
{{-- @push('scripts')
<script>
$(function(){
    // Saat file gambar dipilih
    $("#myFile").on("change", function(e){
        const [file] = this.files;
        if (file) {
            $("#imgpreview img").attr('src', URL.createObjectURL(file));
            $("#imgpreview").show();
        }
    });

    // Saat nama category diketik
    $("input[name='name']").on("change", function(){
        $("input[name='slug']").val(StringToSlug($(this).val()));
    });

    // Fungsi untuk convert nama jadi slug
    function StringToSlug(Text){
        return Text.replace(/[^\w ]+/g, '')
                   .replace(/ +/g, '-')
                   .toLowerCase();
    }
});
</script>
@endpush --}}

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // function confirmSave() {
    //     return confirm("Are you sure you want to save this category?");
    // }
    //popup
    $(function() {
        $("#myFile").on("change", function(e) {
            const photoInp = $("#myFile");
            const [file] = this.files;
            if (file) {
                $("#imgpreview img").attr('src', URL.createObjectURL(file));
                $("#imgpreview").show();
            }
        });

        $("input[name='name']").on("change", function() {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });
    });

    function StringToSlug(Text) {
        return Text.toLowerCase()
            .replace(/[^\w ]+/g, "")
            .replace(/ +/g, "-");
    }

    function confirmSave(event) {
        event.preventDefault(); // Tahan submit form

        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to save changes to this category.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit(); // Submit form kalau user klik "Yes"
            }
        });
    }
</script>
@endpush

