@extends('layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="my-4">Slider</h1>
            @if (Auth::user()->role->name == 'Admin')
            <a class="btn btn-primary mb-2" href="{{ route('slider.create') }}" role="button">Create New</a>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Caption</th>
                                <th>Image</th>
                                @if (Auth::user()->role->name == 'Admin')
                                <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sliders as $slider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $slider->title }}</td>
                                    <td>{{ $slider->caption }}</td>
                                    
                                    <td>
                                        <img src="{{ asset('storage/slider/' . $slider->image) }}" class="img-fluid" style="max-width: 100px;"
                                            alt="{{ $slider->image }}">
                                    </td>
                                    @if (Auth::user()->role->name == 'Admin')
                                    <td>
                                        <form onsubmit="return confirm('Are you sure? ');" action="{{ route('slider.destroy', $slider->id) }}" method="POST">
                                            <a href="{{ route('slider.edit', $slider->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection