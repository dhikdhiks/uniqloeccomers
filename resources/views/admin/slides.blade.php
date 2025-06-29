@extends('layouts.admin')
@section('content')

    <div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>Slides</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="{{ route('admin.index') }}">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">Slider</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search">
                                                <fieldset class="name">
                                                    <input type="text" placeholder="Search here..." class="" name="name"
                                                        tabindex="2" value="" aria-required="true" required="">
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button class="" type="submit"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('admin.slide.add') }}"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="wg-table table-all-user">
                                  @if (Session::has('status'))
                                    <p class="alert alert-success text-center">{{Session::get('status')}}</p>
                                        @endif
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Image</th>
                                                    <th>Tagline</th>
                                                    <th>Title</th>
                                                    <th>Subtitle</th>
                                                    <th>Link</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($slides as $slide)

                                                <tr>
                                                    <td>{{ $slide->id }}</td>
                                                    <td class="pname">
                                                        <div class="image">
                                                            <img src="{{ asset('uploads/slides') }}/{{ $slide->image }}" alt="" class="{{ $slide->title }}">
                                                        </div>
                                                    </td>
                                                    <td>{{ $slide->tagline }}</td>
                                                    <td>{{ $slide->title }}</td>
                                                    <td>{{ $slide->subtitle }}</td>
                                                    <td>{{ $slide->link }}</td>
                                                    <td>
                                                        <div class="list-icon-function">
                                                            <a href="{{ route('admin.slide.edit', ['id'=>$slide->id]) }}">
                                                                <div class="item edit">
                                                                    <i class="icon-edit-3"></i>
                                                                </div>
                                                            </a>
                                                                <form action="{{ route('admin.slide.delete', ['id'=>$slide->id]) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="item text-danger delete" onclick="confirmDelete(event)">
                                                                        <i class="icon-trash-2"></i>
                                                                    </button>
                                                                </form>

                                                        </div>
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                                        {{ $slides->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }
</script>
@endpush
@endsection
