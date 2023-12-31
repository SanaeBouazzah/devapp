@section('title')
    | Posts
@endsection
<x-master>
    <div class="mt-3">
        @if (session('message'))
            <x-alert-message type="success">{{ session('message') }}</x-alert-message>
        @endif
    </div>


    <div class="container">
        <div class="">
            <a href="{{ route('publications.create') }}" class="btn btn-dark rounded-0 px-5 mt-3 mx-2">Create Post</a>
        </div>
        <div class="row my-4">
            @foreach ($publications as $publication)
                <div class="my-2 col-md">
                    <div class="card pb-3" style="width:300px">
                        @if ($publication->image)
                            <img class="card-img-top" src="{{ asset('../storage/' . $publication->image) }}"
                                alt="Card image" style="width:500px; height:300px;object-fit:cover;display:block;">
                        @endif
                        <div class="card-body">
                            <h4 class="card-title">{{ $publication->titre }}</h4>
                            <p class="card-text">{{ $publication->body }}</p>
                        </div>
                        @auth
                            @if (auth()->user()->id === $publication->profile_id)
                                <div class="flex justify-content-between">
                                    <a href="{{ route('publications.edit', $publication) }}"
                                        class="btn btn-dark rounded-0 px-4 mt-3 mx-2">Edit Post</a>
                                    <form action="{{ route('publications.destroy', $publication) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-dark rounded-0 px-5 mt-3 mx-2">Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                        <div class="flex align-items-center position-relative">
                          <img src="{{asset('../storage/' . $publication->profile->image)}}" alt="image"
                           width="30px" height="30px" class="m-2 rounded-circle">
                           <p>{{$publication->profile->name}}</p>
                           <a href="{{route('profiles.show', $publication->profile->id)}}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


</x-master>
