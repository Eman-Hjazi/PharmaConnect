@extends('admin.master')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Edit Category</h1>

<form action="{{route('admin.categories.update',$category->id)}}" method="POST">
    @csrf
    @method('put')

    @include('admin.categories._form')


    <button class="btn btn-info">
        <i class="fas fa-save"></i> Updated
    </button>
</form>



@section('js')

    <script>
        function showImg(e) {
            console.log();

            const [file] = e.target.files;
            if (file) {
                preview.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection






@endsection
@section('title', 'Dashbard')
